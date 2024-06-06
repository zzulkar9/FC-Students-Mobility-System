<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTargetUniversityCoursesTable extends Migration
{
    public function up()
    {
        Schema::create('target_university_courses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('application_form_subject_id');
            $table->unsignedBigInteger('user_id');
            $table->string('course_code');
            $table->string('course_name');
            $table->decimal('course_credit', 5, 2);
            $table->timestamps();

            $table->foreign('application_form_subject_id')->references('id')->on('application_form_subjects')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('target_university_courses');
    }
}

