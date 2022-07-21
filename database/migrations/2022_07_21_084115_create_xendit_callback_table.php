<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateXenditCallbackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('xendit_callback', function (Blueprint $table) {
            $table->id();
            $table->string('callback_id');
            $table->string('external_id');
            $table->string('user_id');
            $table->string('is_high');
            $table->string('payment_method');
            $table->string('status');
            $table->string('merchant_name');
            $table->string('amount');
            $table->string('paid_amount');
            $table->string('bank_code');
            $table->string('paid_at');

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
        Schema::dropIfExists('xendit_callback');
    }
}
