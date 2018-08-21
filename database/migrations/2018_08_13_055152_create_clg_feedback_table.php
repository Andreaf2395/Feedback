<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class CreateClgFeedbackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clg_feedback', function (Blueprint $table) {
            $table->increments('id');
            $table->string('clg_id');
            $table->integer('no_students');
            $table->integer('lab_incharge');
            $table->text('lab_usage');
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
        Schema::dropIfExists('clg_feedback');
    }
}
