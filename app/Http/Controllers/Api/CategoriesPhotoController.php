<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CategoriesPhoto;

class CategoriesPhotoController extends Controller
{
    public function index()
    {
        $categories = CategoriesPhoto::latest()->paginate(10);
        return response()->json([
            "response" => [
                "status"    => 200,
                "message"   => "List Data Kategori Foto"
            ],
            "data" => $categories
        ], 200);
    }
}
