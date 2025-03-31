<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Resources\RateResource;
use App\Models\Rate;
use App\Http\Requests\StoreRateRequest;
use App\Http\Requests\UpdateRateRequest;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Throwable;

class RateController extends Controller
{
    public function list()
    {
        try {
            $rateResources = [];
            Rate::chunk(100, function ($rates) use (&$rateResources) {
                $rateResources = array_merge($rateResources, RateResource::collection($rates)->toArray(request()));
            });

            return empty($rateResources)
                ? Helper::responseData('No Rates Found', false, null, 404)
                : Helper::responseData('Rates found', true, $rateResources, Response::HTTP_OK);
        } catch (Throwable $e) {
            return Helper::responseData('Failed to fetch rates' .' '. $e->getMessage(), false, null, 500);
        }
    }

    public function store(StoreRateRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $data['user_id'] = auth('sanctum')->id();
            $rate = Rate::create($data);
            $this->authorize('create', $rate);

            DB::commit();
            return Helper::responseData('Rate Added Successfully', true, new RateResource($rate), Response::HTTP_OK);
        } catch (Throwable $e) {
            DB::rollBack();
            return Helper::responseData('Failed to add rate' .' '. $e->getMessage(), false, null, 500);
        }
    }

    public function show(int $rateId)
    {
        try {
            $rate = Rate::findOrFail($rateId);
            return Helper::responseData('Rate found', true, RateResource::make($rate), Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            return Helper::responseData('Rate not found', false, null, 404);
        } catch (Throwable $e) {
            return Helper::responseData('Failed to fetch rate' .' '. $e->getMessage(), false, null, 500);
        }
    }

    public function update(UpdateRateRequest $request, int $rateId)
    {
        try {
            $rate = Rate::findOrFail($rateId);
            $this->authorize('update', $rate);
            $rate->update($request->validated());
            return Helper::responseData('Rate Updated', true, RateResource::make($rate), Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            return Helper::responseData('Rate not found', false, null, 404);
        } catch (Throwable $e) {
            return Helper::responseData('Failed to update rate' .' '. $e->getMessage(), false, null, 500);
        }
    }

    public function destroy(int $rateId)
    {
        try {
            $rate = Rate::findOrFail($rateId);
            $this->authorize('delete', $rate);
            $rate->delete();

            return Helper::responseData('Rate Deleted', true, null, Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            return Helper::responseData('Rate not found', false, null, 404);
        } catch (Throwable $e) {
            return Helper::responseData('Failed to delete rate' .' '. $e->getMessage(), false, null, 500);
        }
    }
}
