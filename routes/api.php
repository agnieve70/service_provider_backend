<?php

use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\PostCommentController;
use App\Http\Controllers\Api\PostTransactionController;
use App\Http\Controllers\Api\ServiceCategoryController;
use App\Http\Controllers\Api\ServicePostController;
use App\Http\Controllers\Api\ServicesController;
use App\Http\Controllers\Api\TotalController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post("register", [ UserController::class, "register"]);
Route::post("login", [ UserController::class, "login"]);

Route::group(["middleware" => ["auth:sanctum"]], function () {
    Route::get("total-number", [ TotalController::class, "getTotalNumber"]);
    Route::get("comments/{id}", [ CommentController::class, "index"]);
    Route::post("comment/create", [ CommentController::class, "createComment"]);
    Route::get("comment/create", [ CommentController::class, "createComment"]);
    Route::post("message/create", [ MessageController::class, "createMessage"]);
    Route::get("message/create", [ MessageController::class, "createMessage"]);
    Route::post("payment/create", [ PaymentController::class, "createPayment"]);
    Route::get("payment/create", [ PaymentController::class, "createPayment"]);
    Route::post("service_category/create", [ ServiceCategoryController::class, "createServiceCategory"]);
    Route::get("service_categories", [ ServiceCategoryController::class, "index"]);
    Route::get("services", [ ServicesController::class, "index"]);
    Route::get("service/{id}", [ ServicesController::class, "getService"]);
    Route::post("services/create", [ ServicesController::class, "createServices"]);
    Route::post("services/update", [ ServicesController::class, "updateServices"]);
    Route::delete("services/delete/{id}", [ ServicesController::class, "deleteService"]);
    Route::get("my-services", [ ServicesController::class, "getMyService"]);
    Route::post("transaction/create", [ TransactionController::class, "createTransaction"]);
    Route::get("transaction/create", [ TransactionController::class, "createTransaction"]);
    Route::post("service-post/create", [ ServicePostController::class, "createServicePost"]);
    Route::get("service-post/create", [ ServicePostController::class, "createServicePost"]);
    Route::post("post-transaction/create", [ PostTransactionController::class, "createPostTransaction"]);
    Route::get("post-transaction/create", [ PostTransactionController::class, "createPostTransaction"]);
    Route::post("post-comment/create", [ PostCommentController::class, "createPostComment"]);
    Route::get("post-comment/create", [ PostCommentController::class, "createPostComment"]);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
