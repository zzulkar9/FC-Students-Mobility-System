<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('application_forms', function (Blueprint $table) {
            $table->string('intake_period')->after('user_id'); // Adds the intake_period column after the user_id column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('application_forms', function (Blueprint $table) {
            $table->dropColumn('intake_period');
        });
    }
};
