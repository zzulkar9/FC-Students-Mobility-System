<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddApprovalStatusToApplicationFormsTable extends Migration
{
    public function up()
    {
        Schema::table('application_forms', function (Blueprint $table) {
            $table->boolean('approval_status')->default(false);
        });
    }

    public function down()
    {
        Schema::table('application_forms', function (Blueprint $table) {
            $table->dropColumn('approval_status');
        });
    }
}
