<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;

class ServiceController extends Controller
{
    
    public function __construct()
    {
        $this->middleware(['permission:services.index|services.create|services.edit|services.delete']);
    }

    public function index()
    {
        $services = Service::all();
        return view('admin.service.index', compact('services'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'url' => 'required',
        ]);

        Service::create($request->all());

        return redirect()->route('admin.service.index')->with('success', 'Service created successfully');
    }

    public function destroy($id)
    {
        $service = Service::findorFail($id);
        $service->delete();

        // return redirect()->route('admin.service.index')->with('success', 'Service deleted successfully');
        if ($service) {
            return redirect()->route('admin.service.index')->with('success', 'Service deleted successfully');
        }else{
            return redirect()->route('admin.service.index')->with('error', 'Service not found');
        }

    }

}
