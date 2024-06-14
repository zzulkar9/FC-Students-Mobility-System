<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTimetablesCourseIdToInboundStudentTimetable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inbound_student_timetables', function (Blueprint $table) {
            $table->unsignedBigInteger('timetables_course_id')->nullable();

            $table->foreign('timetables_course_id')->references('id')->on('timetables')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inbound_student_timetables', function (Blueprint $table) {
            $table->dropForeign(['timetables_course_id']);
            $table->dropColumn('timetables_course_id');
        });
    }
}

