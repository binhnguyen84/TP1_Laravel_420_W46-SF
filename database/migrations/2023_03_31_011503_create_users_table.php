<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table-> char('password',255);
            $table->char('email', 50);
            $table->char('last_name', 50);
            $table->char('first_name', 50);
            $table->unsignedBigInteger('role_id');
            $table->char('rememberToken', 100);
            $table->timestamp('created_at');
            $table->timestamp('updated_at');

            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
