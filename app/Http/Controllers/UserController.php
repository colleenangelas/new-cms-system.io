<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function index(){
        $users = User::all();
        return view('admin.users.index', ['users'=>$users]);
    }

    public function show(User $user){

        return view('admin.users.profile', ['user'=>$user]);
        
    }

    public function update(User $user, Request $request){
        
        $input = request()->validate([ 

            'username'=>['required', 'string', 'max:255', 'alpha-dash'],
            'name'=>['required', 'string', 'max:255'],
            'email'=>['required', 'email', 'max:255'],
            'avatar'=>['file'],

        ]);

        if($file = request('avatar')){
 
            $name = $file->getClientOriginalName();
             $file->move('images', $name);
             $input['avatar'] = $name;
         }

        $user->update($input);
        return back();
       

    }

    public function destroy(User $user){
        $user->delete();

        session()->flash('user-deleted-message', 'User has been deleted');
        return back();
    }
}
