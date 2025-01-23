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
                $categories = $categories->where('name', 'like', '%' . request()->q . '%');
            })
            ->paginate(10);

        return view('admin.categories_photo.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories_photo.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $category = CategoriesPhoto::create([
            'name' => $request->input('name'),
        ]);

        if ($category) {
            return redirect()->route('admin.categories_photo.index')->with('success', 'Category created successfully');
        } else {
            return redirect()->route('admin.categories_photo.index')->with('error', 'Category failed to be created');
        }
    }

    public function edit(CategoriesPhoto $category)
    {
        return view('admin.categories_photo.edit', compact('category'));
    }

    public function update(Request $request, CategoriesPhoto $category)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $category = CategoriesPhoto::findOrFail($category->id);

        $category->name = $request->input('name');

        if ($category->save()) {
            return redirect()->route('admin.categories_photo.index')->with('success', 'Category updated successfully');
        } else {
            return redirect()->route('admin.categories_photo.index')->with('error', 'Category failed to be updated');
        }
    }

    public function destroy($id)
    {
        $categories = CategoriesPhoto::findOrFail($id);
        $categories->delete();

        if ($categories) {
            return redirect()->route('admin.categories_photo.index')->with('success', 'Category deleted successfully');
        } else {
            return redirect()->route('admin.categories_photo.index')->with('error', 'Category failed to be deleted');
        }
    }
    
    
}
