<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AuthenticateController extends BaseController
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username'    => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->failed($validator->errors()->toArray(), 401);
        }

        $credentials = $request->only('username', 'password');

        if (! $token = auth('user')->attempt($credentials)) {
            return $this->failed('账号或密码不正确', 401);
        }

        $user = auth('user')->user();
        if($user->status == '0'){
            return $this->failed('账号被禁用', 401);
        }
        $user->token = $token;
        return $this->success($user);

    }

    public function logout()
    {
        auth('user')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return $this->respondWithToken(auth('user')->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('user')->factory()->getTTL() * 60
        ]);
    }

}
