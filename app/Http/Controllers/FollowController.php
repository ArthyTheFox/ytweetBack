<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\follow;

class FollowController extends Controller
{
    public function follow(Request $request)
    {
        $follow = follow::where('idUserSend', $request->query('idUserConnected'))->where('idUserFollow',  $request['idUserFollow'])->first();

        if (!$follow) {
            $follow = new follow;

            $follow->idUserSend = $request->query('idUserConnected');
            $follow->idUserFollow = $request['idUserFollow'];

            $follow->save();
            return "good";
        }
    }

    public function unfollow(Request $request)
    {
        $follow = follow::where('idUserSend', $request->query('idUserConnected'))->where('idUserFollow',  $request->query('idUserFollow'))->first();
        $follow->delete();
        return "delete";
    }

    public function getFollow(Request $request)
    {
        $follows = follow::select('users.id', 'users.username', 'users.lastname', 'users.firstname')
            ->where('follows.idUserSend', $request->query('idUserConnected'))
            ->join('users', 'users.id', '=', 'follows.idUserFollow')
            ->get();

        return $follows;
    }

    public function getFollowByUser(Request $request)
    {
        $follow = follow::where('follows.idUserSend', $request->query('idUserConnected'))
            ->where('follows.idUserFollow', $request->query('idUserFollow'))
            ->first();

        if ($follow) {
            return response()->json(true);
        } else {
            return response()->json(false);
        }
    }
}
