<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CategoriesPhoto;

class CategoriesPhotoController extends Controller
{
    public function index()
{
    $categories = CategoriesPhoto::where('category_id', 1)
                                 ->whereNotNull('deleted_at')
                                 ->get();

    return response()->json([
        "response" => [
            "status"    => 200,
            "message"   => "List Data Kategori Foto yang Sudah Dihapus (Soft Delete)"
        ],
        "data" => $categories
    ], 200);
}

}
