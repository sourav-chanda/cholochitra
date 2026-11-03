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
        Schema::create('movies', function (Blueprint $table) {
        $table->id();
        $table->string('tmdb_id')->unique()->nullable();
        $table->string('title');
        $table->text('overview')->nullable();
        $table->string('poster_path')->nullable();
        $table->string('backdrop_path')->nullable();
        $table->string('release_date')->nullable();
        $table->string('rating')->nullable();
        $table->text('download_link')->nullable(); 
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
