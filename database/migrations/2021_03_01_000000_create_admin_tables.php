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
        $database = config('admin.database');

        if (empty($database)) {
            throw new \Exception('Error: config/admin.php not loaded. Run [php artisan config:clear] and try again.');
        }

        Schema::create($database['users_table'], function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('username')->unique();
            $table->string('avatar')->nullable();
            $table->string('email', 64)->nullable();
            $table->string('phone', 32)->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->string('last_login_ip', 32)->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->timestamp('recently_login_at')->nullable();
            $table->bigInteger('login_times')->default(0);
            $table->tinyInteger('status')->default(1)->comment('用户状态 1:正常,0:禁用');
            $table->timestamps();
        });

        Schema::create($database['roles_table'], function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->timestamps();
        });

        Schema::create($database['permissions_table'], function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->text('route_path')->nullable();
            $table->string('route_name')->nullable();
            $table->string('route_method')->nullable();
            $table->timestamps();
        });

        Schema::create($database['menus_table'], function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('parent_id')->default(0);
            $table->string('path')->default('0');
            $table->tinyInteger('type')->default(1)->comment('菜单类型 1:本站链接,2:第三方链接');
            $table->tinyInteger('is_protected')->default(0)->comment('保护状态 1:受保护不可删除,0:可删除');
            $table->tinyInteger('status')->default(0)->comment('显示状态 1:显示,0:不显示');
            $table->smallInteger('order')->default(50);
            $table->string('name', 64);
            $table->text('route_path');
            $table->string('route_name')->nullable();
            $table->string('icon', 64)->nullable();
            $table->string('description')->nullable();
            $table->string('app_group', 64)->comment('应用分组');
            $table->timestamps();
        });

        Schema::create($database['user_role_table'], function (Blueprint $table) use ($database) {
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('role_id');
            $table->timestamps();
            $table->index(['user_id', 'role_id']);

            $table->foreign('user_id')
                ->references('id')
                ->on($database['users_table'])
                ->onDelete('cascade');

            $table->foreign('role_id')
                ->references('id')
                ->on($database['roles_table'])
                ->onDelete('cascade');

            $table->primary(['user_id', 'role_id']);
        });

        Schema::create($database['user_permission_table'], function (Blueprint $table) use ($database) {
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('permission_id');
            $table->timestamps();
            $table->index(['user_id', 'permission_id']);

            $table->foreign('user_id')
                ->references('id')
                ->on($database['users_table'])
                ->onDelete('cascade');

            $table->foreign('permission_id')
                ->references('id')
                ->on($database['permissions_table'])
                ->onDelete('cascade');

            $table->primary(['user_id', 'permission_id']);
        });

        Schema::create($database['role_permission_table'], function (Blueprint $table) use ($database) {
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('permission_id');
            $table->timestamps();
            $table->index(['role_id', 'permission_id']);

            $table->foreign('role_id')
                ->references('id')
                ->on($database['roles_table'])
                ->onDelete('cascade');

            $table->foreign('permission_id')
                ->references('id')
                ->on($database['permissions_table'])
                ->onDelete('cascade');

            $table->primary(['role_id', 'permission_id']);
        });

        Schema::create($database['role_menu_table'], function (Blueprint $table) use ($database) {
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('menu_id');
            $table->timestamps();
            $table->index(['role_id', 'menu_id']);

            $table->foreign('role_id')
                ->references('id')
                ->on($database['roles_table'])
                ->onDelete('cascade');

            $table->foreign('menu_id')
                ->references('id')
                ->on($database['menus_table'])
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
        $database = config('admin.database.table_names');

        if (empty($database)) {
            throw new \Exception('Error: config/admin.php not found and defaults could not be merged. Please publish the package configuration before proceeding, or drop the tables manually.');
        }

        Schema::dropIfExists($database['role_menu_table']);
        Schema::dropIfExists($database['menus_table']);
        Schema::dropIfExists($database['role_permission_table']);
        Schema::dropIfExists($database['user_permission_table']);
        Schema::dropIfExists($database['user_role_table']);
        Schema::dropIfExists($database['permissions_table']);
        Schema::dropIfExists($database['roles_table']);
        Schema::dropIfExists($database['users_table']);
    }
}
