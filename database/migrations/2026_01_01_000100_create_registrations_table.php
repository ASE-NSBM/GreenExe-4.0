<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->string('registration_code')->unique();
            $table->string('team_name');
            $table->unsignedTinyInteger('member_count');
            $table->string('project_title');
            $table->string('project_category')->nullable();
            $table->text('project_description');
            $table->text('problem_statement');
            $table->text('proposed_solution');
            $table->text('technology_used');
            $table->text('innovation_description');
            $table->text('expected_impact');
            $table->string('status')->default('pending');
            $table->timestamps();

            $table->index('status');
            $table->index('project_category');
            $table->index('team_name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
