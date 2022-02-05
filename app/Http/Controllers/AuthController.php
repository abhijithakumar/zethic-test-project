<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use \Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // $validator = Validator::make($request->all(),[
        //     'name' => 'required',
        //     'email'=> 'requied|email',
        //     'password'=> 'required'
        // ]);
        // if($validator->fails())
        // {
        //     return response()->json([
        //         'status_code' => 400,
        //         'message'=> 'validation failed'
        //     ]);
        // }


        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json([
            'status_code' => 200,
            'message' => 'user registered successfully'
        ]);
    }

    public function login(Request $request)
    {
        // $validator = Validator::make($request->all(),[
        //     'email'=> 'requied',
        //     'password'=> 'required'
        // ]);
        // if($validator->fails())
        // {
        //     return response()->json([
        //         'status_code' => 400,
        //         'message'=> 'validation failed'
        //     ]);
        // }

        $credentials = request(['email','password']);
        if(!Auth::attempt($credentials))
        {
            return response()->json([
                'status_code' => 401,
                'message' => 'Unauthorized'
            ]);
        }
        $user = User::where('email',$request->email)->first();

        $tokenResult = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'status_code' => 200,
            'token' => $tokenResult
        ]);
        
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status_code' => 200,
            'message' => 'token deleted successfully'
        ]);
    }
}
