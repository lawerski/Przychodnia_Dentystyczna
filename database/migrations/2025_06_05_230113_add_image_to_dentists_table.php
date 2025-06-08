<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('dentists', function (Blueprint $table) {
            $table->string('image_path')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('dentists', function (Blueprint $table) {
            $table->dropColumn('image_path');
        });
    }
};