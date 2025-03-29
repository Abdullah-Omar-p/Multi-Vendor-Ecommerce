<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Throwable;

class ProductController extends Controller
{
    public function list()
    {
        try {
            $productResources = [];
            Product::with('media')->chunk(100, function($products) use (&$productResources) {
                $productResources = array_merge($productResources, ProductResource::collection($products)->toArray(request()));
            });

            return empty($productResources)
                ? Helper::responseData('No Products Found', false, null, 404)
                : Helper::responseData('Products found', true, $productResources, Response::HTTP_OK);
        } catch (Throwable $e) {
            return Helper::responseData('Failed to fetch products' . $e->getMessage(), false, null, 500);
        }
    }

    public function store(StoreProductRequest $request)
    {
        // TODO : Make This Accept Multiple Images Not Just One ..
        DB::beginTransaction();
        try {
            $product = Product::create($request->validated());
            $this->authorize('create', $product);

            if ($request->hasFile('media')) {
                $mimeType = $request->file('media')->getMimeType();
                MediaController::saveMedia($request, $mimeType, $product, Product::class);
            }
            $product->load('media');

            DB::commit();
            return Helper::responseData('Product Added Successfully', true, new ProductResource($product), Response::HTTP_OK);
        } catch (Throwable $e) {
            DB::rollBack();
            return Helper::responseData('Failed to add product: ' . $e->getMessage(), false, null, 500);
        }
    }


    public function show(int $productId)
    {
        try {
            $product = Product::with('media')->findOrFail($productId);
            return Helper::responseData('Product found', true, ProductResource::make($product), Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            return Helper::responseData('Product not found', false, null, 404);
        } catch (Throwable $e) {
            return Helper::responseData('Failed to fetch product' . $e->getMessage(), false, null, 500);
        }
    }

    public function update(UpdateProductRequest $request, int $productId)
    {
        // TODO : Make This Accept Multiple Images Not Just 1 ..
        DB::beginTransaction();
        try {
            $product = Product::with('media')->findOrFail($productId);
            $this->authorize('update', $product);
            $product->update($request->validated());

            if ($request->hasFile('media')) {
                $mimeType = $request->file('media')->getMimeType();
                MediaController::updateMedia($request, $mimeType, $product, Product::class, $productId);
            }

            DB::commit();
            return Helper::responseData('Product Updated', true, ProductResource::make($product), Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return Helper::responseData('Product not found', false, null, 404);
        } catch (Throwable $e) {
            DB::rollBack();
            return Helper::responseData('Failed to update product' . $e->getMessage(), false, null, 500);
        }
    }

    public function destroy(int $productId)
    {
        try {
            $product = Product::findOrFail($productId);
            $this->authorize('delete', $product);
            $product->delete();
            return Helper::responseData('Product Deleted', true, null, Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            return Helper::responseData('Product not found', false, null, 404);
        } catch (Throwable $e) {
            return Helper::responseData('Failed to delete product' . $e->getMessage(), false, null, 500);
        }
    }
}
