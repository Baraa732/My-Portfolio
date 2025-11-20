<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('skill_ecosystems', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('ecosystem', ['javascript', 'php']);
            $table->string('icon')->nullable();
            $table->integer('proficiency')->default(80);
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('ecosystem_sections', function (Blueprint $table) {
            $table->id();
            $table->enum('ecosystem', ['javascript', 'php']);
            $table->string('title');
            $table->text('description')->nullable();
            $table->boolean('is_visible')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('skill_ecosystems');
        Schema::dropIfExists('ecosystem_sections');
    }
};