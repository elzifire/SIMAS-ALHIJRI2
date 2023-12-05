<?php

namespace App\Http\Controllers\Admin;

use App\Models\Leader;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class LeaderController extends Controller 
{

    public function __construct()
    {
        $this->middleware(['permission:leaders.index|leaders.create|leaders.edit|leaders.delete']);
    }

    public function index ()
    {
       
        $leaders = Leader::latest()->when(request()->q, function($leaders){
            $leaders = $leaders->where('name', 'like', '%'. request()->q . '%');
        })->paginate(10);
        return view('admin.leader.index', compact('leaders'));

        
    }

}