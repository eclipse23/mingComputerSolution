<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReplyInquiresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reply_inquires', function (Blueprint $table) {
            $table->id();
            $table->string('message');
            $table->unsignedBigInteger('inquire_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('inquire_id')->references('id')->on('inquires')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reply_inquires');
    }
}
