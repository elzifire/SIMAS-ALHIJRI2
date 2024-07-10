<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CategoryVideo;

class CategoryVideoController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:category_videos.index|category_videos.create|category_videos.edit|category_videos.delete']);
    }
    
    public function index()
    {
        $categoryVideos = CategoryVideo::latest()->when(request()->q, function($categoryVideos) {
            $categoryVideos = $categoryVideos->where('name', 'like', '%'. request()->q . '%');
        })->paginate(10);

        if ($categoryVideos) {
            return view('admin.category_video.index', compact('categoryVideos'));
        }
    }

    public function create()
    {
        return view('admin.category_video.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $categoryVideo = CategoryVideo::create([
            'name' => $request->input('name'),
        ]);

        if ($categoryVideo) {
            return redirect()->route('admin.category_videos.index')->with('success', 'Category Video created successfully');
        }else{
            return redirect()->route('admin.category_videos.index')->with('error', 'Category Video failed to be created');
        }
    }

    public function edit(CategoryVideo $categoryVideo)
    {
        return view('admin.category_video.edit', compact('categoryVideo'));
    }

    public function update(Request $request, CategoryVideo $categoryVideo)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $categoryVideo = CategoryVideo::findOrFail($categoryVideo->id);
        $categoryVideo->update([
            'name' => $request->input('name'),
        ]);

        if ($categoryVideo) {
            return redirect()->route('admin.category_videos.index')->with('success', 'Category Video updated successfully');
        }else{
            return redirect()->route('admin.category_videos.index')->with('error', 'Category Video failed to be updated');
        }
    }

    public function destroy($id)
    {
        $categoryVideo = CategoryVideo::findOrFail($id);
        $categoryVideo->delete();

        if ($categoryVideo) {
            return response()->json([
                'status' => 'success',
            ]);
        }else{
            return response()->json([
                'status' => 'error',
            ]);
        }
    }
}
