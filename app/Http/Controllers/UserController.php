<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Solutions;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Check authentication
        if(Auth::guest() || Auth::user()->authentication < 1){
            return redirect('/')->with('error', 'Unauthorized Page');
        }
        $users = User::all();
        return view('users.index')->with('users',$users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return redirect('/');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //Check authentication
        if(Auth::guest() || Auth::user()->authentication < 1){
            return redirect('/')->with('error', 'Unauthorized Page');
        }
        $users = User::find($id);
        return view('users.edit')->with('users',$users);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'username' => 'required',
            'email' => 'required',
            'level' => 'required',
            'authentication' => 'required'
        ]);
        $users = User::all();
        foreach($users as $cekuser) {
            if($cekuser->id == $id) continue;
            if($cekuser->username == $request->input('username')) {
                return redirect("/users/" . $id . "/edit")->with('error', 'Username already taken');
            }
            if($cekuser->email == $request->input('email')) {
                return redirect('/users/' . $id . "/edit")->with('error', 'Email already taken');
            }
        }
        $user = User::find($id);
        $user->username = $request->input('username');
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->level = $request->input('level');
        $user->authentication = $request->input('authentication');
        $user->save();
        return redirect('/users')->with('success', 'User Edited');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $solutions = Solutions::where('user_id','=',$id)->get();
        foreach($solutions as $solution) {
            $solution->delete();
        }
        $users = User::find($id);
        $users->delete();
        return redirect('/users')->with('success', 'User Removed');
    }
}
