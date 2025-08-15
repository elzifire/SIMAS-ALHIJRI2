<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\Campaign;
use App\Models\Donation;
use App\Models\Status;
use App\Models\User;

class DonationControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed status
        Status::insert([
            ['name' => 'pending'],
            ['name' => 'approved'],
            ['name' => 'rejected'],
        ]);
    }

    /** @test */
    public function it_can_list_active_campaigns()
    {
        $campaign = Campaign::factory()->create(['status' => 'active']);

        $this->getJson('/api/donations')
            ->assertStatus(200)
            ->assertJsonFragment([
                'id' => $campaign->id,
                'title' => $campaign->title,
            ]);
    }

    /** @test */
    public function it_can_show_campaign_detail()
    {
        $campaign = Campaign::factory()->create(['status' => 'active']);

        $this->getJson("/api/donations/{$campaign->id}")
            ->assertStatus(200)
            ->assertJsonFragment([
                'id' => $campaign->id,
                'title' => $campaign->title,
            ]);
    }

    /** @test */
    public function it_returns_404_for_nonexistent_campaign()
    {
        $this->getJson('/api/donations/999')
            ->assertStatus(404)
            ->assertJson([
                'status' => 'error'
            ]);
    }

    /** @test */
    public function it_can_store_donation_as_guest()
    {
        Storage::fake('public');

        $campaign = Campaign::factory()->create([
            'status' => 'active',
            'expired' => now()->addDays(5)
        ]);

        $file = UploadedFile::fake()->image('proof.jpg');

        $response = $this->postJson('/api/donations', [
            'campaign_id' => $campaign->id,
            'amount' => '15000',
            'proof_image' => $file,
            'name' => 'Guest Donor',
            'phone_number' => '08123456789'
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'status' => 'success'
            ]);

        $this->assertDatabaseHas('donations', [
            'campaign_id' => $campaign->id,
            'amount' => 15000
        ]);
    }

    /** @test */
    public function it_can_store_donation_as_authenticated_user()
    {
        Storage::fake('public');

        $user = User::factory()->create();

        $campaign = Campaign::factory()->create([
            'status' => 'active',
            'expired' => now()->addDays(5)
        ]);

        $file = UploadedFile::fake()->image('proof.jpg');

        $response = $this->actingAs($user)->postJson('/api/donations', [
            'campaign_id' => $campaign->id,
            'amount' => '20000',
            'proof_image' => $file,
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('donations', [
            'user_id' => $user->id,
            'campaign_id' => $campaign->id,
            'amount' => 20000
        ]);
    }

    /** @test */
    public function it_fails_when_campaign_is_inactive()
    {
        Storage::fake('public');

        $campaign = Campaign::factory()->create(['status' => 'inactive']);

        $file = UploadedFile::fake()->image('proof.jpg');

        $response = $this->postJson('/api/donations', [
            'campaign_id' => $campaign->id,
            'amount' => '15000',
            'proof_image' => $file,
            'name' => 'Test User',
            'phone_number' => '08123456789'
        ]);

        $response->assertStatus(400)
            ->assertJson([
                'status' => 'error'
            ]);
    }
}
