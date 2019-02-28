<?php

namespace Hotels\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
//use App\Http\Controllers\Controller;
use Hotels\Hotel;
use Hotels\User;
use Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if(Auth::user()->id == 3)
        {
            $AllUsers = User::all();
            return view('users.index', compact('AllUsers'));
        }
    }

    public function create()
    {
        if(Auth::user()->id == 3)
        {
            return view('users.create');
        }
        else
        {
            return redirect('/hotels/');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:5|max:200',
            'email' => 'required|max:200',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = new User;
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->password = bcrypt($request->password);
        if($request->has('editor'))
        {
            $user->editor = 1;
        }
        else
        {
            $user->editor = 0;
        }
        $user->save();

        return redirect('/users')->with('success', 'User has been added!');
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

    public function destroy($id)
    {
        $Hotels = Hotel::where('user_id', $id);
        $Hotels->delete();
        $User = User::find($id);
        $User->delete();

        return redirect('/users/')->with('success', 'User was successfully deleted!');
    }

}
