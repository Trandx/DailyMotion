<?php

/**
 * By Trandx
 *
 * this file have been creted to get internal client passport
 *
 **/


return [

    'client_id' => env("PASSPORT_CLIENT_ID"),

    'client_secret' => env("PASSPORT_CLIENT_SECRET"),

    'personal_client_id' => env("PASSPORT_PERSONAL_ACCESS_CLIENT_ID"),

    'personal_client_secret' => env("PASSPORT_PERSONAL_ACCESS_CLIENT_SECRET"),

    'client_admin_role' => [
        "admin" => env("CLIENT_ADMIN_ROLE_NAME") ,
        "super_admin" => env("CLIENT_SUPER_ADMIN_ROLE_NAME"),
    ],

]



?>
