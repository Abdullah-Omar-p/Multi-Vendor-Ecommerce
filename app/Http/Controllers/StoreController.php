<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Resources\StoreResource;
use App\Models\Store;
use App\Http\Requests\StoreStoreRequest;
use App\Http\Requests\UpdateStoreRequest;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Throwable;

class StoreController extends Controller
{
    public function list()
    {
        try {
            $storeResources = [];
            Store::with('media')->chunk(100, function ($stores) use (&$storeResources) {
                $storeResources = array_merge($storeResources, StoreResource::collection($stores)->toArray(request()));
            });

            return empty($storeResources)
                ? Helper::responseData('No Stores Found', false, null, 404)
                : Helper::responseData('Stores found', true, $storeResources, Response::HTTP_OK);
        } catch (Throwable $e) {
            return Helper::responseData('Failed to fetch stores' . $e->getMessage(), false, null, 500);
        }
    }


    public function store(StoreStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $store = Store::create($request->validated());
            $this->authorize('create', $store);

            if ($request->hasFile('media')) {
                $mimeType = $request->file('media')->getMimeType();
                MediaController::saveMedia($request, $mimeType, $store, Store::class);
            }
            $store->load('media');

            DB::commit();
            return Helper::responseData('Store Added Successfully', true, new StoreResource($store), Response::HTTP_OK);
        } catch (Throwable $e) {
            DB::rollBack();
            return Helper::responseData('Failed to add store' . $e->getMessage(), false, null, 500);
        }
    }

    public function show(int $storeId)
    {
        try {
            $store = Store::with('media')->findOrFail($storeId);
            return Helper::responseData('Store found', true, StoreResource::make($store), Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            return Helper::responseData('Store not found' . $e->getMessage(), false, null, 404);
        }
    }

    public function update(UpdateStoreRequest $request, int $storeId)
    {
        DB::beginTransaction();
        try {
            $store = Store::findOrFail($storeId);
            $this->authorize('update', $store);
            $store->update($request->validated());

            if ($request->hasFile('media')) {
                $mimeType = $request->file('media')->getMimeType();
                MediaController::updateMedia($request, $mimeType, $store, Store::class, $storeId);
            }

            DB::commit();
            return Helper::responseData('Store Updated', true, StoreResource::make($store), Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return Helper::responseData('Store not found', false, null, 404);
        } catch (Throwable $e) {
            DB::rollBack();
            return Helper::responseData('Failed to update store' . $e->getMessage(), false, null, 500);
        }
    }

    public function destroy(int $storeId)
    {
        try {
            $store = Store::findOrFail($storeId);
            $this->authorize('delete', $store);
            $store->delete();
            return Helper::responseData('Store Deleted', true, null, Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            return Helper::responseData('Store not found', false, null, 404);
        } catch (Throwable $e) {
            return Helper::responseData('Failed to delete store' . $e->getMessage(), false, null, 500);
        }
    }
}
