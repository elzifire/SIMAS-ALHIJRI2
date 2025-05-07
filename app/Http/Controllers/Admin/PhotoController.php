<?php

namespace App\Http\Controllers\Admin;

use App\Models\Photo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CategoriesPhoto;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['permission:photos.index|photos.create|photos.delete']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $photos = Photo::latest()
            ->when(request()->q, function ($photos) {
                $photos = $photos->where('title', 'like', '%' . request()->q . '%');
            })
            ->paginate(10);
        
        $categories = CategoriesPhoto::all()->sortBy('name');


        return view('admin.photo.index', compact('photos', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'heading' => 'required',
            'date' => 'required',
            'caption' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            
        ]);

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/photos', $image->hashName());

        $photo = Photo::create([
            'heading' => $request->input('heading'),
            'caption' => $request->input('caption'),
            'date' => $request->input('date'),
            'image' => $image->hashName(),
           'category_id' => $request->input('category_photo_id'),
        ]);

        if ($photo) {
            //redirect dengan pesan sukses
            return redirect()
                ->route('admin.photo.index')
                ->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()
                ->route('admin.photo.index')
                ->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $photo = Photo::findOrFail($id);
        $image = Storage::disk('local')->delete('public/photos/' . basename($photo->image));
        $photo->delete();

        if ($photo) {
            return response()->json([
                'status' => 'success',
            ]);
        } else {
            return response()->json([
                'status' => 'error',
            ]);
        }
    }
}
