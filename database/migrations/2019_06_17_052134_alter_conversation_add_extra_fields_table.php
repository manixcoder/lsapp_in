<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterConversationAddExtraFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('conversation_on_questions', function (Blueprint $table) { 
            $table->integer('expert_id')->nullable()->after('question_id');
            $table->integer('seeker_id')->nullable()->after('expert_id');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('conversation_on_questions', function (Blueprint $table) {
            $table->dropColumn('expert_id')->nullable();
            $table->dropColumn('seeker_id')->nullable();
        });  
    }
}
