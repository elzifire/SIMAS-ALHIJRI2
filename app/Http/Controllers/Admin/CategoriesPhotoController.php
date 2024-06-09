<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CategoriesPhoto;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;


class CategoriesPhotoController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:photos.index|photos.create|photos.delete']);
    }

    public function index()
    {
        $categories = CategoriesPhoto::latest()
            ->when(request()->q, function ($categories) {
                $categories = $categories->where('title', 'like', '%' . request()->q . '%');
            })
            ->paginate(10);

        return view('admin.categories_photo.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'date' => 'required',
            'image' => 'required|image:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $image = $request->file('image');
        $image->storeAs('public/photos', $image->hashName());

        $category = CategoriesPhoto::create([
            'title' => $request->input('title'),
            'slug' => Str::slug($request->input('title')),
            'desc' => $request->input('desc'),
            'date' => $request->input('date'),
            'image' => $image->hashName(),
        ]);

       if ($category) {
            return redirect()->route('admin.categories_photo.index')->with('success', 'Category created successfully');
        } else {
            return redirect()->route('admin.categories_photo.index')->with('error', 'Category failed to create');
       }

    }

    // remove the specified resource from storage

    public function destroy($id)
    {
        $category = CategoriesPhoto::findOrFail($id);
        Storage::disk('local')->delete('public/photos/' . $category->image);
        $category->delete();

        if ($category) {
            return response()->json([
                'status' => 'success',
            ]);
        }else {
            return response()->json([
                'status' => 'error',
            ]);
        }

    }
}
