<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpertRatingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expert_rating', function (Blueprint $table) {
            $table->increments('id');            
            $table->unsignedInteger('seeker_id');
            $table->foreign('seeker_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedInteger('expert_id');
            $table->foreign('expert_id')->references('id')->on('users')->onDelete('cascade');
            $table->text('feed_back')->nullable();
            $table->integer('rating');
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
        Schema::dropIfExists('expert_rating');
    }
}
