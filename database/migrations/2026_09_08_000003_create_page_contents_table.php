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
        Schema::dropIfExists('page_contents');
        Schema::create('page_contents', function (Blueprint $table) {
            $table->id();
            $table->string('page', 100); // home, about, products, contact
            $table->string('section', 100); // hero, stats, story, cta, etc.
            $table->text('title')->nullable();
            $table->text('subtitle')->nullable();
            $table->text('content')->nullable();
            $table->text('image')->nullable();
            $table->json('meta_data')->nullable(); // structured extra items (chips, badges, items)
            $table->timestamps();

            $table->unique(['page', 'section']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_contents');
    }
};
