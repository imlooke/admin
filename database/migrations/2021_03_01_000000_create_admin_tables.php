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
        $tableNames = config('admin.table_names');

        if (empty($tableNames)) {
            throw new \Exception('Error: config/admin.php not loaded. Run [php artisan config:clear] and try again.');
        }

        Schema::create($tableNames['admins'], function (Blueprint $table) {
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

        Schema::create($tableNames['permissions'], function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->text('route_path')->nullable();
            $table->string('route_name')->nullable();
            $table->string('route_method')->nullable();
            $table->timestamps();
        });

        Schema::create($tableNames['roles'], function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->timestamps();
        });

        Schema::create($tableNames['menus'], function (Blueprint $table) {
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

        Schema::create($tableNames['admin_permission'], function (Blueprint $table) use ($tableNames) {
            $table->unsignedBigInteger('admin_id');
            $table->unsignedBigInteger('permission_id');
            $table->timestamps();
            $table->index(['admin_id', 'permission_id']);

            $table->foreign('admin_id')
                ->references('id')
                ->on($tableNames['admins'])
                ->onDelete('cascade');

            $table->foreign('permission_id')
                ->references('id')
                ->on($tableNames['permissions'])
                ->onDelete('cascade');

            $table->primary(['admin_id', 'permission_id']);
        });

        Schema::create($tableNames['admin_role'], function (Blueprint $table) use ($tableNames) {
            $table->unsignedBigInteger('admin_id');
            $table->unsignedBigInteger('role_id');
            $table->timestamps();
            $table->index(['admin_id', 'role_id']);

            $table->foreign('admin_id')
                ->references('id')
                ->on($tableNames['admins'])
                ->onDelete('cascade');

            $table->foreign('role_id')
                ->references('id')
                ->on($tableNames['roles'])
                ->onDelete('cascade');

            $table->primary(['admin_id', 'role_id']);
        });

        Schema::create($tableNames['role_permission'], function (Blueprint $table) use ($tableNames) {
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('permission_id');
            $table->timestamps();
            $table->index(['role_id', 'permission_id']);

            $table->foreign('role_id')
                ->references('id')
                ->on($tableNames['roles'])
                ->onDelete('cascade');

            $table->foreign('permission_id')
                ->references('id')
                ->on($tableNames['permissions'])
                ->onDelete('cascade');

            $table->primary(['role_id', 'permission_id']);
        });

        Schema::create($tableNames['role_menu'], function (Blueprint $table) use ($tableNames) {
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('menu_id');
            $table->timestamps();
            $table->index(['role_id', 'menu_id']);

            $table->foreign('role_id')
                ->references('id')
                ->on($tableNames['roles'])
                ->onDelete('cascade');

            $table->foreign('menu_id')
                ->references('id')
                ->on($tableNames['menus'])
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
        $tableNames = config('admin.table_names');

        if (empty($tableNames)) {
            throw new \Exception('Error: config/admin.php not found and defaults could not be merged. Please publish the package configuration before proceeding, or drop the tables manually.');
        }

        Schema::dropIfExists($tableNames['role_menu']);
        Schema::dropIfExists($tableNames['menus']);
        Schema::dropIfExists($tableNames['role_permission']);
        Schema::dropIfExists($tableNames['admin_role']);
        Schema::dropIfExists($tableNames['admin_permission']);
        Schema::dropIfExists($tableNames['roles']);
        Schema::dropIfExists($tableNames['permissions']);
        Schema::dropIfExists($tableNames['admins']);
    }
}
