<?php

namespace App\Http\Controllers\API;

use App\Helpers\APIFormatter;
use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthorController extends Controller
{
    public function index()
    {
        $authors = Author::all();
        return APIFormatter::make(Response::HTTP_OK, 'OK', $authors);
    }

    public function show(Author $author)
    {
        $posts = Post::where('author_id', $author->id)->get();
        return APIFormatter::make(Response::HTTP_OK, 'OK', [
            'author' => $author,
            'posts' => $posts
        ]);
    }
}