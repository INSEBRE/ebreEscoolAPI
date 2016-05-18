<?php

namespace App\Http\Controllers;


use App\User;
use App\Transformers\UserTransformer;
use Illuminate\Http\Request;

use App\Http\Requests;
use Response;

class UserController extends Controller
{
    protected $userTransformer;

    /**
     * UserController constructor.
     * @param $userTransformer
     */
    public function __construct(UserTransformer $userTransformer)
    {
        $this->userTransformer = $userTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::all();
        return Response::json(
            $this->userTransformer->transformCollection($user),
            200
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Creating New Users
        $user = new User();

        $this->saveUser($request, $user);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //Obtain the user data
        $user = User::find($id);

        if( !$user ) {
            return Response::json([
                'error' => [
                    'message' => 'User does not exist',
                    'code' => 195
                ]
            ],404);
        }

        return Response::json(
            $this->userTransformer->transform($user),
            200
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Update a user
        $user = User::find($id);

        if( !$user ){
            return Response::json([
                'error' => [
                    'message' => 'User does not exist',
                    'code' => 195
                ]
            ],404);
        }

        $this->saveUser($request, $user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Demove a user
        User::destroy($id);
    }

    /**
     * @param Request $request
     * @param $user
     */
    protected function saveUser(Request $request, $user) {
        $user->username = $request->username;
        $user->email = $request->email;

        $user->save();
    }
}
