<?php

use     Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->bigIncrements('id');
            $table->integer('parent_id')->unsigned()->default(0);
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password', 60);
            $table->string('phone');
            $table->integer('country');
            $table->integer('state');
            $table->string('city');
            $table->text('address');
            $table->string('post_code');
            $table->string('logo');
            $table->enum('status', ['off', 'on'])->default('off');
            $table->integer('company_id')->unsigned()->nullable();
            $table->string('company_name')->nullable();
            $table->integer('role')->unsigned()->default(1);
            $table->text('access')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
