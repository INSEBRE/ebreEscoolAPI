<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    use DatabaseMigrations;
    use WithoutMiddleware;

    public function testUserCreate()
    {
        $data = $this->getData();

        //Create a new user and verify the answer
        $this->post('/user', $data)
            ->seeJsonEquals(['created' => true]);

        $data = $this->getData(['name' => 'jane']);

        //We update the newly created user (id = 1)
        $this->put('user/1', $data)->seeJsonEquals(['updated' => true]);

        //We obtain the modified data and verify that the user name is correct
        $this->get('user/1')->seeJson(['name' => 'jane']);

        //Remove the user
        $this->delete('user/1')->seeJson(['deleted' => true]);
    }

    public function getData($custom = array())
    {
        $data = [
            'name'      =>  'joe',
            'email'     =>  'joe@domain.com',
            'password'  =>  '123456789'
        ];
        $data = array_merge($data, $custom);
        return $data;
    }
}