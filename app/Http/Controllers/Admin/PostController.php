<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['permission:posts.index|posts.create|posts.edit|posts.delete']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::latest()->orderBy('date', 'desc')->when(request()->q, function($posts) {
            $posts = $posts->where('title', 'like', '%'. request()->q . '%');
        })->paginate(10);

        return view('admin.post.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = Tag::latest()->get();
        $categories = Category::latest()->get();
        // $Posts = Post::latest()->take(5)->get();
        return view('admin.post.create', compact('tags', 'categories'));
    }

    public function show($id)
{
    $post = Post::findOrFail($id);
    return view('post.show', compact('post'));
}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'image'         => 'required|image|mimes:jpeg,jpg,png|max:2000',
            'title'         => 'required|unique:posts',
            'category_id'   => 'required',
            'content'       => 'required',
            'date'          => 'required|date',
        ]);

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/posts', $image->hashName());
        // content
        $content = $request->input('content');
        // desc
        $desc = substr($content, 0, strpos($content, '.') + 1);
        
        $post = Post::create([
            'image'       => $image->hashName(),
            'title'       => $request->input('title'),
            'slug'        => Str::slug($request->input('title'), '-'),
            'category_id' => $request->input('category_id'),
            'content'     => $content,
            'date'        => $request->input('date'),
            'author'      => auth()->user()->name,  
            'desc'        => $desc
        ]);

        //assign tags
        $post->tags()->attach($request->input('tags'));
        $post->save();

        if($post){
            //redirect dengan pesan sukses
            return redirect()->route('admin.post.index')->with(['success' => 'Data Berhasil Disimpan!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.post.index')->with(['error' => 'Data Gagal Disimpan!']);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $tags = Tag::latest()->get();
        $categories = Category::latest()->get();
        return view('admin.post.edit', compact('post', 'tags', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $this->validate($request,[
            'title'         => 'required|unique:posts,title,'.$post->id,
            'category_id'   => 'required',
            'content'       => 'required',
        ]);
        

        if ($request->file('image') == "") {
            // content
            $content = $request->input('content');
            $desc = substr($content, 0, strpos($content, '.') + 1);
            $post = Post::findOrFail($post->id);
            $post->update([
                'title'       => $request->input('title'),
                'slug'        => Str::slug($request->input('title'), '-'),
                'category_id' => $request->input('category_id'),
                'content'     => $content,
                'date'        => $request->input('date'),
                'author'      => auth()->user()->name,
                'desc'        => $desc
            ]);

        } else {

            //remove old image
            Storage::disk('local')->delete('public/posts/'.$post->image);

            //upload new image
            $image = $request->file('image');
            $image->storeAs('public/posts', $image->hashName());
            $content = $request->input('content');
            $desc = substr($content, 0, strpos($content, '.') + 1);
            // content
            $content = $request->input('content');

            $post = Post::findOrFail($post->id);
            $post->update([
                'image'       => $image->hashName(),
                'title'       => $request->input('title'),
                'slug'        => Str::slug($request->input('title'), '-'),
                'category_id' => $request->input('category_id'),
                'content'     => $content,
                'date'        => $request->input('date'),
                'author'      => auth()->user()->name,  
            ]);

        }

        //assign tags
        $post->tags()->sync($request->input('tags'));

        if($post){
            //redirect dengan pesan sukses
            return redirect()->route('admin.post.index')->with(['success' => 'Data Berhasil Diupdate!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.post.index')->with(['error' => 'Data Gagal Diupdate!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
    //     $post = Post::findOrFail($id);
    //     $image = Storage::disk('local')->delete('public/posts/'.basename($post->image));
    //     $post->delete();

    //     if($post){
    //         return response()->json([
    //             'status' => 'success'
    //         ]);
    //     }else{
    //         return response()->json([
    //             'status' => 'error'
    //         ]);
    //     }
    // }
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        //remove old image
        Storage::disk('local')->delete('public/posts/'.$post->image);
        $post->tags()->detach();
        $post->delete();

        if($post){
            //redirect dengan pesan sukses
            return redirect()->route('admin.post.index')->with(['success' => 'Data Berhasil Dihapus!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.post.index')->with(['error' => 'Data Gagal Dihapus!']);
        }
    }
}