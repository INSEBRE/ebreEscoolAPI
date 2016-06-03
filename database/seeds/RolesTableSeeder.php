<?php

use App\User;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
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
                'username'      =>  $faker->username,
                'display_name'  =>  $faker->name,
                'description'   =>  $faker->descripction,
            ]);
        }
    }
}
