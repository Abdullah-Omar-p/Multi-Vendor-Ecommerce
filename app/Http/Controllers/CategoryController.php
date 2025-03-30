<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Throwable;

class CategoryController extends Controller
{
    public function list()
    {
        try {
            $categoryResources = [];
            Category::with('media')->chunk(100, function($categories) use (&$categoryResources) {
                $categoryResources = array_merge($categoryResources, CategoryResource::collection($categories)->toArray(request()));
            });

            return empty($categoryResources)
                ? Helper::responseData('No Categories Found', false, null, 404)
                : Helper::responseData('Categories found', true, $categoryResources, Response::HTTP_OK);
        } catch (Throwable $e) {
            return Helper::responseData('Failed to fetch categories', false, null, 500);
        }
    }

    public function store(StoreCategoryRequest $request)
    {
        DB::beginTransaction();
        try {
            $category = Category::create($request->validated());
            $this->authorize('create', $category);

            if ($request->hasFile('media')) {
                $mimeType = $request->file('media')->getMimeType();
                MediaController::saveMedia($request, $mimeType, $category, Category::class);
            }

            DB::commit();
            return Helper::responseData('Category Added Successfully', true, new CategoryResource($category), Response::HTTP_OK);
        } catch (Throwable $e) {
            DB::rollBack();
            return Helper::responseData('Failed to add category', false, null, 500);
        }
    }

    public function show(int $categoryId)
    {
        try {
            $category = Category::with('media')->findOrFail($categoryId);
            return Helper::responseData('Category found', true, CategoryResource::make($category), Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            return Helper::responseData('Category not found', false, null, 404);
        } catch (Throwable $e) {
            return Helper::responseData('Failed to fetch category', false, null, 500);
        }
    }

    public function update(UpdateCategoryRequest $request, int $categoryId)
    {
        DB::beginTransaction();
        try {
            $category = Category::with('media')->findOrFail($categoryId);
            $this->authorize('update', $category);
            $category->update($request->validated());

            if ($request->hasFile('media')) {
                $mimeType = $request->file('media')->getMimeType();
                MediaController::updateMedia($request, $mimeType, $category, Category::class, $categoryId);
            }

            DB::commit();
            return Helper::responseData('Category Updated', true, CategoryResource::make($category), Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return Helper::responseData('Category not found', false, null, 404);
        } catch (Throwable $e) {
            DB::rollBack();
            return Helper::responseData('Failed to update category', false, null, 500);
        }
    }

    public function destroy(int $categoryId)
    {
        try {
            $category = Category::findOrFail($categoryId);
            $this->authorize('delete', $category);
            $category->delete();
            return Helper::responseData('Category Deleted', true, null, Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            return Helper::responseData('Category not found', false, null, 404);
        } catch (Throwable $e) {
            return Helper::responseData('Failed to delete category', false, null, 500);
        }
    }
}
