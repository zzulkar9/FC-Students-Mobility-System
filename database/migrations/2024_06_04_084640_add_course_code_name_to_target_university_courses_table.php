<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCourseCodeNameToTargetUniversityCoursesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('target_university_courses', function (Blueprint $table) {
            $table->string('course_code_name')->after('course_credit');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('target_university_courses', function (Blueprint $table) {
            $table->dropColumn('course_code_name');
        });
    }
}
