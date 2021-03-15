<?php

namespace Imlooke\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Imlooke\Admin\Http\Requests\ResetRequest;
use Imlooke\Admin\Http\Requests\UserRequest;
use Imlooke\Admin\Http\Resources\UserResource;

/**
 * UserController
 *
 * @package imlooke/admin
 * @author lwx12525 <lwx12525@qq.com>
 */
class UserController extends Controller
{
    public function user(Request $request)
    {
        return response()->json(
            new UserResource($request->user())
        );
    }

    public function update(UserRequest $request)
    {
        $data = $request->only([
            'username', 'name', 'avatar', 'email', 'phone'
        ]);

        $request->user()->update($data);

        return response()->json(
            new UserResource($request->user())
        );
    }

    public function reset(ResetRequest $request)
    {
        $request->user()->update([
            'password' => bcrypt($request->input('new_password')),
        ]);

        return response()->noContent();
    }
}
