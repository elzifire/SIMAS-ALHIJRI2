<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;

/**
 * PostController
 */
class PostController extends Controller
{
        
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        $posts = Post::latest()->orderBy('date', 'desc')->paginate(20);
        return response()->json([
            "response" => [
                "status"    => 200,
                "message"   => "List Data Posts"
            ],
            "data" => $posts
        ], 200);
    }
   
    /**
     * show
     *
     * @param  mixed $slug
     * @return void
     */
    public function show($slug)
    {
        $post = Post::where('slug', $slug)->first();

        if($post) {

            return response()->json([
                "response" => [
                    "status"    => 200,
                    "message"   => "Detail Data Post"
                ],
                "data" => $post
            ], 200);

        } else {

            return response()->json([
                "response" => [
                    "status"    => 404,
                    "message"   => "Data Post Tidak Ditemukan!"
                ],
                "data" => null
            ], 404);

        }
    }

    
    /**
     * PostHomePage
     *
     * @return void
     */
    public function PostHomePage()
    {
        $posts = Post::latest()->take(6)->with('category')->get();
        return response()->json([
            "response" => [
                "status"    => 200,
                "message"   => "List Data Posts Homepage"
            ],
            "data" => $posts
        ], 200);
    }

    // menampilkan data post berdasarkan category dengan id 1 
    public function PostCategory($slug)
    {
        $posts = Post::whereHas('category', function($query) use ($slug) {
            $query->where('slug', $slug);
        })->latest()->paginate(6);
        return response()->json([
            "response" => [
                "status"    => 200,
                "message"   => "List Data Posts By Category"
            ],
            "data" => $posts
        ], 200);
    }
}