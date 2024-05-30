<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreditCalculationsTable extends Migration
{
    public function up()
    {
        Schema::create('credit_calculations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('application_form_id');
            $table->unsignedBigInteger('application_form_subject_id');
            $table->decimal('equivalent_utm_credits', 8, 3);
            $table->timestamps();

            $table->foreign('application_form_id')->references('id')->on('application_forms')->onDelete('cascade');
            $table->foreign('application_form_subject_id')->references('id')->on('application_form_subjects')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('credit_calculations');
    }
}
