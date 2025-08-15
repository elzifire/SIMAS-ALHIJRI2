<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CategoriesCampaign;

class CategoriesCampaignController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:campaigns.index|campaigns.create|campaigns.edit|campaigns.delete']);
    }

    public function index()
    {
        $categories = CategoriesCampaign::latest()
            ->when(request()->q, function ($query) {
                return $query->where('name', 'like', '%' . request()->q . '%');
            })
            ->paginate(10);

        return view('admin.category_campaign.index', compact('categories'));
    }

    public function create()
    {
        $this->middleware('permission:campaigns.create');
        return view('admin.category_campaign.create');
    }

    public function store(Request $request)
    {
        $this->middleware('permission:campaigns.create');

        $request->validate([
            'name' => 'required|string|max:255|unique:categories_campaign,name',
        ]);

        $categories = CategoriesCampaign::create([
            'name' => $request->name,
        ]);

       if ($categories) {
           return redirect()->route('admin.category_campaign.index')
               ->with('success', 'Kategory Program Kampanye berhasil dibuat .');
       }else{
           return redirect()->route('admin.category_campaign.index')
               ->with('error', 'Kategory Program Kampanye gagal dibuat .');
       }
    }

    public function edit(CategoriesCampaign $category_campaign)
    {
        $this->middleware('permission:campaigns.edit');
        return view('admin.category_campaign.edit', compact('category_campaign'));
    }

   public function update(Request $request, CategoriesCampaign $category_campaign)
{
    $this->middleware('permission:campaigns.edit');

    $request->validate([
        'name' => 'required|string|max:255|unique:categories_campaign,name,' . $category_campaign->id,
    ]);

    $category_campaign->update([
        'name' => $request->name,
    ]);

    if ($category_campaign) {
        return redirect()->route('admin.category_campaign.index')
            ->with('success', 'Kategori Program Kampanye berhasil diperbarui.');
    } else {
        return redirect()->route('admin.category_campaign.index')
            ->with('error', 'Kategori Program Kampanye gagal diperbarui.');
    }
}


    public function destroy(CategoriesCampaign $categoriesCampaign)
    {
        $this->middleware('permission:campaigns.delete');

        $categoriesCampaign->delete();

        return redirect()->route('admin.categories_campaign.index')
            ->with('success', 'Category Campaign deleted successfully.');
    }
}
