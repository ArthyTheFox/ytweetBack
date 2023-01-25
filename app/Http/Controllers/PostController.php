<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    function index() {
        $posts = Post::all();

        return $posts;
    }

    function store(Request $request){
        $post = new Post;

        $imageName = time().'.'.$request['pathMedia']->extension();
        $request['pathMedia']->move(public_path('media'), $imageName);

        $post->content = $request['content'];
        $post->pathMedia = $imageName;
        $post->publishDate = date("Y-m-d H:i:s");
        $post->published = 0;
        $post->userId = 1;

        $post->save();

        return $post;
    }
}
