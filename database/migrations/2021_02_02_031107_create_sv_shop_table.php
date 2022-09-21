<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSvShopTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sv_shop', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->text('description')->nullable();
            $table->string('token')->unique();
            $table->string('logo')->nullable();

            $table->boolean('test_mode')->unsigned()->nullable();
            $table->string('api_login')->nullable();
            $table->string('api_password')->nullable();

            $table->string('api_login_test')->nullable();
            $table->string('api_password_test')->nullable();

            $table->string('api_token')->nullable();
            $table->string('fail_url')->nullable();
            $table->string('return_url')->nullable();

            $table->string('emails_notification')->nullable();

            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('restrict');
        });

        Schema::create('sv_shop_purchases', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('shop_id');
            $table->unsignedBigInteger('payment_id');

            $table->foreign('shop_id')
                ->references('id')
                ->on('sv_shop')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('payment_id')
                ->references('id')
                ->on('acquiring_payments')
                ->onUpdate('cascade')
                ->onDelete('restrict');

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
        Schema::dropIfExists('sv_shop');
        Schema::dropIfExists('sv_shop_purchases');
    }
}
