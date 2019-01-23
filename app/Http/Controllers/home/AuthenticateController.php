<?php

namespace App\Http\Controllers\home;

use App\Models\Member;
use EasyWeChat\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

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

        if (! $token = auth('member')->attempt($credentials)) {
            return $this->failed('账号或密码不正确', 401);
        }

        $user = auth('member')->user();
        $user->token = $token;
        return $this->success($user);

    }

    public function logout()
    {
        auth('member')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return $this->respondWithToken(auth('member')->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('member')->factory()->getTTL() * 60
        ]);
    }

    public function wechatAuth(Request $request)
    {
        $code = $request->input('code');
        if(!$code){
            return $this->failed('code不能为空');
        }

        $config = [
            'app_id' => 'wx23b88e0dbea208bf',
            'secret' => '3dd8105d1536185721c699330ccd7273',

            // 下面为可选项
            // 指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
            'response_type' => 'array',

            'log' => [
                'level' => 'debug',
                'file' => __DIR__.'/wechat.log',
            ],
        ];
        $app = Factory::miniProgram($config);
        $access = $app->auth->session($request->input('code'));

        if(!$access){
            return $this->failed('微信授权失败');
        }
        $openid = $access['openid'];

        $isMember = Member::withTrashed()->where(['wx_openid' => $openid])->first();

        if($isMember->status == '0'){
            return $this->failed('该用户已被禁用，请联系管理员');
        }

        if($isMember){
            if($isMember->deleted_at != null){
                $isMember->restore();
            }
            $token = auth('member')->login($isMember);
            $user = auth('member')->user();
            $user->token = $token;
            $user->expires_in = env('JWT_TTL') * 60;
            $user->is_auth = 1;
            return $this->success($user);
        }else{
            $member = new Member();
            $member->wx_openid = $openid;
            $member->avatar = $request->input('avatarUrl');
            $member->alias = $request->input('nickName');
            $member->username = 'wx_'.md5(uniqid(microtime(true),true));
            $member->password = bcrypt('123456');
            $member->type = 3;
            if($member->save()){
                return $this->success(['is_auth' => 0, 'id' => $member->id, 'type' => $member->type]);
            }
        }


    }

    public function wechatAuthBind(Request $request)
    {
        $memberId = $request->input('id');
        $member = Member::find($memberId);
        $member->type = $request->input('type', 1);
        $member->save();

        $token = auth('member')->login($member);
        $user = auth('member')->user();
        $user->token = $token;
        $user->expires_in = env('JWT_TTL') * 60;
        $user->is_auth = 1;
        return $this->success($user);
    }

}
