<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Passport\Client;

class RefreshController extends Controller
{
    use TokenTrait;

    private $client;

    public function __construct()
    {
        $this->client = Client::find(1);

    }

    public function refresh(Request $request){

        $this->validate($request, [
            'refresh_token' => 'required'
        ]);

        //utilisation du trait PHP (TokenTrait)
        return $this->issueToken($request, 'refresh_token');
    }
}
