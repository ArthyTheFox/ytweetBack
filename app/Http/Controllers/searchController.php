<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class searchController extends Controller
{
    public function show(Request $request)
    {
        $txt = $request['txt'];
        if ($txt) 
        {
            $letter0 = $txt[0];
            if ($letter0 == '@') 
            {
                $user = preg_replace('/^.*@/', '', $txt); //retire @
                $results = User::where('username', $user)->first();
                if ($results) 
                {
                    $posts = Post::select(
                        'posts.*',
                        'users.username',
                        'users.lastname',
                        'users.firstname',
                        DB::raw('(SELECT COUNT(*) FROM likes WHERE likes.idPost = posts.id) as nbreLike'),
                        DB::raw('(SELECT likes.id FROM likes WHERE likes.idPost = posts.id AND likes.idUser =' 
                        . $request->query('idUserConnected') . ') as isLike'),
                        DB::raw('(SELECT COUNT(*) FROM comments WHERE comments.idPost = posts.id) as nbreComment')
                    )
                        ->join('users', 'users.id', '=', 'posts.userId')
                        ->where('isArchived', false)
                        ->where('posts.userId', $results->id)
                        ->orderBy('posts.id', 'desc')
                        ->get();

                    return $posts;
                } 
                else 
                {
                    return response()->json([
                        'message' => 'No user found.',
                    ]); 
                }
            } 
            else if ($letter0 == '#') 
            {
            } 
            else 
            {
                if(strlen($txt) > 2)
                {
                    $posts = Post::select(
                        'posts.*',
                        'users.username',
                        'users.lastname',
                        'users.firstname',
                        DB::raw('(SELECT COUNT(*) FROM likes WHERE likes.idPost = posts.id) as nbreLike'),
                        DB::raw('(SELECT likes.id FROM likes WHERE likes.idPost = posts.id AND likes.idUser =' 
                        . $request->query('idUserConnected') . ') as isLike'),
                        DB::raw('(SELECT COUNT(*) FROM comments WHERE comments.idPost = posts.id) as nbreComment')
                    )
                        ->join('users', 'users.id', '=', 'posts.userId')
                        ->where('isArchived', false)
                        ->where('posts.content', 'LIKE', '%'.$txt.'%')
                        ->orderBy('posts.id', 'desc')
                        ->get();
    
                    if(count($posts) > 0)
                    {
                        return $posts;
                    }
                    else 
                    {
                        return response()->json([
                            'message' => 'No post found.',
                        ]);
                    }
                } 
                else
                {
                    return response()->json([
                        'message' => 'not enough character.',
                    ]);   
                }
            }
        }
    }
}
