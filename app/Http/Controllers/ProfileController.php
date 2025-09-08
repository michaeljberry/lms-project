<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        $profile = $request->user()->profile;

        if ($profile) {
            // Allow users to view only their own profile
            $this->authorize('view', $profile);
            return response()->json($profile);
        }

        return response()->json(null);
    }

    public function update(Request $request)
    {
        $user = $request->user();

        // Authorize that the authenticated user can update this user (themself)
        $this->authorize('update', $user);

        $profile = $user->profile ?: $user->profile()->make();

        $data = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'bio' => 'nullable|string',
            'learning_objectives' => 'nullable|string',
            'skills' => 'nullable|array',
            'skills.*' => 'string',
            'interests' => 'nullable|array',
            'interests.*' => 'string',
            'badges' => 'nullable|array',
            'badges.*' => 'string',
            'certifications' => 'nullable|array',
            'certifications.*' => 'string',
            'accessibility_preferences' => 'nullable|array',
            'timezone' => 'nullable|string',
            'location' => 'nullable|string',
            'consent_marketing' => 'sometimes|boolean',
            'consent_research' => 'sometimes|boolean',
            'avatar' => 'nullable|image',
        ]);

        if (isset($data['avatar'])) {
            // tests can use Storage::fake('public')
            $path = $data['avatar']->store('avatars', 'public');
            $data['avatar_path'] = $path;
            unset($data['avatar']);
        }

        $profile->fill($data);
        $user->profile()->save($profile);

        return response()->json($profile);
    }
}