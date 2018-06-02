<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\UserCheckIn;
use App\User;
use Config;

/* 
    This is UserControler
*/ 

class UserController extends Controller
{
    private $appName;

    /* Constructor that return the title of each view */

    private function UserController(){
        $this->appName = Config::get('app.name');
        $this->middleware('admin', ['exept' => ['login', 'index', 'checkin']]);
        $this->middleware('auth');
    }

    /* Login view */

    public function login(){
        $title = $this->appName." - Login ";
        
        return view('auth.login');
    }

    /* Get all the users with admin middleware */

    public function index(){
        $users = User::orderBy('id', 'asc')->get();
        return view('users.index')->with('users', $users);
    }

    /* Return Edit user view with admin middleware */

    public function edit($id){
        $user = User::find($id);
        return view('users.edit')->with('user', $user);
    }

    /* Update the user with admin middleware */

    public function update(Request $request, $id){

        $user = User::find($id);

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        if($request->input('password') != "" OR $request->input('password') != null){
            $user->password = Hash::make($request->input('password'));
        }
        $user->type = $request->input('type');
        $user->save();

        session()->flash('success', 'User Profile Updated !!!');
        return redirect('/user/all');
    }

    /* Delete the user with admin middleware */

    public function destroy($id){
        $auth = Auth::user();
        if($auth->id == $id){
            return response()->json(['type' => 'error','text' => 'Sorry!! You Cannot Delete Yourself']);
        } else {
            $user = User::find($id);
            $user->delete();
            return response()->json(['type' => 'success','text' => 'User Deleted Successfully !!!']);
        }
    }

    /* CHECKIN AND CHECK OUT USER */

    public function checkin (Request $request){
        $id = auth()->user()->id;
        $user = User::find($id);
        $last = $user->last();
        if($last != null){
            if($last->status == 2){
                $user->checkin();
                session()->flash('success', 'You have been checked In !!!');
                return redirect('/home');
            } else {
                $user->checkout();
                session()->flash('success', 'You have been checked Out !!!');
                return redirect('/home');
            }
        } else {
            $user->checkin();
            session()->flash('success', 'You have been checked In !!!');
            return redirect('/home');
        }
    }


    /* REPORTS */

    public function reports(){
        $auth = Auth::user();
        if($auth->type == 'admin'){
            $users = User::orderBy('created_at', 'asc')->get();
            return view('reports')->with('users', $users);
        } else {
            $users = User::where('id', $auth->id)->get();
            return view('reports')->with('users', $users);
        }
    }

    /* USER REPORTS */

    public function userReports($id){
        $user = User::findOrFail($id);
        if(auth()->user()->type == 'user' AND $user->id != auth()->user()->id){
            session()->flash('error', 'Unauthorized Page !!!');
            return redirect('/user/all');
        } else {
            $render = array(
                'user' => $user,
                'reports' => $user->checkins
            );
            return view('users.reports')->with($render);
        }
    }
}
