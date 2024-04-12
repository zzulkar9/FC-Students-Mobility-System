<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCourseDetailsToApplicationForms extends Migration
{
    public function up()
    {
        Schema::table('application_forms', function (Blueprint $table) {
            $table->string('utm_course_code')->after('utm_course_id');
            $table->string('utm_course_name')->after('utm_course_code');
            $table->text('utm_course_description')->nullable()->after('utm_course_name');
        });
    }

    public function down()
    {
        Schema::table('application_forms', function (Blueprint $table) {
            $table->dropColumn('utm_course_code');
            $table->dropColumn('utm_course_name');
            $table->dropColumn('utm_course_description');
        });
    }
}
