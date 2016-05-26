<?php

use App\People;
use App\User;
use Illuminate\Database\Seeder;

class PeopleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all()->lists('id')->toArray();

        $faker = Faker\Factory::create('es_ES');

        foreach (range(1, 20) as $number) {
            People::create([
                'givenName'         =>  $faker->firstName,
                'sn1'               =>  $faker->lastName,
                'sn2'               =>  $faker->lastName,
                'email'             =>  $faker->freeEmail,
                'secondary_email'   =>  $faker->safeEmail,
                'official_id'       =>  $faker->dni,
                'date_of_birth'     =>  $faker->date($format = 'Y-m-d', $max = 'now'),
                'homePostalAddress' =>  $faker->streetAddress,
                'locality_name'     =>  $faker->city,
                'mobile'            =>  $faker->phoneNumber,
                'avatar'            =>  $faker->imageUrl($width = 640, $height = 480, 'people'),
                'user_id'           =>  $faker->randomElement($users)
            ]);
        }
    }
}
