<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Resources\StoreResource;
use App\Models\Store;
use App\Http\Requests\StoreStoreRequest;
use App\Http\Requests\UpdateStoreRequest;
use Illuminate\Http\Response;

class StoreController extends Controller
{
    public function list()
    {
        $storeResources = [];
        Store::chunk(100, function ($stores) use (&$storeResources) {
            $storeResources = array_merge($storeResources, StoreResource::collection($stores)->toArray(request()));
        });
        if (empty($storeResources)) {
            return Helper::responseData('No Stores Found', false, null, 404);
        }
        return Helper::responseData('Stores found', true, $storeResources, Response::HTTP_OK);
    }

    public function store(StoreStoreRequest $request)
    {
        $store = Store::create([
            'name' => $request->input('name'),
            'description' => $request->input('description', null),
            'user_id' => auth('sanctum')->id(),
            'location' => $request->input('location', null),
        ]);
        $this->authorize('create', $store);

        return Helper::responseData('Store Added Successfully', true, new StoreResource($store), Response::HTTP_OK);
    }

    public function show(int $storeId)
    {
        $store = Store::findOrFail($storeId);
        return Helper::responseData('Store found', true, StoreResource::make($store), Response::HTTP_OK);
    }

    public function update(UpdateStoreRequest $request, int $storeId)
    {
        $store = Store::findOrFail($storeId);
        $this->authorize('update', $store);
        $store->update($request->validated());
        return Helper::responseData('Store Updated', true, StoreResource::make($store), Response::HTTP_OK);
    }

    public function destroy(int $storeId)
    {
        $store = Store::findOrFail($storeId);
        $this->authorize('delete', $store);
        $store->delete();

        return Helper::responseData('Store Deleted', true, null, Response::HTTP_OK);
    }
}
