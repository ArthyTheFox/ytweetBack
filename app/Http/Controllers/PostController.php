<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::select('posts.*', 'users.username', 'users.lastname', 'users.firstname')
            ->join('users', 'users.id', '=', 'posts.userId')
            ->where('isArchived', false)
            ->orderBy('posts.id', 'desc')
            ->get();

        return $posts;
    }

    public function store(Request $request)
    {
        $post = new Post;

        if ($request['pathMedia']) 
        {
            $imageName = time() . '.' . $request['pathMedia']->extension();
            $request['pathMedia']->move(public_path('media'), $imageName);
            $post->pathMedia = $imageName;
        }
        $post->content = $request['content'];
        $post->publishDate = date("Y-m-d H:i:s");
        $post->published = $request['published'];
        $post->userId = $request['userId'];
        $post->save();
        return $post;
    }

    public function show($id)
    {
        $post = Post::select('posts.*', 'users.username', 'users.lastname', 'users.firstname', 'likes.nbreLike')
        ->join('users', 'users.id', '=', 'posts.userId')
        ->leftJoinSub(
            Like::selectRaw('idPost, COUNT(*) as nbreLike')
                ->groupBy('idPost'),
            'likes',
            'likes.idPost',
            '=',
            'posts.id'
        )
        ->where('isArchived', false)
        ->where('posts.id', $id)
        ->first();
            return $post; 
    }

    public function showByIdUser($id)
    {
        $posts = Post::select('posts.*', 'users.username')
            ->join('users', 'users.id', '=', 'posts.userId')
            ->where('isArchived', false)
            ->where('userId', $id)
            ->get();
        return $posts;
    }
}
