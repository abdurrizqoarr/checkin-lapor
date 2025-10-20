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
        Schema::create('checkin_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // Relasi ke user
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Relasi ke point_qr
            $table->uuid('point_qr_id');
            $table->foreign('point_qr_id')->references('id')->on('point_qr')->onDelete('cascade');

            // Waktu checkin
            $table->timestamp('waktu_checkin')->useCurrent();

            // Lokasi spatial (latitude, longitude)
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);

             $table->string('ip', 45);
             
            // Bukti foto (opsional)
            $table->string('foto_bukti')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checkin_logs');
    }
};
