<?php

namespace App\Http\Controllers\API;

use App\Models\Post;
use Illuminate\Support\Str;
use Spatie\FlareClient\Api;
use Illuminate\Http\Request;
use App\Helpers\APIFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::paginate(8);
        foreach ($posts as $post) {
            $post->category_id = $post->category->name;
            $post->author_id = $post->author->name;
        }
        return APIFormatter::make(200, 'OK', $posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return APIFormatter::make(Response::HTTP_UNPROCESSABLE_ENTITY, 'ready', $request->all());
        $validator = Validator::make($request->all(), [
            'title' => ['required'],
            'slug' => ['required'],
            'author' => ['required'],
            'text' => ['required'],
        ]);

        if ($validator->fails()) {
            return APIFormatter::make(Response::HTTP_UNPROCESSABLE_ENTITY, 'failed');
        }
        Post::create($request->all());
        return APIFormatter::make(Response::HTTP_CREATED, 'data has been created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        Post::find($post->id)->increment('views');
        $post->category_id = $post->category->name;
        $post->author_id = $post->author->name;
        return APIFormatter::make(Response::HTTP_OK, 'OK', $post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return APIFormatter::make(Response::HTTP_NOT_FOUND, 'not found');
        }
        return APIFormatter::make(Response::HTTP_OK, 'OK', $post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required'],
            'slug' => ['required'],
            'author' => ['required'],
            'text' => ['required'],
        ]);
        return APIFormatter::make(Response::HTTP_CREATED, [$id, $id + 1], $request->all());
        if ($validator->fails()) {
            return APIFormatter::make(Response::HTTP_UNPROCESSABLE_ENTITY, 'failed');
        }
        return APIFormatter::make(Response::HTTP_OK, 'data has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return APIFormatter::make(Response::HTTP_NOT_FOUND, 'not found');
        }
        Post::destroy($id);
        return APIFormatter::make(Response::HTTP_OK, 'data has been deleted');
    }
}