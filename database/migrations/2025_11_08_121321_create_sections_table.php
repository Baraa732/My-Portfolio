<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('title');
            $table->text('content')->nullable();
            $table->enum('type', ['hero', 'about', 'skills', 'projects', 'contact', 'custom']);
            $table->integer('order')->default(0);
            $table->string('background_color')->default('#140f17');
            $table->string('text_color')->default('#ffffff');
            $table->boolean('is_active')->default(true);
            $table->boolean('show_in_nav')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sections');
    }
};
