<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\RolePermissionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('auth')->namespace('App\Http\Controllers\AuthControllers')->group(function () {
    // dd(SignUpController::class);
    Route::post('logout', 'LogoutController@logout');
    Route::post('login', 'LoginController@loginUser')->name('login');
    Route::post('register','SignUpController@signup');
    Route::post('delete-account', 'DeleteAccountController@index');
    Route::post('check-email','SignUpController@checkEmail');
    Route::post('password/email', 'PasswordResetLinkController@store');
    Route::post('password/reset', 'NewPasswordController@store');
});

Route::prefix('permissions')->group(function (){
    Route::get('/', [RolePermissionController::class, 'permissions']);
    Route::get('/roles', [RolePermissionController::class, 'roles']);
    Route::post('permissions/create-role', [RolePermissionController::class, 'createRole']);
    Route::post('permissions/assign-permissions-to-role', [RolePermissionController::class, 'assignPermissionsToRole']);
    Route::post('permissions/assign-role-to-user', [RolePermissionController::class, 'assignRoleToUser']);
    Route::post('permissions/remove-role-from-user', [RolePermissionController::class, 'removeRoleFromUser']);
    Route::post('permissions/revoke-permissions-from-role', [RolePermissionController::class, 'revokePermissionsFromRole']);
    Route::get('permissions/check-user-roles-permissions/{userId}', [RolePermissionController::class, 'checkUserRolesPermissions']);
    Route::get('permissions/list-users-by-role/{roleName}', [RolePermissionController::class, 'listUsersByRole']);

});

Route::prefix('cart')->group(function (){
    Route::get('/', [CartController::class, 'list']);
    Route::post('create', [CartController::class, 'store']);
    Route::get('find/{cartId}' , [CartController::class, 'show']);
});

Route::prefix('category')->middleware('auth:sanctum')->group(function (){
    Route::get('/', [CategoryController::class, 'list']);
    Route::post('create', [CategoryController::class, 'store']);
    Route::get('find/{categoryId}' , [CategoryController::class, 'show']);
    Route::post('update/{categoryId}', [CategoryController::class, 'update']);
    Route::get('delete/{id}',[CategoryController::class, 'destroy']);
});
Route::prefix('comment')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [CommentController::class, 'list']);
    Route::post('create', [CommentController::class, 'store']);
    Route::get('find/{commentId}', [CommentController::class, 'show']);
    Route::post('update/{commentId}', [CommentController::class, 'update']);
    Route::get('delete/{commentId}', [CommentController::class, 'destroy']);
});

Route::prefix('offer')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [OfferController::class, 'list']);
    Route::post('create', [OfferController::class, 'store']);
    Route::get('find/{offerId}', [OfferController::class, 'show']);
    Route::post('update/{offerId}', [OfferController::class, 'update']);
    Route::get('delete/{offerId}', [OfferController::class, 'destroy']);
});

