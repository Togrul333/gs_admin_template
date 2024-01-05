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
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->integer('order')->unsigned()->nullable();
            $table->unsignedBigInteger('wp_id')->unique()->nullable();
            $table->string('news_type')->nullable();
            $table->string('video_url')->nullable();
            $table->enum('status',['1','0'])->default('1');
            $table->enum('for_free',['1','0'])->default('0');
            $table->enum('confirmed',['1','0'])->default('0');
            $table->dateTime('action_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
