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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->morphs('manipulationable');
            $table->text('document');
            $table->string('collection_name', 100)->nullable();
            $table->string('alt', 100)->nullable();
            $table->string('status', 100)->nullable();
            $table->enum('first',['1','0'])->default('1');
            $table->foreignId('parent_id')->nullable()->references('id')->on('documents')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
