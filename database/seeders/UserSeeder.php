<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $first = [
            'first_name' => 'Argand',
            'last_name' => 'Sandjon',

            'phone' => "+237-696125548",

            'email' => "tsabimmo@gmail.com",

            'username' => "Trandx",
            'birthday' => "1999-01-05",
            'password' => Hash::make('test'), // bcrypt('test'),

        ];

        User::create($first);

        User::factory()->count(10)->create();

    }
}
