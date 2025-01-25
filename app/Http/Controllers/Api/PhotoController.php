<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Photo;


class PhotoController extends Controller
{
        
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        $photos = Photo::latest()->paginate(6);
        return response()->json([
            "response" => [
                "status"    => 200,
                "message"   => "List Data Foto"
            ],
            "data" => $photos
        ], 200);
    }
    
    /**
     * PhotoHomePage
     *
     * @return void
     */
    public function PhotoHomePage()
    {
        $photos = Photo::latest()->take(6)->get();
        return response()->json([
            "response" => [
                "status"    => 200,
                "message"   => "List Data Foto Homepage"
            ],
            "data" => $photos
        ], 200);
    }

    // just category_id = 1
    public function PhotoCategory()
    {
        // Optimized query
        // $photos = Photo::where('category_id', 1)->latest()->get();
        $photos = Photo::where('category_id', 1)->latest()->paginate(6);

        if ($photos) {
            return response()->json([
                "response" => [
                    "status"    => 200,
                    "message"   => "List Data Foto Kategori"
                ],
                "data" => $photos
            ], 200);
        } else {
            return response()->json([
                "response" => [
                    "status"    => 404,
                    "message"   => "Data Foto Kategori Tidak Ditemukan"
                ],
                "data" => null
            ], 404);
        }
    }

    
}