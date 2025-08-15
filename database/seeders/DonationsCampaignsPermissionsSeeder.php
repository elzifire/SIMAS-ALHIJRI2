<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class DonationsCampaignsPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Permissions for donations
        Permission::firstOrCreate(['name' => 'donations.index']);
        Permission::firstOrCreate(['name' => 'donations.create']);
        Permission::firstOrCreate(['name' => 'donations.edit']);
        Permission::firstOrCreate(['name' => 'donations.delete']);

        // Permissions for campaigns
        Permission::firstOrCreate(['name' => 'campaigns.index']);
        Permission::firstOrCreate(['name' => 'campaigns.create']);
        Permission::firstOrCreate(['name' => 'campaigns.edit']);
        Permission::firstOrCreate(['name' => 'campaigns.delete']);
    }
}
