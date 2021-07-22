<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AltQuestionTableAddPaymentStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users_question', function (Blueprint $table) {
            $table->enum('payment_status', ['1', '0'])->default(1)->after('is_active');
            $table->string('transaction_id')->nullable()->after('payment_status');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users_question', function (Blueprint $table) {
            $table->dropColumn('payment_status')->nullable();
            $table->dropColumn('transaction_id')->nullable();
        });
    }
}
