<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\support\Facades\Hash;
use Auth;

class UserController extends Controller
{
    public function addUser(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->employee_id = $request->employee_id;
        $user->password = Hash::make($request->password);
        $user->save();


        $userAddress = new UserAddress();
        $userAddress->building_no = $request->building_no;
        $userAddress->street_name = $request->street_name;
        $userAddress->city = $request->city;
        $userAddress->state = $request->state;
        $userAddress->country = $request->country;
        $userAddress->pincode = $request->pincode;
        $userAddress->user_id = User::where('email',$user->email)->first()->id;

        if($request->role == "employee")
        {
            $user->assignRole('employee');
        }
        elseif($request->role == "admin")
        {
            $user->assignRole('admin');
        }

        $userAddress->save();

        Mail::to($request->email)
    ->cc('User Registration')
    ->queue( new registered_user($user));

        return response()->json([
            'status' => 200,
            'message' => 'User added sussessfully'
        ]);
    }

    public function editUserData($id)
    {
        $users = User::with(['UserAddress'])->where('id',$id)->first();
        $users->role = $users->getRoleNames()->first(); 
        return response()->json([
            'items' => $users,
            'status' => 200,
            'message' => 'User data retrieved sussessfully'
        ]);
    }

    public function editUser($id,Request $request)
    {
        $user = User::find($id);
        $user->email = $request->email;
        $user->name = $request->name;

        $user->assignRole($request->role);
        $user->update();

        UserAddress::where('user_id',$id)->update([
            'building_no' => $request->building_no,
            'street_name'=> $request->street_name,
            'city'=> $request->city,
            'country'=> $request->country,
            'state'=> $request->state,
            'pincode'=> $request->pincode,
        ]);
        return response()->json([
            'status' => 200,
            'message' => 'User Edited sussessfully'
        ]);

    }
    public function getUserRole(Request $request)
    {
        $user = auth()->user();
        $userRoles = $user->getRoleNames()->first(); 
        return response()->json([
            'items' => $userRoles,
            'status' => 200,
            'message' => 'User role retrieved sussessfully'
        ]);

    }

    public function viewUser(Request $request)
    {
        $users = User::with(['UserAddress'])->get();
        
        return response()->json([
            'items' => $users,
            'status' => 200,
            'message' => 'User retrieved sussessfully'
        ]);
    }
}
