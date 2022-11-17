<?php


//namespace App\Http\Controllers\Api\Auth;
namespace App\Http\Controllers\Api\Auth;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

trait TokenTrait
{

//     public function issueToken(Request $request, $grantType, $scope = "*")
//     {
//  //var_dump($this->client);

//         $params = [
//             'grant_type' => $grantType,
//             'client_id' => $this->client->id,
//             'client_secret' => $this->client->secret,
//             'username' => $request->email ?? $request->phone,
//             //'password' => request('password'),
//             'scope' => $scope
//         ];

//         $request->request->add($params);

//         $proxy = Request::create('oauth/token', 'POST');

//         return Route::dispatch($proxy);
//     }

    public function issueToken($args,$refresh=false)
    {
        //$this->client = Client::find(config('global.internal_client_id'));

        $params = [
            'grant_type' => $args->grant_type ?? "password",
            'client_id' => $args->client_id ?? config('global.client_id'),
            'client_secret' =>  $args->client_secret ?? config('global.client_secret'),
            'scope' => $args->scope ?? "*",
            'redirect_uri' => $args->redirect_uri ?? null,
        ];

        if(!$refresh){
            $params = array_merge($params,
            [
                'username' => $args->login, //$args->email ?? $args->phone ?? $args->social_id,
                'password' =>"every chars",   // go into user model to disable it] )
            ]);
        }else{
            $params = array_merge($params,
            [
                'refresh_token' => $args->refresh_token
            ]);
        }

        $url = route("passport.token");

        $request = Request::create($url, 'POST', $params);

       return  app()->handle($request);

    }
}
