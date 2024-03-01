<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;


class ContactController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:contacts.index|contacts.create|contacts.edit|contacts.delete']);
    }


    public function index()
    {
        $contacts = Contact::latest()->when(request()->q, function($contacts){
            $contacts = $contacts->where('name', 'like', '%' . request()->q . '%');
        })->paginate(10);
            return view('admin.contact.index', compact('contacts'));
    }

    public function create()
    {
        return view('admin.contact.create');
    }

    

}
