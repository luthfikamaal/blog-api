<?php

namespace App\Http\Controllers\API;

use App\Helpers\APIFormatter;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return APIFormatter::make(Response::HTTP_OK, 'OK', $categories);
    }

    public function show(Category $category)
    {
        $posts = Post::where('category_id', $category->id)->get();
        return APIFormatter::make(Response::HTTP_OK, 'OK', [
            'category' => $category,
            'posts' => $posts
        ]);
    }
}