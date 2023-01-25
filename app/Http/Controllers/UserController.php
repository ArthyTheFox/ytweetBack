<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    function index() {
        $posts = User::all();

        return $posts;
    }
    function createUser(Request $request){
        $user = new User;

        $user->lastname = $request['lastname'];
        $user->firstname = $request['firstname'];
        $user->email = $request['email'];
        $user->username = $request['username'];
        #enregistre le mdp chiffré
        $user->password = bcrypt($request['password']);
        $user->birthday = $request['birthday'];
 
        $user->save();

        return $user;
    }
}
