<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNotificationfiledsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) { 
           
            $table->enum('is_newQuestionArrivedNotification', ['1', '0'])->default(1)->after('is_marketing_messages')->comment = '1 = newQuestionArrivedNotification is active / 0 = newQuestionArrivedNotification set false';
            $table->enum('is_reply_to_your_answer', ['1', '0'])->default(1)->after('is_newQuestionArrivedNotification')->comment = '1 = reply_to_your_answer is active / 0 = reply_to_your_answer set false';
            $table->enum('is_expert_response_to_question', ['1', '0'])->default(1)->after('is_reply_to_your_answer')->comment = '1 = expert_response_to_question is active / 0 = expert_response_to_question set false';
            $table->enum('is_accept_new_questions', ['No', 'Yes'])->default('No')->after('is_expert_response_to_question');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_newQuestionArrivedNotification')->nullable();
            $table->dropColumn('is_reply_to_your_answer')->nullable();
            $table->dropColumn('is_expert_response_to_question')->nullable();
        });
    }
}
