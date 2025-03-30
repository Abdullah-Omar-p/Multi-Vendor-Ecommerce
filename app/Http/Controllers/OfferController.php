<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Resources\OfferResource;
use App\Models\Offer;
use App\Http\Requests\StoreOfferRequest;
use App\Http\Requests\UpdateOfferRequest;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Throwable;

class OfferController extends Controller
{
    public function list()
    {
        try {
            $offerResources = [];
            Offer::with('media')->chunk(100, function ($offers) use (&$offerResources) {
                $offerResources = array_merge($offerResources, OfferResource::collection($offers)->toArray(request()));
            });

            return empty($offerResources)
                ? Helper::responseData('No Offers Found', false, null, 404)
                : Helper::responseData('Offers found', true, $offerResources, Response::HTTP_OK);
        } catch (Throwable $e) {
            return Helper::responseData('Failed to fetch offers', false, null, 500);
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
            return Helper::responseData('Failed to add offer', false, null, 500);
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
            return Helper::responseData('Failed to fetch offer', false, null, 500);
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
            return Helper::responseData('Failed to update offer', false, null, 500);
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
            return Helper::responseData('Failed to delete offer', false, null, 500);
        }
    }
}
