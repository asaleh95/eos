<?php

namespace App\Http\Controllers;

use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Country;
use App\City;
use Validator;

class HomeController extends Controller
{
    //

    public function GetCountries(){

        $data= Country::select('id','name')->get();
        return response()->json(['data' => $data], 200);
    }

    public function GetCities(Request $request){

        $validator = Validator::make($request->all(), [
            'country_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }
    $data= City::select('id','name')->where('country_id',64)->get();
        return response()->json(['data' => $data], 200);
    }
}
