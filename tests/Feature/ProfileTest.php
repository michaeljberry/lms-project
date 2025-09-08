<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_can_be_updated_with_extended_fields(): void
    {
        $this->withoutExceptionHandling();
        Storage::fake('public');
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'sanctum')->put('/api/profile', [
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'bio' => 'Hello',
            'learning_objectives' => 'Learn PHP',
            'skills' => ['PHP', 'Laravel'],
            'interests' => ['AI'],
            'badges' => ['starter'],
            'certifications' => ['cert1'],
            'accessibility_preferences' => ['font' => 'large'],
            'timezone' => 'UTC',
            'location' => 'Earth',
            'consent_marketing' => true,
            'consent_research' => false,
            'avatar' => UploadedFile::fake()->image('avatar.jpg'),
        ]);

        $response->dump();
        $response->assertOk();
    }
}
