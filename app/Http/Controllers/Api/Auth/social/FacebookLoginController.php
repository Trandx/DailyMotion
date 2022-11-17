<?php

namespace App\Http\Controllers\Api\Auth\social;

use App\Http\Controllers\Api\ResponseController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\Client;
use App\Http\Controllers\Api\Auth\TokenTrait;

class FacebookLoginController extends ResponseController
{
    use TokenTrait;

    private $client;

    public function __construct()
    {
        $this->client = Client::find(1);
    }

    public function authenticate(Request $request)
    {

        $this->validate($request, [
            'phone' => 'required',
            'password' => 'required'
        ]);
        //recupération des infos utilisateurs à partir du numéro de téléphone
        $phone_db = User::where('phone', $request->phone)->first();

        if (is_null($phone_db)) {
            return $this->errorResponse('Unauthorized.', ['error' => 'Unauthoriszed phone number ' . $request->phone], 401);
        }
        if (!Hash::check($request->password, $phone_db->password)) {
            return $this->errorResponse('Unauthorized.', ['error' => 'Unauthorized Password'], 401);
        }

        //verification si l'utilisateur est connecté. si oui alors connexion de l'utilisateur
        if (Auth::attempt(['phone' => $request->phone, 'password' => $request->password])) {
            //generation de l'access token et du refresh token
            return $this->issueToken($request, 'password');
        } else {
            return $this->errorResponse('Unauthorized.', ['errors' => 'Connexion Unauthorized'], 401);
        }
    }
}
