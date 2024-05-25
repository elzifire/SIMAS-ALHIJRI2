<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::all();
        return response()->json([
            'message' => 'Contact index',
            'status' => 200,
            'data' => $contacts,
        ]);
    }
}
