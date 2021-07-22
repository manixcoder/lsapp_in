<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersQuestionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_question', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('seeker_id');
            $table->foreign('seeker_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedInteger('expert_id');
            $table->foreign('expert_id')->references('id')->on('users')->onDelete('cascade');
            $table->text('question_text')->nullable();
            $table->integer('question_worth')->default(0);
            $table->enum('email_optin', ['1', '0'])->default(0)->comment = '1 = email_optin is active / 0 = email_optin is block';
            $table->enum('is_active', ['1', '2','3','4','5'])->default(1)->comment = '1 = question is active / 2 = question is Answered / 3 = question is Declined / 4= question is Expired / 5= question is accept';
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
        Schema::dropIfExists('users_question');
    }
}
