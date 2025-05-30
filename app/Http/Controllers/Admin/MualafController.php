<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pendaftaran;
use App\Models\Saksi;

class MualafController extends Controller
{
   public function __construct()
   {
      $this->middleware(['permission:mualafs.index|mualafs.show']);
   }

   public function index()
   {
   $mualafs = Pendaftaran::latest()->when(request()->q, function($mualafs){
      $mualafs = $mualafs->where('nama', 'like', '%'. request()->q . '%');
   })->paginate(5);
    return view('admin.mualaf.index', compact('mualafs'));
   }
   
   public function show($id)
   {
    $mualaf = Pendaftaran::findOrFail($id);
    return view('admin.mualaf.show', compact('mualaf'));
   }
}
