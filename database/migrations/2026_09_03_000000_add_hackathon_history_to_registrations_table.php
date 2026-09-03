<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->boolean('has_previous_hackathon_experience')->default(false);
            $table->text('previous_hackathon_details')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->dropColumn([
                'has_previous_hackathon_experience',
                'previous_hackathon_details',
            ]);
        });
    }
};
