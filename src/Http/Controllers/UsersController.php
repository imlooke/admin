<?php

namespace Imlooke\Admin\Http\Controllers;

use Illuminate\Routing\Controller;
use Imlooke\Admin\Auth\Models\Administrator;
use Imlooke\Admin\Http\Requests\UsersRequest;
use Imlooke\Admin\Traits\AdminApiResource;

/**
 * UsersController
 *
 * @package imlooke/admin
 * @author lwx12525 <lwx12525@qq.com>
 */
class UsersController extends Controller
{
    use AdminApiResource;

    public function index()
    {
        $response = $this->fillter(Administrator::with('roles'));

        return response()->json($response);
    }

    public function store(UsersRequest $request)
    {
        $data = $request->only([
            'username', 'name', 'avatar', 'email', 'phone',
        ]);

        if ($password = $request->input('password')) {
            $data['password'] = bcrypt($password);
        }

        $user = Administrator::create($data);
        $user->roles()->attach(
            $request->input('roles')
        );

        return response()->success('创建成功');
    }

    public function show($id)
    {
        $response = Administrator::with('roles')->findOrFail($id);

        return response()->json($response);
    }

    public function update(UsersRequest $request, $id)
    {
        $data = $request->only([
            'username', 'name', 'avatar', 'email', 'phone',
        ]);

        if ($password = $request->input('password')) {
            $data['password'] = bcrypt($password);
        }

        $user = Administrator::findOrFail($id);
        $user->update($data);
        $user->roles()->sync(
            $request->input('roles')
        );

        return response()->success('更新成功');
    }

    public function destroy($id)
    {
        $this->multiDestroy(Administrator::class, $id);

        return response()->success('删除成功');
    }
}
