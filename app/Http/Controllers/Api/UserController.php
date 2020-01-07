<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\ActiveUser;
use App\User;
use Illuminate\Validation\Rule;

class UserController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $request->validate([
            'city_id' => 'nullable|numeric',
            'name' => 'nullable|alpha_num',
            'role_id' => 'nullable|numeric',
        ]);

        return response()->json(
            User::when(!empty($request->city_id), function ($query) use($request){
                return $query->where('city_id','=', $request->city_id);
            })->when(!empty($request->name), function ($query) use($request){
                    return $query->where('name', $request->name);
            })->when(!empty($request->role_id), function ($query) use($request){
                    return $query->where('role_id', $request->role_id);
            })->get()
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        //
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user()->with('clinics')->get();
            $token = $this->grantToken($request, $request->password);
            return response()->json(['token'=>json_decode($token->getcontent()) , "user"=> $user]);
        }
        else{
            return response()->json(['error'=> "User Not Exist or Invalid Data"], 401);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        //
        $request->validate([
            'name' => 'required|alpha_num',
            'email' => 'required|email|unique:users',
            'phone' => 'required|min:11|unique:users',
            // 'country_id' => 'required|numeric',
            'city_id' => 'required|numeric',
            'title' => 'required'
        ]);
        $input = $request->only(['name','email','phone','city_id','title']);
        $input['country_id'] = 64;
        $input['role_id'] = 1;
        $password = $this->generateRandomString();
        $input['password'] = bcrypt($password);
        //
        if ($user = User::create($input)){
            $token = $this->grantToken($request, $password);
            // Send mail
            \Mail::to($user)
            ->send(new ActiveUser($password));
            return response()->json(['user'=> $user , 'token'=>json_decode($token->getcontent())]);
        }
        else {
            return response()->json(['error'=> "User Not Added"], 403);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function saveQrcode(Request $request)
    {
        //
        $request->validate([
            'qrcode' => 'required'
        ]);
        try {
            $user = Auth::user();
            $user->qrcode = $request->qrcode;
            $user->save();
            return response()->json( $user );
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error'=> "User Not Added"], 403);
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
        return response()->json(User::with('clinics')->find($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function user()
    {
        //
        return response()->json(Auth::user()->with('clinics')->get());
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
        $request->validate([
            'name' => 'required',
            'email' => ['required','email',Rule::unique('users')->ignore($id)],
            'phone' => ['required','min:11',Rule::unique('users')->ignore($id)],
            // 'country_id' => 'required|numeric',
            'city_id' => 'required|numeric',
            'title' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg|max:2048',

        ]);

        $input = $request->only(['name','email','phone','city_id','title']);
        $input['image'] = base64_encode(file_get_contents($request->file('image')));
        $user = User::find($id);
        if ($user->update($input)){
            return response()->json(Auth::user()->with('clinics')->get());
        }
        else {
            return response()->json(['error'=> "User Not Updated"], 403);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changepassword(Request $request, $id)
    {
        //
        $request->validate([
            'password' => ['required','min:8'],
        ]);

        $input['password'] = bcrypt($request->password);
        $user = User::find($id);
        if ($user->update($input)){
            return response()->json(Auth::user()->with('clinics')->get());
        }
        else {
            return response()->json(['error'=> "User Not Updated"], 403);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        //
        // Auth::logout();
        auth()->user()->token()->revoke();
    }
}
