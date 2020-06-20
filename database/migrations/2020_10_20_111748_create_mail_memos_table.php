<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailMemosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_memos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('mail_transaction_id');
            $table->foreign('mail_transaction_id')->references('id')->on('mail_transactions');
            $table->longText('memo');
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
        Schema::dropIfExists('mail_memos');
    }
}
