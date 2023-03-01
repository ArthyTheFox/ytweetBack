<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function newLike(Request $request)
    {
       $like = new Like;
       $like->idUser = $request['idUser'];
       $like->idComment = $request['idComment'];
       $like->idPost = $request['idPost'];  
       $like->save(); 
       return $like;
    }

    public function deleteLike($id)
    {
        $like = Like::find($id);
        #affiche l'utilisateur trouvé sur la page web
        $like->delete();
        return $like;
    } 
}
