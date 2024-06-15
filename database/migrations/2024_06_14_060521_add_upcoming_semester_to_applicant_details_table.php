<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUpcomingSemesterToApplicantDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('applicant_details', function (Blueprint $table) {
            $table->string('upcoming_semester')->after('program_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('applicant_details', function (Blueprint $table) {
            $table->dropColumn('upcoming_semester');
        });
    }
}
