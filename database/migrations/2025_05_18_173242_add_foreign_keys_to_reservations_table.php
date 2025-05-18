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
        Schema::table('reservations', function (Blueprint $table) {
            $table->foreign(['service_id'], 'reservations_service_id_fkey')->references(['id'])->on('services')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['user_id'], 'reservations_user_id_fkey')->references(['id'])->on('users')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropForeign('reservations_service_id_fkey');
            $table->dropForeign('reservations_user_id_fkey');
        });
    }
};
