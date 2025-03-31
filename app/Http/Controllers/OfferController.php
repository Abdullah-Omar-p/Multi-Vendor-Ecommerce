<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Resources\OfferResource;
use App\Http\Resources\ProductResource;
use App\Models\Offer;
use App\Http\Requests\StoreOfferRequest;
use App\Http\Requests\UpdateOfferRequest;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Throwable;

class OfferController extends Controller
{
    public function getOrdersForOffer(int $offerId)
    {
        try {
            $offer = Offer::with('orders')->findOrFail($offerId);
            if (!$offer->orders) {
                return Helper::responseData('No orders found for this offer', false, [], 404);
            }
            return Helper::responseData('Orders for the offer found', true, $offer->orders, Response::HTTP_OK
            );
        } catch (ModelNotFoundException $e) {
            return Helper::responseData('Offer not found', false, null, 404);
        } catch (Throwable $e) {
            return Helper::responseData('Failed to fetch orders for the offer ' . $e->getMessage(), false, null, 500);
        }
    }

    public function getProductsForOffer(int $offerId)
    {
        try {
            $products = [];
            Offer::with('products.media')->find($offerId)?->products->each(function ($product) use (&$products) {
                $products[] = ProductResource::make($product)->toArray(request());
            });
            if (!$products){
                return Helper::responseData('No Products Found for this Offer', false, null, Response::HTTP_NOT_FOUND);
            }
            return Helper::responseData('Offer products found', true, $products, Response::HTTP_OK);
        } catch (Throwable $e) {
            return Helper::responseData('Failed to fetch offer products' . ' ' . $e->getMessage(), false, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function list()
    {
        try {
            $offerResources = [];
            Offer::with('media')->chunk(100, function ($offers) use (&$offerResources) {
                $offerResources = array_merge($offerResources, OfferResource::collection($offers)->toArray(request()));
            });
            if (!$offerResources){
                return Helper::responseData('No Offers Found', false, null, Response::HTTP_NOT_FOUND);
            }
            Helper::responseData('Offers found', true, $offerResources, Response::HTTP_OK);
        } catch (Throwable $e) {
            return Helper::responseData('Failed to fetch offers' .' '. $e->getMessage(), false, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(StoreOfferRequest $request)
    {
        DB::beginTransaction();
        try {
            $input = $request->validated();
            $input['status'] = 'active';
            $offer = Offer::create($input);
            $this->authorize('create', $offer);

            if ($request->hasFile('media')) {
                $mimeType = $request->file('media')->getMimeType();
                MediaController::saveMedia($request, $mimeType, $offer, Offer::class);
            }

            $offer->load('media');
            DB::commit();
            return Helper::responseData('Offer Added Successfully', true, new OfferResource($offer), Response::HTTP_OK);
        } catch (Throwable $e) {
            DB::rollBack();
            return Helper::responseData('Failed to add offer' .' '. $e->getMessage(), false, null, 500);
        }
    }

    public function show(int $offerId)
    {
        try {
            $offer = Offer::with('media')->findOrFail($offerId);
            return Helper::responseData('Offer found', true, OfferResource::make($offer), Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            return Helper::responseData('Offer not found', false, null, 404);
        } catch (Throwable $e) {
            return Helper::responseData('Failed to fetch offer' .' '. $e->getMessage(), false, null, 500);
        }
    }

    public function update(UpdateOfferRequest $request, int $offerId)
    {
        DB::beginTransaction();
        try {
            $offer = Offer::with('media')->findOrFail($offerId);
            $this->authorize('update', $offer);
            $offer->update($request->validated());

            if ($request->hasFile('media')) {
                $mimeType = $request->file('media')->getMimeType();
                MediaController::updateMedia($request, $mimeType, $offer, Offer::class, $offerId);
            }

            DB::commit();
            return Helper::responseData('Offer Updated', true, OfferResource::make($offer), Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return Helper::responseData('Offer not found', false, null, 404);
        } catch (Throwable $e) {
            DB::rollBack();
            return Helper::responseData('Failed to update offer' .' '. $e->getMessage(), false, null, 500);
        }
    }

    public function destroy(int $offerId)
    {
        try {
            $offer = Offer::findOrFail($offerId);
            $this->authorize('delete', $offer);
            $offer->delete();
            return Helper::responseData('Offer Deleted', true, null, Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            return Helper::responseData('Offer not found', false, null, 404);
        } catch (Throwable $e) {
            return Helper::responseData('Failed to delete offer' .' '. $e->getMessage(), false, null, 500);
        }
    }

}
