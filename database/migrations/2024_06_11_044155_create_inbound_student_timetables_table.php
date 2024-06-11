<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInboundStudentTimetablesTable extends Migration
{
    public function up()
    {
        Schema::create('inbound_student_timetables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inbound_student_id')->constrained()->onDelete('cascade');
            $table->string('course_code');
            $table->string('course_name');
            $table->string('section');
            $table->string('time_slot');
            $table->year('year');
            $table->enum('semester', ['March/April', 'September']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('inbound_student_timetables');
    }
}

