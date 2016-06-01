<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\User;
use App\Transformers\UserTransformer;
use App\Http\Requests;
use Response;

class UserController extends Controller
{
    protected $userTransformer;
    private $user;

    /**
     * UserController constructor.
     *
     * @param User              $user
     * @param UserTransformer   $userTransformer
     */
    public function __construct(UserTransformer $userTransformer, User $user)
    {
        parent::__construct();

        $this->userTransformer = $userTransformer;
        $this->user = $user;
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
    public function store(UserStoreRequest $request)
    {
        User::create($request->only('username','email'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        if (!$user) {
            return Response::json([
                'error' => [
                    'message' => 'User does not exist',
                    'code' => 195
                ]
            ], 404);
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
    public function update(UserUpdateRequest $request, $id)
    {
        $user = User::findOrFail($id);

        if (!$user) {
            return Response::json([
                'error' => [
                    'message' => 'User does not exist',
                    'code' => 195
                ]
            ], 404);
        }

        $user->username = $request->username;
        $user->email = $request->email;

        $user->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::destroy($id);
    }
}
