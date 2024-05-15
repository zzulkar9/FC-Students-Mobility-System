<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvisorAndApprovalDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advisor_and_approval_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_form_id')->constrained()->onDelete('cascade');
            $table->string('advisor_name')->nullable();
            $table->string('advisor_email')->nullable();
            $table->string('advisor_phone')->nullable();
            $table->text('advisor_remarks')->nullable();
            $table->enum('approval', ['approved', 'disapproved', 'pending'])->default('pending');
            $table->text('faculty_remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('advisor_and_approval_details');
    }
}
