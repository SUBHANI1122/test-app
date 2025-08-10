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
        Schema::create('tag_translation', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('translation_id');
            $table->unsignedBigInteger('tag_id');

            $table->primary(['translation_id', 'tag_id']);

            $table->foreign('translation_id')->references('id')->on('translations')->onDelete('cascade');
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::table('tag_translation', function (Blueprint $table) {
            $table->index('tag_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tag_translation');
    }
};
