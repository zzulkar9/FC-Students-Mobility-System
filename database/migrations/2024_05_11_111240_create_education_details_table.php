<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEducationDetailsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('education_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('application_form_id'); // Ensure the data type matches the primary key in application_forms
            $table->string('faculty');
            $table->string('current_semester');
            $table->string('field_of_study');
            $table->date('expected_graduation')->nullable();
            $table->string('program');
            $table->decimal('cgpa', 3, 2)->nullable();
            $table->text('co_curriculum')->nullable();
            $table->text('achievements')->nullable();
            $table->text('special_skills')->nullable();
            $table->timestamps();

            // Setting up the foreign key relation
            $table->foreign('application_form_id')->references('id')->on('application_forms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('education_details');
    }
}

