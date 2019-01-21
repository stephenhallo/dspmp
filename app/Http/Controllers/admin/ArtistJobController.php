<?php

namespace App\Http\Controllers\admin;

use App\Models\ArtistJob;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArtistJobController extends BaseController
{

    /**
     * 通告列表
     * @return mixed
     */
    public function index()
    {
        $jobs = ArtistJob::select(['id', 'name', 'artister_id', 'operater_id', 'created_at', 'status'])
            ->with(['artister' => function($query){
            $query->select(['id', 'alias']);
        }])->with(['operater' => function($query){
            $query->select(['id', 'alias']);
            }])->paginate(15);
        return $this->success($jobs);
    }

    public function info(Request $request)
    {
        $id = $request->input('id', '');
        if(!$id){
            return $this->failed('参数不正确');
        }
        $job = ArtistJob::select(['id', 'name', 'artister_id', 'operater_id', 'created_at', 'type', 'status'])
            ->with(['artister' => function($query){
                $query->select(['id', 'alias']);
            }])->with(['operater' => function($query){
                $query->select(['id', 'alias']);
            }])->with(['record' => function($query){
                $query->select(['*'])->orderBy('id', 'desc')->first();
            }])->find($id);
        return $this->success($job);
    }

    /**
     * 删除通告
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
        $job = ArtistJob::select(['*'])->find($id);
        if($job->delete()){
            return $this->message('删除成功');
        }else{
            return $this->failed('删除失败');
        }
    }

}
