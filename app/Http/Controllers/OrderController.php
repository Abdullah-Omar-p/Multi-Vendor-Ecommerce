<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use Carbon\Carbon;
use Illuminate\Http\Response;

class OrderController extends Controller
{
    public function list()
    {
        $orderResources = [];
        Order::chunk(100, function($orders) use (&$orderResources) {
            $orderResources = array_merge($orderResources, OrderResource::collection($orders)->toArray(request()));
        });
        if (empty($orderResources)) {
            return Helper::responseData('No Orders Found', false, null, 404);
        }
        return Helper::responseData('Orders found', true, $orderResources, Response::HTTP_OK);
    }

    public function store(StoreOrderRequest $request)
    {
        $input = $request->validated();
        $input ['status'] = 1;
        $input ['user_id'] = auth('sanctum')->id();
        $input['trans_date'] = Carbon::now()->addDays(3);
        $order = Order::create($input);
        $this->authorize('create', $order);

        // .. product id is not required coz order can contain OFFER only , So should check if presented..
        $request->has('product_id') ? $order->products()->sync($request->input('product_id')) : null;

        // .. Get The Count Of Products If Order Contains Products Not Offer ..
        $productCount = count((array) $request->input('product_id'));
        $productCount = $productCount > 0 ? $productCount : 'offer';
        $order['no_pieces'] = $productCount;

        return Helper::responseData('Order Created Successfully', true, new OrderResource($order), Response::HTTP_OK);
    }

    public function show(int $orderId)
    {
        $order = Order::findOrFail($orderId);
        return Helper::responseData('Order found', true, OrderResource::make($order), Response::HTTP_OK);
    }

    public function cancel(int $orderId)
    {
        $order = Order::findOrFail($orderId);
        $this->authorize('delete', $order);
        $order->delete();
        return Helper::responseData('Order Deleted', true, null, Response::HTTP_OK);
    }
}
