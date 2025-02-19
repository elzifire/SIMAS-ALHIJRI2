<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::all();
        return view('admin.contact.index', compact('contacts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
        ]);

        $contact = Contact::create([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
        ]);

        if ($contact) {
            return redirect()->route('admin.contact.index')
                ->with('success', 'Contact created successfully');
        } else {
            return redirect()->route('admin.contact.index')
                ->with('error', 'Contact failed to be created');
        }
    }

//    public function destroy($id)
//    {
//         $contact = Contact::findOrFail($id);
//         $contact->delete();

//         if ($contact) {
//             return response()->json([
//                 'status' => 'success',
//             ]);
//         }else{
//             return response()->json([
//                'status' => 'error',
//             ]);
//         }
//    }

    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        if ($contact) {
            return redirect()->route('admin.contact.index')
                ->with('success', 'Contact deleted successfully.');
        } else {
            return redirect()->route('admin.contact.index')
                ->with('error', 'Contact failed to delete.');
        }
    }

}
