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
        Schema::create('application_forms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('utm_course_id')->constrained('courses');
            $table->string('target_course');
            $table->text('target_course_description');
            $table->text('notes')->nullable();
            $table->boolean('is_draft')->default(false);
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Assumes each form is linked to a user
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_forms');
    }
};
