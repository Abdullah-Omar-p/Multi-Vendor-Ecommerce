<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Resources\OfferResource;
use App\Models\Offer;
use App\Http\Requests\StoreOfferRequest;
use App\Http\Requests\UpdateOfferRequest;
use Illuminate\Http\Response;

class OfferController extends Controller
{
    public function list()
    {
        $offerResources = [];
        Offer::with('media')->chunk(100, function ($offers) use (&$offerResources) {
            $offerResources = array_merge($offerResources, OfferResource::collection($offers)->toArray(request()));
        });
        if (empty($offerResources)) {
            return Helper::responseData('No Offers Found', false, null, 404);
        }
        return Helper::responseData('Offers found', true, $offerResources, Response::HTTP_OK);
    }

    public function store(StoreOfferRequest $request)
    {
        $input = [];
        $input = $request;
        $input ['status'] = 'active';
        $offer = Offer::create($input->validated());
        $this->authorize('create', $offer);
        if ($input->hasFile('media')) {
            $mimeType = $request->file('media')->getMimeType();
            MediaController::saveMedia($request, $mimeType, $offer, Offer::class);
        }
        return Helper::responseData('Offer Added Successfully', true, new OfferResource($offer), Response::HTTP_OK);
    }

    public function show(int $offerId)
    {
        $offer = Offer::with('media')->findOrFail($offerId);
        return Helper::responseData('Offer found', true, OfferResource::make($offer), Response::HTTP_OK);
    }

    public function update(UpdateOfferRequest $request, int $offerId)
    {
        $offer = Offer::findOrFail($offerId);
        $this->authorize('update', $offer);
        $offer->update($request->validated());
        if ($request->hasFile('media')) {
            $mimeType = $request->file('media')->getMimeType();
            MediaController::updateMedia($request, $mimeType, $offer, Offer::class, $offerId);
        }
        return Helper::responseData('Offer Updated', true, OfferResource::make($offer), Response::HTTP_OK);
    }

    public function destroy(int $offerId)
    {
        $offer = Offer::findOrFail($offerId);
        $this->authorize('delete', $offer);
        $offer->delete();
        return Helper::responseData('Offer Deleted', true, null, Response::HTTP_OK);
    }
}
