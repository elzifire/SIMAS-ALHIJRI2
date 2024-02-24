<?php

namespace App\Http\Controllers;

use App\Models\Muadzin;
use App\Http\Requests\StoremuadzinRequest;
use App\Http\Requests\UpdatemuadzinRequest;

class MuadzinController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
     public function __construct()
     {
         $this->middleware(['permission:leaders.index|leaders.create|leaders.edit|leaders.delete']);
     }

    public function index()
    {
        //
        {
            $muadzins = muadzin::latest()->when(request()->q, function($muadzins){
                $muadzins = $muadzins->where('name', 'like', '%'. request()->q . '%');
            })->paginate(10);
            return view('admin.muadzin.index', compact('muadzins'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoremuadzinRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(muadzin $muadzin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(muadzin $muadzin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatemuadzinRequest $request, muadzin $muadzin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(muadzin $muadzin)
    {
        //
    }
}
