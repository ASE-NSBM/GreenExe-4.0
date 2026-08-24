<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('competition_information', function (Blueprint $table) {
            $table->id();
            $table->string('section');
            $table->string('title');
            $table->text('body');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();

            $table->index(['section', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('competition_information');
    }
};
