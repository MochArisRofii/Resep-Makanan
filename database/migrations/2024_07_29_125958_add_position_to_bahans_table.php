<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     */
    public function up(): void
    {
        Schema::table('bahans', function (Blueprint $table) {
            // Menambahkan kolom 'position' dengan tipe data integer,
            // dapat bernilai null, dan ditempatkan setelah kolom 'id'
            $table->integer('position')->nullable()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bahans', function (Blueprint $table) {
            $table->dropColumn('position');
        });
    }
};
