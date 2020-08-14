<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailCorrectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_corrections', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('mail_transaction_id');
            $table->foreign('mail_transaction_id')->references('id')->on('mail_transactions');
            $table->unsignedBigInteger('mail_correction_type_id')->nullable();
            $table->foreign('mail_correction_type_id')->references('id')->on('mail_correction_types');
            $table->longText('note');
            $table->softDeletes();
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
        Schema::dropIfExists('mail_corrections');
    }
}
