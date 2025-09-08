<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('permission_role', function (Blueprint $table) {
            $table->boolean('allow')->default(true);
        });
    }

    public function down(): void
    {
        Schema::table('permission_role', function (Blueprint $table) {
            $table->dropColumn('allow');
        });
    }
};
