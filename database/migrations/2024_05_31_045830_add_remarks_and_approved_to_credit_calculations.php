<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRemarksAndApprovedToCreditCalculations extends Migration
{
    public function up()
    {
        Schema::table('credit_calculations', function (Blueprint $table) {
            $table->text('remarks')->nullable();
            $table->boolean('approved')->default(false);
        });
    }

    public function down()
    {
        Schema::table('credit_calculations', function (Blueprint $table) {
            $table->dropColumn('remarks');
            $table->dropColumn('approved');
        });
    }
}

