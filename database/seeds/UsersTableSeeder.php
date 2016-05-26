<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create('es_ES');
        foreach (range(1, 20) as $number) {
            User::create([
                'username'  =>  $faker->username,
                'email'     =>  $faker->freeEmail,
                'password'  =>  $faker->password,
                'api_token' =>  sha1(uniqid(rand(), true)),
            ]);
        }
    }
}
