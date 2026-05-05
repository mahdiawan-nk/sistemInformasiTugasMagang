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
        Schema::table('users', function (Blueprint $table) {
                $table->string('phone_number')->nullable()->after('email');
                $table->string('asal_perguruan_tinggi')->nullable()->after('phone_number');
                $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable()->after('asal_perguruan_tinggi');
                $table->enum('status', ['Aktif', 'Tidak Aktif'])->default('Aktif')->after('jenis_kelamin');
                $table->enum('role', ['Admin', 'Mahasiswa'])->default('Mahasiswa')->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone_number', 'asal_perguruan_tinggi', 'jenis_kelamin', 'status', 'role']);
        });
    }
};
