<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTargetUniversityCourseIdToStudyPlansTable extends Migration
{
    public function up()
    {
        Schema::table('study_plans', function (Blueprint $table) {
            $table->unsignedBigInteger('target_university_course_id')->nullable()->after('course_id');
            $table->foreign('target_university_course_id')->references('id')->on('target_university_courses')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('study_plans', function (Blueprint $table) {
            $table->dropForeign(['target_university_course_id']);
            $table->dropColumn('target_university_course_id');
        });
    }
}

