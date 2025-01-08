<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        \App\Models\Cart::class => \App\Policies\CartPolicy::class,
        \App\Models\Category::class => \App\Policies\CategoryPolicy::class,
        \App\Models\Comment::class => \App\Policies\CommentPolicy::class,
        \App\Models\Offer::class => \App\Policies\OfferPolicy::class,
        \App\Models\Order::class => \App\Policies\OrderPolicy::class,
        \App\Models\Product::class => \App\Policies\ProductPolicy::class,
        \App\Models\Rate::class => \App\Policies\RatePolicy::class,
        \App\Models\Store::class => \App\Policies\StorePolicy::class,
        \App\Models\User::class => \App\Policies\UserPolicy::class,

    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
