<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('application_form_subjects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_form_id')->constrained('application_forms')->onDelete('cascade');
            $table->foreignId('utm_course_id')->constrained('courses');
            $table->string('utm_course_code');
            $table->string('utm_course_name');
            $table->text('utm_course_description')->nullable();
            $table->string('target_course')->nullable();
            $table->text('target_course_description')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('application_form_subjects');
    }
};
