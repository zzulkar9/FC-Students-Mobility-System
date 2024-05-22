<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('study_plans', function (Blueprint $table) {
            $table->text('remark')->nullable()->after('year_semester');
        });
    }

    public function down()
    {
        Schema::table('study_plans', function (Blueprint $table) {
            $table->dropColumn('remark');
        });
    }
};
