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
    Schema::create('movie_items', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('tmdb_id')->unique(); // TMDB এর অরিজিনাল মুভি আইডি
        $table->string('title');
        $table->text('download_link_1080p')->nullable(); // আপনার কাস্টম ১০৮০পি লিংক
        $table->text('download_link_720p')->nullable();  // আপনার কাস্টম ৭২০পি লিংক
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movie_items');
    }
};
