<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReviewedByToStudyPlansTable extends Migration
{
    public function up()
    {
        Schema::table('study_plans', function (Blueprint $table) {
            $table->unsignedBigInteger('reviewed_by')->nullable()->after('year_semester');

            // Add foreign key constraint
            $table->foreign('reviewed_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('study_plans', function (Blueprint $table) {
            $table->dropForeign(['reviewed_by']);
            $table->dropColumn('reviewed_by');
        });
    }
}
