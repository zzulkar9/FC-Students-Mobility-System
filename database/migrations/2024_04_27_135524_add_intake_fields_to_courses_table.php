<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::table('courses', function (Blueprint $table) {
            $table->string('intake_year')->after('description');
            $table->string('intake_semester')->after('intake_year');
        });
    }

    public function down() {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn(['intake_year', 'intake_semester']);
        });
    }
};