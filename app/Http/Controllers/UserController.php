<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all(); 
        //var_dump($users);
        $json = json_encode($users);
        //return view('user/list')->with('users',$users);
        return view('event.index')->with('users',$users);
    }


}
