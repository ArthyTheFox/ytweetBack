<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{ 
    public function newLike(Request $request)
    {
        $verifLike = Like::where('idUser', $request['idUser'])->where('idPost', $request['idPost'])->first();
        if (!$verifLike) {
            $like = new Like;
            $like->idUser = $request['idUser'];
            $like->idComment = $request['idComment'];
            $like->idPost = $request['idPost'];
            $like->save();
            return $like;
        } else {
            return response()->json('L\'user à déja Like');
        }
    }

    public function deleteLike($id)
    {
        $like = Like::find($id)->delete();
        return $like;
    }
}
