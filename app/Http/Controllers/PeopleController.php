<?php

namespace App\Http\Controllers;

use App\People;
use App\Transformers\PeopleTransformer;
use Illuminate\Http\Request;

use App\Http\Requests;
use Response;

class PeopleController extends Controller
{
    protected $userTransformer;

    /**
     * PeopleController constructor.
     * @param $peopleTransformer
     */
    public function __construct(PeopleTransformer $peopleTransformer)
    {
        $this->peopleTransformer = $peopleTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $people = People::all();
        return Response::json(
            $this->peopleTransformer->transformCollection($people),
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
        $people = new People();

        $this->savePeople($request, $people);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $people = People::find($id);

        if ( !$people ) {
            return Response::json([
                'error' => [
                    'message' => 'People does not exist',
                    'code' => 195
                ]
            ], 404);
        }

        return Response::json(
            $this->peopleTransformer->transform($people),
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
        $people = People::find($id);

        if ( !$people ){
            return Response::json([
                'error' => [
                    'message' => 'People does not exist',
                    'code' => 195
                ]
            ], 404);
        }

        $this->savePeople($request, $people);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        People::destroy($id);
    }

    /**
     * @param Request $request
     * @param $people
     */
    protected function savePeople(Request $request, $people)
    {
        $people->givenName = $request->givenName;
        $people->sn1 = $request->sn1;
        $people->sn2 = $request->sn2;
        $people->email = $request->email;
        $people->secondary_email = $request->secondary_email;
        $people->official_id = $request->official_id;
        $people->date_of_birth = $request->date_of_birth;
        $people->homePostalAddress = $request->homePostalAddress;
        $people->locality_name = $request->locality_name;
        $people->mobile = $request->mobile;
        $people->photo = $request->photo;

        $people->save();
    }
}
