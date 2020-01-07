<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;

class UserController extends Controller
{
    //
    public function randomPassword() {
    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }

     return implode($pass); //turn the array into a string
   }
    public $successStatus = 200;

    public function login(){
        if(Auth::attempt(['email' => request('email'), 'password' => request('password'), 'is_boardmember' => 1])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')-> accessToken;
            return response()->json(['success' => $success], $this-> successStatus);
        }
        else{
            return response()->json(['error'=>'Unauthorised'], 401);
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'mobile' => 'required',
            'city_id' => 'required|numeric',

        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }
        $input = $request->all();
//        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')-> accessToken;
        $success['name'] =  $user->name;
        return response()->json(['success'=>$success], $this-> successStatus);
    }

    public function profile()
    {
        $user = Auth::user();
        return response()->json(['success' => $user], $this-> successStatus);
    }

    public function update(Request $request){
        $validator = Validator::make($request->all(), [
            'title' => 'nullable',
            'email' => 'required|email',
            'name' => 'required',
            'mobile' => 'required',
            'city_id' => 'required|numeric',
            'description' => 'nullable',

        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }
        $input = $request->all();

        $user = User::find(Auth::user()->id);
        $user->title = $input->title;
        $user->email = $input->email;
        $user->name = $input->name;
        $user->mobile = $input->mobile;
        $user->city_id = $input->city_id;
        $user->facebook = $input->facebook;
        $user->linkedin = $input->linkedin;
        $user->twitter = $input->twitter;
        $user->description = $input->description;
        $user->save();
        return response()->json(['success' => $user], $this-> successStatus);
    }

    public function upload_image(Request $request){
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }

        $user = User::find(Auth::user()->id);

        $file_path = app_path().'/profile_images/'.$user->image;
        unlink($file_path);
        $imageName = time().'.'.request()->image->getClientOriginalExtension();
        request()->image->move(public_path('profile_images'), $imageName);
        $user->image=$imageName;
        return response()->json(['success' => $user], $this-> successStatus);
    }

    public function addClinic(){
        
    }

    public function index(Request $request){
        $validator = Validator::make($request->all(), [
            'city_id' => 'nullable|numeric',
            'name' => 'nullable',
            'is_boardmember' => 'nullable|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }

        $filters = $request->all();
        $perPage = isset($filters['per_page']) ? (int)$filters['per_page'] : 2;

        $data= User::with(['city:id,name'])
            ->when(isset($filters['name']), function ($query) use ($filters) {
                return $query->where('name','like%', $filters['name'] .'%');
            })
            ->when(isset($filters['is_boardmember']), function ($query) use ($filters) {
                return $query->where('is_boardmember','=', $filters['is_boardmember'] );
            })
              ->whereHas('city', function ($query)use($filters) {
                if(isset($filters['city_id']))
                {
                    $query->where('city_id', '=', $filters['city_id']);
                }

            })
            ->paginate($perPage);
        return response()->json(['success' => $data], $this-> successStatus);
    }
}
