<?php

namespace App\Http\Controllers\admin;

use App\Models\VideoMaterial;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VideoMaterialController extends BaseController
{

    /**
     * 素材列表
     * @return mixed
     */
    public function index()
    {
        $materials = VideoMaterial::select(['id', 'title', 'author', 'created_at'])->with(['author' => function($query){
            $query->select(['id', 'alias']);
        }])->paginate(15);
        return $this->success($materials);
    }

    /**
     * 素材详情
     * @param Request $request
     * @return mixed
     */
    public function info(Request $request)
    {
        $id = $request->input('id', '');
        if(!$id){
            return $this->failed('参数不正确');
        }

        $material = VideoMaterial::select(['id', 'title', 'description', 'url', 'category_id', 'author', 'created_at'])->with(['author' => function($query){
            $query->select(['id', 'alias']);
        }])->with(['tags' => function($query){
            $query->select(['id', 'name', 'video_material_id']);
        }])->with(['category' => function($query){
            $query->select(['id', 'name']);
        }])->find($id);

        return $this->success($material);
    }

    /**
     * 删除分类
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
        $material = VideoMaterial::select(['*'])->find($id);
        if($material->delete()){
            return $this->message('删除成功');
        }else{
            return $this->failed('删除失败');
        }
    }

}
