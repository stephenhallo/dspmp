<?php

namespace App\Http\Controllers\admin;

use App\Http\Requests\admin\UserAddRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends BaseController
{
    /**
     * 用户列表
     * @return mixed
     */
    public function index()
    {
        $users = User::select(['id', 'username', 'alias', 'status', 'created_at'])->paginate(15);
        return $this->success($users);
    }

    /**
     * 添加用户
     * @param Request $request
     * @return mixed
     */
    public function add(UserAddRequest $request)
    {
        $user = new User();
        $user->username = $request->input('username');
        $user->password = bcrypt($request->input('password'));
        $user->alias = $request->input('alias');
        $user->status = $request->input('status');

        if($user->save()){
            return $this->message('添加成功');
        }else{
            return $this->failed('添加失败');
        }
    }

    /**
     * 用户详情
     * @param Request $request
     * @return mixed
     */
    public function info(Request $request)
    {
        $id = $request->input('id', '');
        if(!$id){
            return $this->failed('参数不正确');
        }
        $user = User::select(['id', 'username', 'alias', 'status'])->find($id);

        return $this->success($user);
    }

    /**
     * 编辑用户
     * @param Request $request
     * @return mixed
     */
    public function edit(Request $request)
    {
        $id = $request->input('id', '');
        if(!$id){
            return $this->failed('参数不正确');
        }
        $user = User::select(['id', 'username', 'alias', 'status'])->find($id);

        $user->alias = $request->input('alias');
        $user->status = $request->input('status');
        if($request->input('password')){
            $user->password = bcrypt($request->password);
        }
        if($user->save()){
            return $this->message('编辑成功');
        }else{
            return $this->failed('编辑失败');
        }
    }

    /**
     * 删除用户
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function delete(Request $request)
    {
        $id = $request->input('id', '');
        if(!$id){
            return $this->failed('参数不正确');
        }
        $user = User::select(['*'])->find($id);
        if($user->delete()){
            return $this->message('删除成功');
        }else{
            return $this->failed('删除失败');
        }
    }
}
