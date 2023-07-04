<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Validator;


class UserController extends Controller
{
    public function index()
    {
       $this->data['role'] = Role::get();
       $this->data['user'] = User::with('get_role')->orderBy('created_at','desc')->get();

       return view('index',$this->data);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
              'name' => 'required',
              'email' => 'required|unique:users,email',
              'phone' => 'required|numeric|digits_between:10,10|unique:users,phone',
              'role_id' => 'required',
              'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ],[
              'name.required' => 'Please provide Name',
              'role_id.required' => 'Please select role',
              'image.required' => 'Please provide image',
        ]);
        
        if ($validator->fails()) {
                // validator
            $error = $validator->errors()->all()[0];
            return response([
                    'status' => 2,
                    'message' => $error
            ], 200);
        }
        
        
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->role_id = $request->role_id;

        $imageName = time().'.'.$request->image->extension();  
         
        $request->image->move(public_path('images'), $imageName);

        $user->profile = $imageName;
        
        $user->description = $request->description;
        $user->save();

        if($user)
            return response()->json(['status'=>3,'message'=>"User Save Successfully"]);
    }
    public function getUser()
    {
       $this->data['user'] = User::with('get_role')->orderBy('created_at','desc')->get();

       return view('user_data',$this->data);
    }
}
