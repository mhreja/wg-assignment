<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\Product;

class UserController extends Controller
{
    public function index(){
        return view('users.index');
    }

    public function getusers(){
        return User::all();
    }

    public function store(Request $request){
        $request->validate([
            'name'=>['required', 'string', 'max:255'],
            'email'=>['required', 'string', 'email', 'max:255', 'unique:users'],
            'is_active'=>['nullable', 'boolean'],
            'pass'=>['required', 'min:8'],
            'activation_token'=>['required', 'string', 'max:255'],
        ]);
        $request->merge(['password' => Hash::make($request->pass)]);

        User::create($request->all());

        $data = ['success'=>true, 'message'=>'New user added'];

        return $data; 
    }

    public function update(Request $request, User $user){
        $request->validate([
            'name'=>['required', 'string', 'max:255'],
            'email'=>['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'is_active'=>['nullable', 'boolean'],
            'newpassword'=>['nullable', 'min:8'],
        ]);
        if($request->has('newpassword')){
            $request->merge(['password' => Hash::make($request->newpassword)]);
        }

        $user->update($request->all());

        $data = ['success'=>true, 'message'=>'User details updated'];

        return $data; 
    }

    public function delete($id){
        User::find($id)->delete();
    	return ['success'=>true, 'message'=>'User Deleted Successfully.'];
    }
}