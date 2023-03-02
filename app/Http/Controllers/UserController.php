<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    function deleteUser(Request $request) {
        $user = User::find($request['id']);
        #affiche l'utilisateur trouvé sur la page web
        $user->delete();
        return $user;
    }
    
    function createUser(Request $request){
        $user = new User;

        $user->lastname = $request['lastname'];
        $user->firstname = $request['firstname'];
        $user->email = $request['email'];
        $user->username = $request['username'];
        if ($request['password'] == null) {
            return response()->json([
                'status' => false,
                'message' => 'Password need to not be null.',
            ], 500);
        } 
        elseif (strlen($request['password']) < 8) {
            return response()->json([
                'status' => false,
                'message' => 'Password need 8 caractere minimum.',
            ], 500);        }

        else {
            $user->password = bcrypt($request['password']);
        }
            if ($request['birthday'] == null) {
            $user->birthday = null;
        } else {
            $user->birthday = $request['birthday'];
        }


        $user->save();

        return $user;
    }
}
