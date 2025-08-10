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
        Schema::create('transalations', function (Blueprint $table) {
            $table->id();
            $table->string('key', 191);
            $table->char('locale', 8)->index();
            $table->text('content');
            $table->string('context')->nullable()->index();
            $table->unique(['key', 'locale']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transalations');
    }
};
