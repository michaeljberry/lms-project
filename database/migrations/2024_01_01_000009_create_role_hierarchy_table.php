<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('role_hierarchy', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->constrained('roles')->cascadeOnDelete();
            $table->foreignId('child_id')->constrained('roles')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('role_hierarchy');
    }
};
