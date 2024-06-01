<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToStudyPlansTable extends Migration
{
    public function up()
    {
        Schema::table('study_plans', function (Blueprint $table) {
            $table->string('status')->default('scheduled');
        });
    }

    public function down()
    {
        Schema::table('study_plans', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
