<?php

namespace Hotels\Http\Controllers;

use Illuminate\Http\Request;
use Hotels\User;
use Auth;

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
        $user = User::find($id);
        if($request->password != '')
        {
            $request->validate([
                'password' => 'required|min:6|confirmed'
            ]);

            $user->password = bcrypt($request->password);

            $user->save();

            return back()->with('success', 'Password changed successfully!');
        }
        else if($request->name != '')
        {
            $request->validate([
                    'name' => 'required|min:5'
                ]);

            $user->name = $request->name;

            $user->save();

            return back()->with('success', 'Username changed successfully!');
        }
        else
        {
            return back();
        }
    }
}
