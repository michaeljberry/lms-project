<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'bio',
        'learning_objectives',
        'skills',
        'interests',
        'badges',
        'certifications',
        'accessibility_preferences',
        'timezone',
        'location',
        'consent_marketing',
        'consent_research',
        'avatar_path',
    ];

    protected $casts = [
        'skills' => 'array',
        'interests' => 'array',
        'badges' => 'array',
        'certifications' => 'array',
        'accessibility_preferences' => 'array',
        'consent_marketing' => 'boolean',
        'consent_research' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
