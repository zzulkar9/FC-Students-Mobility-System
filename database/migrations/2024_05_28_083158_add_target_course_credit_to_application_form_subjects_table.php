<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTargetCourseCreditToApplicationFormSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('application_form_subjects', function (Blueprint $table) {
            $table->string('target_course_credit')->nullable()->after('target_course');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('application_form_subjects', function (Blueprint $table) {
            $table->dropColumn('target_course_credit');
        });
    }
}

