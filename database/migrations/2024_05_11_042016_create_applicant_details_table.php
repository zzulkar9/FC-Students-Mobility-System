<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicantDetailsTable extends Migration
{
    public function up()
    {
        Schema::create('applicant_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('application_form_id');
            $table->string('program_type')->nullable();
            $table->string('religion')->nullable();
            $table->string('citizenship')->nullable();
            $table->string('ic_passport_number')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('race')->nullable();
            $table->text('home_address')->nullable();
            $table->string('next_of_kin')->nullable();
            $table->string('emergency_contact')->nullable();
            $table->string('parents_occupation')->nullable();
            $table->string('parents_monthly_income')->nullable();
            $table->timestamps();

            $table->foreign('application_form_id')->references('id')->on('application_forms')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('applicant_details');
    }
}
