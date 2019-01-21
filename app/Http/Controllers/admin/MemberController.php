<?php

namespace App\Http\Controllers\admin;

use App\Models\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MemberController extends BaseController
{

    /**
     * 用户列表
     * @return mixed
     */
    public function index()
    {
        $members = Member::select(['id', 'alias', 'type', 'status'])->paginate(15);
        return $this->success($members);
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
        $member = Member::select(['id', 'alias', 'type', 'status'])->find($id);

        return $this->success($member);
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
        $member = Member::select(['id', 'alias', 'type', 'status'])->find($id);

        $member->alias = $request->input('alias');
        $member->type = $request->input('type');
        $member->status = $request->input('status');
        if($member->save()){
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
        $member = Member::select(['id', 'alias', 'type', 'status'])->find($id);
        if($member->delete()){
            return $this->message('删除成功');
        }else{
            return $this->failed('删除失败');
        }
    }

}
