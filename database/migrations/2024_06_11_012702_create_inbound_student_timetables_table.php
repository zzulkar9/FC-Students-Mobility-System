<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInboundStudentTimetablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inbound_student_timetables', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->string('course_code');
            $table->string('course_name');
            $table->string('section');
            $table->string('time_slot');
            $table->year('year');
            $table->enum('semester', ['March/April', 'September']);
            $table->timestamps();

            // Remove the foreign key constraint for simplicity
            // $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inbound_student_timetables');
    }
}
