<?php

namespace App\Http\Controllers\Src\DailyMotion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DailyMotion extends Controller
{
    public function __construct()
    {
        $this->_credentiels();
    }

    public $client_id;

    public $client_secret;

    public $grant_type;

    public $username;

    public $password;

    public $grat_type;

    private $uri;

    private $url;

    private $response;

    private $token;

    private $token_type;

    private $expires_in;

    private $refresh_token;

    private $scope;

    private $uid;

    private function _credentiels(){

        $this->client_id = env("DAILYMOTION_CLIENT_ID");

        $this->client_secret = env("DAILYMOTION_CLIENT_SECRET");

        $this->username = env("DAILYMOTION_USERNAME");

        $this->password = env("DAILYMOTION_PASSWORD");

        $this->grant_type = env("DAILYMOTION_GRANT_TYPE_SERVER", "DAILYMOTION_GRANT_TYPE_PASSWORD");

        $this->username = env("DAILYMOTION_USERNAME");

        $this->uri=env("DAILYMOTION_URI");

        $this->url = $this->_url();
    }

    private function _url(){
        return (object) [
            "auth" => $this->uri."oauth/token",
            "file_upload" => $this->uri."file/upload",
            "join_url" => $this->uri."me/videos",
            "update" => $this->uri."/user/x2pp5x2/videos",
        ];
    }


    public function login (){

        $data = [
            "client_id" => $this->client_id,
            "client_secret" => $this->client_secret,
            "grant_type" => $this->grant_type,
        ];

        if($this->grant_type == "password"){
            $data =  array_merge($data, [
                "username" =>  $this->username,
                "password" =>  $this->password,
            ]);
        }

        $this->response = Http::withHeaders([
            'Accept' => 'application/json',
        ])->post($this->url->auth, $data);

        return $this;
    }

    public  function response(){

        $response = $this->response;

        $data = $response->json() ;

        $response = (object) $response->json();


        if( $response->successful()){

            //var_dump($response->json());

            $this->token = $data["access_token"];
            $this->token_type = $data["token_type"];
            $this->expires_in = $data["expires_in"];
            $this->refresh_token = $data["refresh_token"];
            $this->scope = $data["scope"];
            $this->uid = $data["uid"];

            return [
                "success" => true,
                'datas' => $data,
                "code" =>  $response->status(),
            ];

          //  return  $this->successResponse($response->json(), ['error' => 'request error'], $response->status());

        }elseif( $response->failed() ){

            return [
                "success" => false,
                'datas' => $data,
                "code" =>  $response->status(),
            ];

            //return  $this->errorResponse($response->json(), ['error' => 'request error'], $response->status());

        }

    }

    public function sendFile(){



        Http::withToken($this->token,  $this->token_type);
    }

}
