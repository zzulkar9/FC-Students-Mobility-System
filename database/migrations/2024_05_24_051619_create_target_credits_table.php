<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTargetCreditsTable extends Migration
{
    public function up()
    {
        Schema::create('target_credits', function (Blueprint $table) {
            $table->id();
            $table->string('intake_year');
            $table->string('intake_semester');
            $table->string('year_semester');
            $table->integer('target_credits');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('target_credits');
    }
}

