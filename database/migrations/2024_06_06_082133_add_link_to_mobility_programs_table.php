<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLinkToMobilityProgramsTable extends Migration
{
    public function up()
    {
        Schema::table('mobility_programs', function (Blueprint $table) {
            $table->string('link')->nullable()->after('extra_info');
        });
    }

    public function down()
    {
        Schema::table('mobility_programs', function (Blueprint $table) {
            $table->dropColumn('link');
        });
    }
}
