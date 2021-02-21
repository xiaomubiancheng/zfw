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
            $table->bigIncrements('id');
            $table->string('username',20)->comment('账号');
            $table->string('truename',50)->default('未知')->comment('真名');
            $table->string('password',255)->comment('密码');
            $table->string('email',50)->nullable()->comment('邮箱');
            $table->string('phone',15)->default('')->comment('手机号码');
            $table->enum('sex',['先生','女士'])->default('先生')->comment('性别');
            $table->char('last_ip',15)->default('')->comment('登录IP');
            $table->timestamps();
            //软删除 生产一字段 deleted_at 字段
            $table->softDeletes();
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
