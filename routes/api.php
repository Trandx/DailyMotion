<?php


use Illuminate\Support\Facades\Route;

// use particulier et qui sera modifié à la fusion

use App\Http\Controllers\Api as Api;

$app = config('app.name');

/////////////// Bertin ///////////////
//login user
Route::post('/login', [Api\Auth\LoginController::class, 'authenticate'])->name('login');


Route::post('register', [Api\Auth\UserController::class, 'registeruser'])->name('registerUser');


Route::get('user/search', [Api\Auth\UserController::class, 'searchUser'])->name('searchuser'); //->middleware(['admin']);

Route::post('user/forgot-password', [Api\Auth\UserController::class, 'forgotPassword'])->name('change-password');

Route::post('user/reset-password', [Api\Auth\UserController::class, 'passwordReset'])->name('reset-password');

Route::post('user/email/resend', [Api\Auth\UserController::class, 'emailResend'])->name('email.resend');

Route::post('user/email/verify', [Api\Auth\UserController::class, 'emailVerify'])->name('email.verify');

Route::middleware(['auth:api',/*"validAccount"*/])->group(function () {

   // Route::get('getuser', [Api\Auth\UserController::class, 'getuser'])->name('getuser'); //->middleware(['admin']);
    ////////////// Begin ////////////////////

    /////////////////////////////// middleware des user authentifiés //////////////

    Route::post('logout', [Api\Auth\LogoutController::class, 'logout'])->name('deconnexion');

    //refresh token user
    Route::post('refresh', [Api\Auth\RefreshController::class, 'refresh'])->name('refresh_token');

    ///////////// end ///////////////////


    Route::put('user/change-password', [Api\Auth\UserController::class, 'changePassword'])->name('change-password');

    /////////// upload file /////

    Route::post('upload', [Api\Upload\UploadController::class, 'store'])->name('upload');


    ////////// end  ///////////

});
