<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->foreign(['doctor_id'], 'reviews_doctor_id_fkey')->references(['id'])->on('dentists')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['user_id'], 'reviews_user_id_fkey')->references(['id'])->on('users')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropForeign('reviews_doctor_id_fkey');
            $table->dropForeign('reviews_user_id_fkey');
        });
    }
};
