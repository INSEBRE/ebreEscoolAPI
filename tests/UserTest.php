<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testUsersUseJson()
    {
        $this->get('/user')
            ->seeJson()->seeStatusCode(200);
    }

    /**
     * Test users in database are listed by API
     *
     * @return void
     */
    public function testUsersInDatabaseAreListedByAPI()
    {
        $this->createFakeUsers();
        $this->get('/user')
            ->seeJsonStructure([
                '*' => [
                    'username',
                    'email'
                ]
            ])->seeStatusCode(200);
    }

    /**
     * Test users in database is shown by API
     *
     * @return void
     */
    public function testUsersInDatabaseAreShownByAPI()
    {
        $user = $this->createFakeUser();
        $this->get('/user/' . $user->id)
            ->seeJsonContains(['username' => $user->username, 'email' => $user->email])
            ->seeStatusCode(200);
    }

    /**
     * Test users can be posted and saved to database
     *
     * @return void
     */
    public function testUsersCanBePostedAndSavedIntoDatabase()
    {
        $data = ['username' => 'mario65', 'email' => 'javier.giron@live.com'];
        $this->post('/user',$data)->seeInDatabase('users',$data);
        $this->get('/user')->seeJsonContains($data)->seeStatusCode(200);
    }

    /**
     * Test users can be update and see changes on database
     *
     * @return void
     */
    public function testUsersCanBeUpdatedAndSeeChangesInDatabase()
    {
        $user = $this->createFakeUser();
        $data = [ 'username' => 'panqueque', 'email' => 'panqueque@iesebre.com'];
        $this->put('/user/' . $user->id, $data)->seeInDatabase('users',$data);
        $this->get('/user')->seeJsonContains($data)->seeStatusCode(200);
    }

    /**
     * Test users can be deleted and not see on database
     *
     * @return void
     */
    public function testUsersCanBeDeletedAndNotSeenOnDatabase()
    {
        $user = $this->createFakeUser();
        $data = [ 'username' => $user->username, 'email' => $user->email];
        $this->delete('/user/' . $user->id)->notSeeInDatabase('users',$data);
        $this->get('/user')->dontSeeJson($data)->seeStatusCode(200);
    }

    /**
     * Create fake user
     *
     * @return \App\User
     */
    private function createFakeUser()
    {
        $faker = Faker\Factory::create();

        $user = new \App\User();
        $user->username = $faker->username;
        $user->email = $faker->email;

        $user->save();

        return $user;
    }

    /**
     * Create fake users
     *
     * @param int $count
     * @return \App\User
     */
    private function createFakeUsers($count = 10)
    {
        foreach (range(0,$count) as $number)
        {
            $this->createFakeUser();
        }
    }


    /**
     * Create users
     *
     * @return mixed
     */
    public function createUser()
    {
        $user = factory(App\User::class)->create();
        return $user;
    }
}