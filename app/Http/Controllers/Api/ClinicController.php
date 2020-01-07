<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Clinic;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;


class ClinicController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $user = Auth::user();
        return response()->json($user->clinics()->get());
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
        //
        $request->validate([
            'clinics.*.name' => 'required',
            'clinics.*.phone' => ['required','min:11',Rule::unique('users')],
            // 'country_id' => 'required|numeric',
            'clinics.*.city_id' => 'required|numeric',
            'clinics.*.address' => 'required',
            'clinics.*.location' => 'required',

        ]);

        $inputs = array_map(function ($item){
            $arr = explode(',', $item['location']);
            $item['Longitude'] = $arr[0];
            $item['latitude'] = $arr[1];
            unset($item['location']);
            return $item;
        }, $request->clinics);
        $user = Auth::user();
        if ($user->clinics()->createMany($inputs)){
            return response()->json( $user->clinics()->get() );
        }
        else {
            return response()->json(['error'=> "Clinics Not Created"], 403);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        return response()->json(Clinic::find($id));
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
    public function updateClinic(Request $request)
    {
        //
        $request->validate([
            'clinics.*.name' => 'required',
            'clinics.*.phone' => ['required','min:11',Rule::unique('users')],
            // 'country_id' => 'required|numeric',
            'clinics.*.city_id' => 'required|numeric',
            'clinics.*.address' => 'required',
            'clinics.*.location' => 'required',
            'clinics.*.id' => 'required',
        ]);
        try {
            array_map(function ($clinic){
                if(!empty($clinic['location'])){
                    $arr = explode(',', $clinic['location']);
                    $clinic['Longitude'] = $arr[0];
                    $clinic['latitude'] = $arr[1];
                }
                unset($clinic['location']);
                Clinic::find($clinic['id'])->update($clinic);
            }, $request->clinics);
            $user = Auth::user();
            return response()->json( $user->clinics()->get() );
        } catch (\Throwable $th) {
            throw $th;
            return response()->json(['error'=> "Clinics Not updated"], 403);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        Clinic::destroy($id);
        $user = Auth::user();
        return response()->json( $user->clinics()->get() );
    }
}
