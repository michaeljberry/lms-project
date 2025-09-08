<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->text('learning_objectives')->nullable();
            $table->json('skills')->nullable();
            $table->json('interests')->nullable();
            $table->json('badges')->nullable();
            $table->json('certifications')->nullable();
            $table->json('accessibility_preferences')->nullable();
            $table->string('timezone')->nullable();
            $table->string('location')->nullable();
            $table->string('avatar_path')->nullable();
            $table->boolean('consent_marketing')->default(false);
            $table->boolean('consent_research')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn([
                'learning_objectives',
                'skills',
                'interests',
                'badges',
                'certifications',
                'accessibility_preferences',
                'timezone',
                'location',
                'avatar_path',
                'consent_marketing',
                'consent_research',
            ]);
        });
    }
};
