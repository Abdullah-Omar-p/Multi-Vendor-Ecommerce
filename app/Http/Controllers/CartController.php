<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Http\Requests\StoreCartRequest;
use App\Http\Requests\UpdateCartRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CartController extends Controller
{
    public function list()
    {
        $cartResources = [];
        Cart::chunk(100, function($carts) use (&$cartResources) {
            $cartResources = array_merge($cartResources, CartResource::collection($carts)->toArray(request()));
        });
        if (empty($cartResources)) {
            return Helper::responseData('No Carts Found', false, null, 404);
        }
        return Helper::responseData('Carts found', true, $cartResources, 200);
    }


    public function store(StoreCartRequest $request)
    {
        $user = auth('sanctum')->user();
        $input [] = $request;
        $input ['user_id'] = $user->id;
        $cart = Cart::create($input);
        return Helper::responseData('Cart Added Successfully', true, new CartResource($cart), 200);
    }

    public function show(int $cartId)
    {
        $cart = Cart::findOrFail($cartId);
        return Helper::responseData('Success', true, CartResource::make($cart), 200);
    }

}
