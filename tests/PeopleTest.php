<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class PeopleTest extends TestCase
{
    use DatabaseMigrations;
    use WithoutMiddleware;

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testPeopleUseJson()
    {
        $this->get('/api/v1.0/people')
            ->seeJson()->seeStatusCode(200);
    }

    /**
     * Create fake people
     *
     * @return \App\People
     */
    private function createFakePeople()
    {
        $faker = Faker\Factory::create();

        $people = new \App\People();
        $people->givenName = $faker->firstName;
        $people->email = $faker->freeEmail;

        $people->save();

        return $people;
    }

    /**
     * Create fake people
     *
     * @param int $count
     * @return \App\People
     */
    private function createFakePeoples($count = 10)
    {
        foreach (range(0, $count) as $number) {
            $this->createFakePeople();
        }
    }

    /**
     * Create people
     *
     * @return mixed
     */
    public function createPeople()
    {
        $people = factory(App\People::class)->create();
        return $people;
    }
}
