<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function newComment(Request $request)
    {
       $comment = new Comment;
       $comment->idComment = $request['idComment'];
       $comment->idPost = $request['idPost'];
       $comment->idUser = $request['idUser'];
       $comment->publishDate = $request['publishDate'];
       $comment->content = $request['content'];
       $comment->publishDate = date("Y-m-d H:i:s");
       $comment->save();
       return $comment;
    }

    public function showByPost($id)
    {
        
        $comment = Comment::select('comments.*', 'users.username')
        ->join('users', 'users.id', '=', 'comments.idUser')
        ->where('idPost', $id)
        ->orderBy('comments.id', 'desc')
        ->get();
        return $comment;
    }
}
