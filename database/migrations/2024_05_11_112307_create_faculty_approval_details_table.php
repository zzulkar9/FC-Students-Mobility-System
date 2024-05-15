<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacultyApprovalDetailsTable extends Migration
{
    public function up()
    {
        Schema::create('faculty_approval_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_form_id')->constrained()->onDelete('cascade');
            $table->string('approval')->default('pending'); // 'approved', 'disapproved', 'pending'
            $table->text('faculty_remarks')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('faculty_approval_details');
    }
}

