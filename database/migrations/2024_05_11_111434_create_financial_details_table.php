<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinancialDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('financial_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_form_id')->constrained()->onDelete('cascade');
            $table->string('finance_method')->nullable(); // How the program will be financed
            $table->string('sponsorship_details')->nullable(); // Details about sponsorship
            $table->text('budget_details')->nullable(); // Detailed text about expected expenses

            $table->timestamps();
        });
    }

    /**
     * Rollback the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('financial_details');
    }
}

