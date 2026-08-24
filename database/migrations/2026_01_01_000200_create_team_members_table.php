<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('team_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_id')->constrained()->cascadeOnDelete();
            $table->boolean('is_leader')->default(false);
            $table->string('full_name');
            $table->string('student_id');
            $table->string('email');
            $table->string('contact_number');
            $table->string('whatsapp_number');
            $table->string('institution');
            $table->timestamps();

            $table->index('email');
            $table->index('student_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('team_members');
    }
};
