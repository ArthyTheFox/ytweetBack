<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Like;
use App\Models\User;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function newComment(Request $request)
    {
       $comment = new Comment;
       $comment->idComment = $request['idComment'];
       $comment->idPost = $request['idPost'];
       $comment->idUser = $request['idUser']; 
       $comment->content = $request['content'];
       $comment->publishDate = date("Y-m-d H:i:s");
       $comment->save();
       $user = User::select('username', 'lastname','firstname')->where('id', $comment->idUser)->first();
       $comment->username = $user->username;
       $comment->firstname = $user->firstname;
       $comment->lastname = $user->lastname;
       $comment->subComment = [];
       return $comment;
    }

    public function showByIdPost($id)
    {
        $comment = Comment::select('comments.*', 'users.username', 'users.firstname', 'users.lastname') 
        ->join('users', 'users.id', '=', 'comments.idUser')
        ->where('idPost', $id)
        ->whereNull('comments.idComment')
        ->orderBy('comments.id', 'desc')
        ->get();
        foreach ($comment as $myComment) 
        {
            $subComment = Comment::select('comments.*', 'users.username','users.firstname', 'users.lastname')
            ->join('users', 'users.id', '=', 'comments.idUser')
            ->where('comments.idComment', $myComment->id) 
            ->orderBy('comments.id', 'desc')
            ->get(); 
            if($subComment) 
            {
                $myComment->subComment = $subComment;                
            } else 
            {
                $myComment->subComment = [];
            }
        }
        if($comment)
        {   
            return response()->json($comment, 200);
        }
        else
        {
            return response()->json([
                'message' => 'Error receved comment',
            ], 401);
        }
    } 

}
