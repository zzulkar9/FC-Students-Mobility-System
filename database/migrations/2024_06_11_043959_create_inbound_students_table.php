<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInboundStudentsTable extends Migration
{
    public function up()
    {
        Schema::create('inbound_students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('country');
            $table->enum('semester', ['March/April', 'September']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('inbound_students');
    }
}

