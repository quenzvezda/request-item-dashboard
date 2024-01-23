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
        Schema::table('item_requests', function (Blueprint $table) {
            $table->dropColumn('status'); // Menghapus kolom status
        });

        Schema::table('items', function (Blueprint $table) {
            $table->string('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn('status'); // Menghapus kolom status dari items
        });

        Schema::table('item_requests', function (Blueprint $table) {
            $table->string('status'); // Menambahkan kolom status kembali ke item_requests
        });
    }
};
