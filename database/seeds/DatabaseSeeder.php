<?php

use App\People;
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
        $this->seedPeople($faker);

        Model::reguard();
    }

    public function seedPeople($faker) {
        foreach(range(0,20) as $number) {
            $people = new People();

            $people->givenName = $faker->lastName;
            $people->sn1 = $faker->firstNameMale;
            $people->sn2 = $faker->firstNameFemale;
            $people->email = $faker->email;
            $people->official_id = $faker->dni;
            $people->mobile = $faker->phoneNumber;

            $people->save();
        }
    }
}
