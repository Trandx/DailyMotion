<?php

//namespace App\Http\Controllers\Api\Auth;
namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\ResponseController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class LogoutController extends ResponseController
{


    public function logout(){

        $accessToken = Auth::user()->token();

        DB::table('oauth_refresh_tokens')->where('access_token_id', $accessToken->id)->update(['revoked' => true]);

        $accessToken->revoke();

        return $this->successResponse('Disconnected', ['success' => 'user disconnected successfully'], 200);
    }
}
