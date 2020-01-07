<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Mail\SendCode;


class VisitController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function verify(Request $request, $id)
    {
        //
        $request->validate([
            'code' => 'required|numeric',
        ]);

        $input = $request->code;
        $user = Auth::user();
        if ($user->visits()->find($id)->code == $request->code) {
            return response()->json(['message'=> "Verified"]);
        } else {
            return response()->json(['message'=> "Not Verified"]);
        }
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
            'name' => 'required',
            'email' => 'required|email',
            'phone' => ['required','min:11'],
            'date' => 'required|date_format:d/m/Y',
        ]);

        $input = $request->only(['name','email','phone']);
        $input['date'] = date('Y-m-d', strtotime($request->date));
        $user = Auth::user();
        $code = $this->generateRandomNumbers();
        while ( $user->visits()->where('visits.code', $code )->count() > 0) {
            $code = $this->generateRandomNumbers();
        }
        $input['code'] = $code;
        \Mail::to($input['email'])
            ->send(new SendCode($code));
        if ($user->visits()->create($input)){
            return response()->json( $user->visits()->get() );
        }
        else {
            return response()->json(['error'=> "Visit Not Created"], 403);
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
        //
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
    }
}
