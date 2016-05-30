<?php

use App\User;
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
        $users = $this->createUser();

        $this->get('/api/v1.0/user?api_token=' . $users
                ->api_token)->seeJson();
    }

    /**
     * Test users in database are listed by API
     *
     * @return void
     */
    public function testUsersInDatabaseAreListedByAPI()
    {
        $users = $this->createUser();

        $this->createFakeUsers();
        $this->actingAs($users)
            ->get('/api/v1.0/user')
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
        $users = $this->createUser();

        $user = $this->createFakeUser();
        $this->actingAs($users)->get('/api/v1.0/user/' . $user->id)
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
//        $users = $this->createUser();
//
//        $data = ['username' => 'marta17', 'email' => 'rocio44@latinmail.com'];
//        $this->actingAs($users)->post('/api/v1.0/user', $data)->seeInDatabase('users', $data);
//        $this->actingAs($users)->get('/api/v1.0/user')->seeJsonContains($data)->seeStatusCode(200);
//    }

    /**
     * Test users can be update and see changes on database
     *
     * @return void
     */
    public function testUsersCanBeUpdatedAndSeeChangesInDatabase()
    {
        $users = $this->createUser();

        $user = $this->createFakeUser();
        $data = ['username' => 'panqueque', 'email' => 'panqueque@iesebre.com'];
        $this->actingAs($users)->put('/api/v1.0/user/' . $user->id, $data)->seeInDatabase('users', $data);
        $this->actingAs($users)->get('/api/v1.0/user')->seeJsonContains($data)->seeStatusCode(200);
    }

    /**
     * Test users can be deleted and not see on database
     *
     * @return void
     */
    public function testUsersCanBeDeletedAndNotSeenOnDatabase()
    {
        $users = $this->createUser();

        $user = $this->createFakeUser();
        $data = ['username' => $user->username, 'email' => $user->email];
        $this->actingAs($users)->delete('/api/v1.0/user/' . $user->id)->notSeeInDatabase('users', $data);
        $this->actingAs($users)->get('/api/v1.0/user')->dontSeeJson($data)->seeStatusCode(200);
    }

    /**
     * Test users can be not found error code
     *
     * @return void
     */
    public function testUsersNotFoundErrorCode()
    {
        $users = $this->createUser();

        $this->createFakeUsers();
        $this->actingAs($users)->get('/api/v1.0/user/500')->seeStatusCode(404);
    }

    /**
     * Test tags when not auth redirect to login and see message
     *
     * @return void
     */
    public function testTagsReturnLoginPageWhenNotAuth()
    {
        $this->visit('/login')
            ->seePageIs('/login')
            ->see('You do not have access to the API');
    }

    /**
     * Create fake user
     *
     * @return \App\User
     */
    private function createFakeUser()
    {
        $faker = Faker\Factory::create('es_ES');

        $user = new \App\User();
        $user->username = $faker->username;
        $user->email = $faker->email;
        $user->password = $faker->password;
        $user->api_token = $faker->password;

        $user->save();

        return $user;
    }

    /**
     * Create fake users
     *
     * @param int $count
     * @return \App\User
     */
    private function createFakeUsers($count = 20)
    {
        foreach (range(1, $count) as $number) {
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
