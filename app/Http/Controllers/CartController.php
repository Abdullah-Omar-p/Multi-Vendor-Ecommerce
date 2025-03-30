<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use Throwable;

class CartController extends Controller
{
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
            return Helper::responseData('Failed to fetch carts', false, null, 500);
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
            return Helper::responseData('Failed to fetch cart', false, null, 500);
        }
    }

}
