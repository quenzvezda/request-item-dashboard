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
        Schema::create('item_request_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_request_id')->constrained('item_requests');
            $table->foreignId('item_id')->constrained('items');
            $table->integer('kuantitas');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_request_details');
    }
};
