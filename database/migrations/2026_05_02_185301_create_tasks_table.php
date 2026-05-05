<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();

            // Informasi task dari pembimbing
            $table->string('title');
            $table->text('description');
            $table->integer('point')->default(0);

            // Deadline dari pembimbing (max 7 hari setelah dibuat)
            $table->date('deadline_post');

            // Deadline setelah diambil mahasiswa (7 hari setelah claim)
            $table->date('deadline_taken')->nullable();

            // Relasi
            $table->unsignedBigInteger('user_id')->nullable(); // mahasiswa yang ambil task

            // File hasil upload mahasiswa
            $table->string('submission_file')->nullable();
            // Tanggal upload hasil mahasiswa
            $table->date('submission_date')->nullable();
            // Point hasil evaluasi pembimbing
            $table->integer('final_point')->nullable();

            // Catatan evaluasi
            $table->text('evaluation_notes')->nullable();

            // Status lifecycle task
            $table->enum('status', [
                'available',     // task tersedia (belum diambil)
                'in_progress',   // sudah diambil mahasiswa
                'submitted',     // sudah upload hasil
                'done'           // sudah di-approve pembimbing
            ])->default('available');

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
