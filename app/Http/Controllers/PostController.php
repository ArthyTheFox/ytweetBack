<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\postFaculty;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::select(
            'posts.*',
            'users.id as idUser',
            'users.username',
            'users.lastname',
            'users.firstname',
            DB::raw('(SELECT COUNT(*) FROM likes WHERE likes.idPost = posts.id) as nbreLike'),
            DB::raw('(SELECT likes.id FROM likes WHERE likes.idPost = posts.id AND likes.idUser =' . $request->query('idUserConnected') . ') as isLike'),
            DB::raw('(SELECT COUNT(*) FROM comments WHERE comments.idPost = posts.id) as nbreComment'),
            DB::raw('JSON_ARRAYAGG(faculties.type) AS faculties')
        )
            ->join('users', 'users.id', '=', 'posts.userId')
            ->leftJoin('post_faculties', 'post_faculties.idPost', '=', 'posts.id')
            ->leftJoin('faculties', 'faculties.id', '=', 'post_faculties.idFaculty')
            ->where('isArchived', false)
            ->orderBy('posts.id', 'desc')
            ->groupBy('posts.id')
            ->get();

        return $posts;
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required',
        ]);
        $post = new Post;
        if ($request['pathMedia']) {
            $imageName = time() . '.' . $request['pathMedia']->extension();
            $request['pathMedia']->move(public_path('media'), $imageName);
            $post->pathMedia = $imageName;
        }
        $post->content = $request['content'];
        $post->publishDate = date("Y-m-d H:i:s");
        $post->userId = $request['userId'];
        $post->save();

        if ($request['faculties']) {
            foreach ($request['faculties'] as $item) {
                $faculty = new postFaculty;
                $faculty->idPost = $post->id;
                $faculty->idFaculty = $item->idFaculty;
                $faculty->save();
            }
        }

        return $post;
    }

    public function show(Request $request, $id)
    {
        $post = Post::select(
            'posts.*',
            'users.id as idUser',
            'users.username',
            'users.lastname',
            'users.firstname',
            'likes.nbreLike',
            DB::raw('(SELECT likes.id FROM likes WHERE likes.idPost = posts.id AND likes.idUser =' . $request->query('idUserConnected') . ') as isLike'),
            DB::raw('(SELECT COUNT(*) FROM comments WHERE comments.idPost = posts.id) as nbreComment'),
            DB::raw('JSON_ARRAYAGG(faculties.type) AS faculties')
        )
            ->join('users', 'users.id', '=', 'posts.userId')
            ->leftJoinSub(
                Like::selectRaw('idPost, COUNT(*) as nbreLike')
                    ->groupBy('idPost'),
                'likes',
                'likes.idPost',
                '=',
                'posts.id'
            )
            ->leftJoin('post_faculties', 'post_faculties.idPost', '=', 'posts.id')
            ->leftJoin('faculties', 'faculties.id', '=', 'post_faculties.idFaculty')
            ->where('isArchived', false) // Todo à changer
            ->where('posts.id', $id)
            ->groupBy('posts.id')
            ->first();
        return $post;
    }

    public function showByUser(Request $request, $username)
    {
        $user = User::where('username', $username)->first();

        if ($user) {
            $posts = Post::select(
                'posts.*',
                'users.id as idUser',
                'users.username',
                'users.lastname',
                'users.firstname',
                DB::raw('(SELECT COUNT(*) FROM likes WHERE likes.idPost = posts.id) as nbreLike'),
                DB::raw('(SELECT likes.id FROM likes WHERE likes.idPost = posts.id AND likes.idUser =' . $request->query('idUserConnected') . ') as isLike'),
                DB::raw('(SELECT COUNT(*) FROM comments WHERE comments.idPost = posts.id) as nbreComment'),
                DB::raw('JSON_ARRAYAGG(faculties.type) AS faculties')
            )
                ->join('users', 'users.id', '=', 'posts.userId')
                ->leftJoin('post_faculties', 'post_faculties.idPost', '=', 'posts.id')
                ->leftJoin('faculties', 'faculties.id', '=', 'post_faculties.idFaculty')
                ->where('isArchived', false) //Todo à changer
                ->where('userId', $user->id)
                ->orderBy('posts.id', 'desc')
                ->groupBy('posts.id')
                ->get();
            return $posts;
        }
        return response()->json('Utilisateur non trouvé');
    }

    public function getByLiked(Request $request, $username)
    {
        $user = User::where('username', $username)->first();

        if ($user) {
            $posts = Post::select(
                'posts.*',
                'users.id as idUser',
                'users.username',
                'users.lastname',
                'users.firstname',
                DB::raw('(SELECT COUNT(*) FROM likes WHERE likes.idPost = posts.id) as nbreLike'),
                DB::raw('(SELECT likes.id FROM likes WHERE likes.idPost = posts.id AND likes.idUser =' . $request->query('idUserConnected') . ') as isLike'),
                DB::raw('(SELECT COUNT(*) FROM comments WHERE comments.idPost = posts.id) as nbreComment'),
                DB::raw('JSON_ARRAYAGG(faculties.type) AS faculties')
            )
                ->join('users', 'users.id', '=', 'posts.userId')
                ->join('likes', 'likes.idPost', '=', 'posts.id')
                ->leftJoin('post_faculties', 'post_faculties.idPost', '=', 'posts.id')
                ->leftJoin('faculties', 'faculties.id', '=', 'post_faculties.idFaculty')
                ->where('likes.idUser', $user->id)
                ->where('isArchived', false)
                ->orderBy('posts.id', 'desc')
                ->groupBy('posts.id')
                ->get();
            return $posts;
        }

        return response()->json('Utilisateur non trouvé');
    }

    public function getPostByFaculty (Request $request, $id)  {
        $posts = Post::select(
            'posts.*',
            'users.id as idUser',
            'users.username',
            'users.lastname',
            'users.firstname',
            DB::raw('(SELECT COUNT(*) FROM likes WHERE likes.idPost = posts.id) as nbreLike'),
            DB::raw('(SELECT likes.id FROM likes WHERE likes.idPost = posts.id AND likes.idUser =' . $request->query('idUserConnected') . ') as isLike'),
            DB::raw('(SELECT COUNT(*) FROM comments WHERE comments.idPost = posts.id) as nbreComment'),
            DB::raw('JSON_ARRAYAGG(faculties.type) AS faculties')
        )
            ->join('users', 'users.id', '=', 'posts.userId')
            ->leftJoin('post_faculties', 'post_faculties.idPost', '=', 'posts.id')
            ->leftJoin('faculties', 'faculties.id', '=', 'post_faculties.idFaculty')
            ->where('isArchived', false)
            ->where('post_faculties.idFaculty', $id)
            ->orderBy('posts.id', 'desc')
            ->groupBy('posts.id')
            ->get();

        return $posts;
    }
}
