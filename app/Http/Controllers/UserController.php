<?php

namespace Hotels\Http\Controllers;

use Illuminate\Http\Request;
use Hotels\User;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function edit(User $user)
    {
        $user = Auth::user();
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        if(Auth::user()->email == request('email'))
        {
            $this->validate(request(), [
                    'name' => 'required',
                    //'email' => 'required|email|unique:users',
                    'password' => 'required|min:6|confirmed'
                ]);
        
            $user->name = request('name');
            //$user->email = request('email');
            $user->password = bcrypt(request('password'));
        
            $user->save();
        
            return back();
        }
        else
        {
            $this->validate(request(), [
                    'name' => 'required',
                    'email' => 'required|email|unique:users',
                    'password' => 'required|min:6|confirmed'
                ]);
        
            $user->name = request('name');
            $user->email = request('email');
            $user->password = bcrypt(request('password'));

            $user->save();

            return back();  
        }
    }
}
