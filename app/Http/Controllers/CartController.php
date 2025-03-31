<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use Throwable;

class CartController extends Controller
{
    // TODO: Dont Forget To Remove Logging Error Message From Response For Production For All Controllers ..
    public function list()
    {
        try {
            $cartResources = [];
            Cart::chunk(100, function ($carts) use (&$cartResources) {
                $cartResources = array_merge($cartResources, CartResource::collection($carts)->toArray(request()));
            });

            return empty($cartResources)
                ? Helper::responseData('No Carts Found', false, null, 404)
                : Helper::responseData('Carts found', true, $cartResources, 200);
        } catch (Throwable $e) {
            return Helper::responseData('Failed to fetch carts' .' '. $e->getMessage(), false, null, 500);
        }
    }

    public function show()
    {
        try {
            $user = auth('sanctum')->user();
            $cart = $user->cart()->with('products')->first();

            if (!$cart) {
                return Helper::responseData('Cart not found', false, null, 404);
            }

            return Helper::responseData('Success', true, [
                'cart' => new CartResource($cart),
                'products' => $cart->products,
            ], 200);
        } catch (Throwable $e) {
            return Helper::responseData('Failed to fetch cart' .' '. $e->getMessage(), false, null, 500);
        }
    }

}
