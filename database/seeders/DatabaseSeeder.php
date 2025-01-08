<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\CartProduct;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Media;
use App\Models\Offer;
use App\Models\OfferProduct;
use App\Models\OfferUser;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\Rate;
use App\Models\Store;
use App\Models\StoreUser;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        $superAdminRole = Role::create(['name' => 'super-admin']);
        $superAdminAssistant = Role::create(['name' => 'super-admin-assistant']);
        $storeOwner = Role::create(['name' => 'store-owner']);
        $storeOwnerAssistant = Role::create(['name'=>'store-owner-assistant']);
        $customer = Role::create(['name'=>'customer']);

        $superAdmin__ = \App\Models\User::updateOrCreate([
            'email' => 'superadmin@test.com',
        ],[
            'f_name' => 'Test SuperAdmin',
            'phone' => '4924802434',
            'password'=>bcrypt(123456)
        ]);
        $superAdmin__->assignRole('super-admin');

        // Customer
        $customer__ = \App\Models\User::updateOrCreate([
            'email' => 'customer@test.com',
        ],[
            'f_name' => 'Test Customer',
            'phone' => '4924802434',
            'password'=>bcrypt(123456)
        ]);
        $customer__->assignRole('customer');

        // super admin assistant
        $superAdminAssistant__ = \App\Models\User::updateOrCreate([
            'email' => 'superadminassistant@test.com',
        ],[
            'f_name' => 'Test SuperAdmin Assistant',
            'phone' => '4924802434',
            'password'=>bcrypt(123456)
        ]);
        $superAdminAssistant__->assignRole('super-admin-assistant');

        // store owner
        $storeOwner__ = \App\Models\User::updateOrCreate([
            'email' => 'storeowner@test.com',
        ],[
            'f_name' => 'Test store owner',
            'phone' => '4924802434',
            'password'=>bcrypt(123456)
        ]);
        $storeOwner__->assignRole('store-owner');


        // store owner assistant
        $storeOwnerAssistant__ = \App\Models\User::updateOrCreate([
            'email' => 'storeownerassistant@test.com',
        ],[
            'f_name' => 'Test store owner assistant',
            'phone' => '4924802434',
            'password'=>bcrypt(123456)
        ]);
        $storeOwnerAssistant__->assignRole('store-owner-assistant');


        Category::factory(40)->create();
        User::factory(50)->create();
        $stores = Store::factory(7)->create();
        $offers = Offer::factory(100)->create();
        Product::factory(200)->create();
        Comment::factory(150)->create();
        Order::factory(100)->create();
        Media::factory(50)->create();
        Rate::factory(110)->create();

        OrderProduct::factory(100)->create();
        OfferUser::factory(100)->create();
        OfferProduct::factory(100)->create();
        StoreUser::factory(100)->create();
//        CartProduct::factory(100)->create();

        $carts = \App\Models\Cart::factory(50)->create();

        foreach ($carts as $cart) {
            $product_ids = [];
            $product_ids[] = Product::all()->random()->id;
            $product_ids[] = Product::all()->random()->id;
            $product_ids[] = Product::all()->random()->id;
            $cart->Products()->sync($product_ids);
        }


//        foreach ($stores as $store) {
//            $user_ids = [];
//            $user_ids[] = User::all()->random()->id;
//            $user_ids[] = User::all()->random()->id;
//            $user_ids[] = User::all()->random()->id;
//            $store->Admins()->sync($user_ids);
//        }

//        foreach ($offers as $offer) {
//            $product_ids = [];
//            $product_ids[] = Product::all()->random()->id;
//            $product_ids[] = Product::all()->random()->id;
//            $product_ids[] = Product::all()->random()->id;
//            $offer->products()->sync($product_ids);
//        }
//
//        foreach ($offers as $offer) {
//            $user_ids = [];
//            $user_ids[] = User::all()->random()->id;
//            $user_ids[] = User::all()->random()->id;
//            $user_ids[] = User::all()->random()->id;
//            $offer->users()->sync($user_ids);
//        }
    }
}
