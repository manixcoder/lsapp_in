<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserNewFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('first_name')->nullable()->after('password');
            $table->string('last_name')->nullable()->after('first_name');
            $table->text('profile_bio')->nullable()->after('last_name');
            $table->text('website_url')->nullable()->after('profile_bio');
            $table->enum('is_active', ['1', '0'])->default(1)->after('website_url')->comment = '1 = user is active / 0 = user is block';
            $table->enum('is_marketing_messages', ['1', '0'])->default(0)->after('is_active')->comment = '1 = marketMessage is active / 0 = marketMessage set false';
            $table->text('profile_photo')->nullable()->after('is_marketing_messages'); 
            $table->enum('payment_options',['price_Range', 'single_price','free'])->default('price_Range')->after('profile_photo'); 
            $table->enum('price_range',['option1', 'option2', 'option3', 'option4'])->default('option1')->after('payment_options'); 
            $table->text('lower_price')->nullable()->after('price_range'); 
            $table->text('medium_price')->nullable()->after('lower_price'); 
            $table->text('higher_price')->nullable()->after('medium_price');
            $table->integer('single_price')->default(0)->after('higher_price');
            $table->string('stripe_user_id')->nullable()->after('single_price');
            $table->string('stripe_token')->nullable()->after('stripe_user_id');
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
            $table->dropColumn('first_name')->nullable();
            $table->dropColumn('last_name')->nullable();
            $table->dropColumn('profile_bio')->nullable();
            $table->dropColumn('website_url')->nullable();
            $table->dropColumn('is_active')->nullable();
            $table->dropColumn('is_marketing_messages')->nullable();
            $table->dropColumn('profile_photo')->nullable();
            $table->dropColumn('payment_options')->nullable();
            $table->dropColumn('price_range')->nullable();
            $table->dropColumn('lower_price')->nullable();
            $table->dropColumn('higher_price')->nullable();
            $table->dropColumn('single_price')->nullable();
            $table->dropColumn('stripe_user_id')->nullable();
            $table->dropColumn('stripe_token')->nullable();
        });
    }
}
