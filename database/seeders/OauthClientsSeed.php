<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OauthClientsSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $client = [
            [
                "secret" => config("global.personal_client_secret"),
                "id" => config('global.personal_client_id'),
                "name" => env("APP_NAME"),
                "redirect" => "http://localhost",
                "personal_access_client" => true,
                "password_client" => false,
                "type" => "personnal",
            ],
            [
                "secret" => config("global.client_secret"),
                "id" => config('global.client_id'),
                "name" => env("APP_NAME"),
                "redirect" => "http://localhost",
                "personal_access_client" => false,
                "password_client" => true,
                "type" => "password",
            ]
        ];

        DB::table('oauth_clients')->insert($client);
    }
}
