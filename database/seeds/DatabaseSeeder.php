<?php

use App\People;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // $this->call(UsersTableSeeder::class);

        $faker = Faker\Factory::create('es_ES');
        $this->seedUser($faker);
        $this->seedPeople($faker);


        Model::reguard();
    }

    public function seedUser($faker)
    {
        foreach(range(1, 20) as $number) {
            $user = new User();

            $user->username = $faker->username;
            $user->email = $faker->freeEmail;
            $user->password = $faker->password;

            $user->save();
        }
    }

    public function seedPeople($faker)
    {
        $users = User::all()->lists('id')->toArray();

        foreach(range(1, 20) as $number) {
            $people = new People();

            $people->givenName = $faker->firstName;
            $people->sn1 = $faker->lastName;
            $people->sn2 = $faker->lastName;
            $people->email = $faker->freeEmail;
            $people->secondary_email = $faker->safeEmail;
            $people->official_id = $faker->dni;
            $people->date_of_birth = $faker->date($format = 'Y-m-d', $max = 'now');
            $people->homePostalAddress = $faker->streetAddress;
            $people->locality_name = $faker->city;
            $people->mobile = $faker->phoneNumber;
            $people->photo = $faker->imageUrl($width = 640, $height = 480, 'people');

            $people->user_id = $faker->randomElement($users);

            $people->save();
        }
    }
}
