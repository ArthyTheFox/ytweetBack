<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\follow;

class FollowController extends Controller
{
    public function follow (Request $request) {
        $follow = new Follow;

        $follow->idUserSend = '';
        $follow->idUserFollow = $request['idUserFollow'];

        $follow->save();

        return "good";
    }
}
