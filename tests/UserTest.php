<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class UserTest extends TestCase
{
    use DatabaseMigrations;
    use WithoutMiddleware;

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testUsersUseJson()
    {
        $this->get('/api/v1.0/user')
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
        $this->get('/api/v1.0/user')
            ->seeJsonStructure([
                '*' => [
                    'username',
                    'email',
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
        $this->get('/api/v1.0/user/' . $user->id)
            ->seeJsonContains(['username' => $user->username, 'email' => $user->email])
            ->seeStatusCode(200);
    }

//    /**
//     * Test users can be posted and saved to database
//     *
//     * @return void
//     */
//    public function testUsersCanBePostedAndSavedIntoDatabase()
//    {
//        $data = ['username' => 'marta17', 'email' => 'rocio44@latinmail.com'];
//        $this->post('/api/v1.0/user', $data)->seeInDatabase('users', $data);
//        $this->get('/api/v1.0/user')->seeJsonContains($data)->seeStatusCode(200);
//    }

    /**
     * Test users can be update and see changes on database
     *
     * @return void
     */
    public function testUsersCanBeUpdatedAndSeeChangesInDatabase()
    {
        $user = $this->createFakeUser();
        $data = ['username' => 'panqueque', 'email' => 'panqueque@iesebre.com'];
        $this->put('/api/v1.0/user/' . $user->id, $data)->seeInDatabase('users', $data);
        $this->get('/api/v1.0/user')->seeJsonContains($data)->seeStatusCode(200);
    }

    /**
     * Test users can be deleted and not see on database
     *
     * @return void
     */
    public function testUsersCanBeDeletedAndNotSeenOnDatabase()
    {
        $user = $this->createFakeUser();
        $data = ['username' => $user->username, 'email' => $user->email];
        $this->delete('/api/v1.0/user/' . $user->id)->notSeeInDatabase('users', $data);
        $this->get('/api/v1.0/user')->dontSeeJson($data)->seeStatusCode(200);
    }

    /**
     * Test users can be not found error code
     *
     * @return void
     */
    public function testUsersNotFoundErrorCode()
    {
        $this->createFakeUsers();
        $this->get('/api/v1.0/user/500')->seeStatusCode(404);
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
        $user->password = $faker->password;

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
        foreach (range(0, $count) as $number) {
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
