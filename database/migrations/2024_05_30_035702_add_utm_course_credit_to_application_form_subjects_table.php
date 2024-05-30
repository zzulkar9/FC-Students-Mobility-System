<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUtmCourseCreditToApplicationFormSubjectsTable extends Migration
{
    public function up()
    {
        Schema::table('application_form_subjects', function (Blueprint $table) {
            $table->decimal('utm_course_credit', 5, 2)->nullable()->after('utm_course_name');
        });
    }

    public function down()
    {
        Schema::table('application_form_subjects', function (Blueprint $table) {
            $table->dropColumn('utm_course_credit');
        });
    }
}
