<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('admin.database.users_table'), function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('username')->unique();
            $table->string('name')->nullable();
            $table->string('avatar')->nullable();
            $table->string('email', 64)->nullable();
            $table->string('phone', 32)->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->tinyInteger('status')->default(1)->comment('用户状态 1:正常,0:禁用');
            $table->timestamps();
        });

        Schema::create(config('admin.database.roles_table'), function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->timestamps();
        });

        Schema::create(config('admin.database.permissions_table'), function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->text('route_path')->nullable();
            $table->string('route_method')->nullable();
            $table->timestamps();
        });

        Schema::create(config('admin.database.menus_table'), function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('parent_id')->default(0);
            $table->string('path')->default('0');
            $table->tinyInteger('type')->default(1)->comment('菜单类型 1:本站链接,2:第三方链接');
            $table->smallInteger('order')->default(50);
            $table->string('name', 64);
            $table->text('route_path');
            $table->string('icon', 64)->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        Schema::create(config('admin.database.user_role_table'), function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('role_id');
            $table->index(['user_id', 'role_id']);

            $table->foreign('user_id')
                ->references('id')
                ->on(config('admin.database.users_table'))
                ->onDelete('cascade');

            $table->foreign('role_id')
                ->references('id')
                ->on(config('admin.database.roles_table'))
                ->onDelete('cascade');

            $table->primary(['user_id', 'role_id']);
        });

        Schema::create(config('admin.database.user_permission_table'), function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('permission_id');
            $table->index(['user_id', 'permission_id']);

            $table->foreign('user_id')
                ->references('id')
                ->on(config('admin.database.users_table'))
                ->onDelete('cascade');

            $table->foreign('permission_id')
                ->references('id')
                ->on(config('admin.database.permissions_table'))
                ->onDelete('cascade');

            $table->primary(['user_id', 'permission_id']);
        });

        Schema::create(config('admin.database.role_permission_table'), function (Blueprint $table) {
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('permission_id');
            $table->index(['role_id', 'permission_id']);

            $table->foreign('role_id')
                ->references('id')
                ->on(config('admin.database.roles_table'))
                ->onDelete('cascade');

            $table->foreign('permission_id')
                ->references('id')
                ->on(config('admin.database.permissions_table'))
                ->onDelete('cascade');

            $table->primary(['role_id', 'permission_id']);
        });

        Schema::create(config('admin.database.role_menu_table'), function (Blueprint $table) {
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('menu_id');
            $table->index(['role_id', 'menu_id']);

            $table->foreign('role_id')
                ->references('id')
                ->on(config('admin.database.roles_table'))
                ->onDelete('cascade');

            $table->foreign('menu_id')
                ->references('id')
                ->on(config('admin.database.menus_table'))
                ->onDelete('cascade');

            $table->primary(['role_id', 'menu_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(config('admin.database.role_menu_table'));
        Schema::dropIfExists(config('admin.database.role_permission_table'));
        Schema::dropIfExists(config('admin.database.user_permission_table'));
        Schema::dropIfExists(config('admin.database.user_role_table'));
        Schema::dropIfExists(config('admin.database.menus_table'));
        Schema::dropIfExists(config('admin.database.permissions_table'));
        Schema::dropIfExists(config('admin.database.roles_table'));
        Schema::dropIfExists(config('admin.database.users_table'));
    }
}
