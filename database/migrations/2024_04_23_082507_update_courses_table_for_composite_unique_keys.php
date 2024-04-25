<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('courses', function (Blueprint $table) {
            // Drop existing unique index on 'course_code' if exists
            $table->dropUnique(['course_code']);

            // Add new composite unique index
            $table->unique(['course_code', 'intake_year', 'intake_semester'], 'course_intake_unique');
        });
    }

    public function down()
    {
        Schema::table('courses', function (Blueprint $table) {
            // Drop the composite unique index
            $table->dropUnique('course_intake_unique');

            // Re-add the original unique index if it was originally there
            $table->unique('course_code');
        });
    }
};
