<?php

namespace App\Http\Controllers\admin;

use App\Models\VideoCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class VideoCategoryController extends BaseController
{
    /**
     * 分类列表
     * @return mixed
     */
    public function index()
    {
        $categories = VideoCategory::select(['id', 'name', 'description'])->paginate(15);
        return $this->success($categories);
    }

    /**
     * 添加分类
     * @param Request $request
     * @return mixed
     */
    public function add(Request $request)
    {
        $name = $request->input('name', '');
        if(!$name){
            return $this->failed('分类名称不能为空');
        }
        $description = $request->input('description', '');

        $videoCategory = new VideoCategory();
        $videoCategory->name = $name;
        $videoCategory->description = $description;
        if($videoCategory->save()){
            return $this->message('添加成功');
        }else{
            return $this->failed('添加失败');
        }
    }

    /**
     * 分类详情
     * @param Request $request
     * @return mixed
     */
    public function info(Request $request)
    {
        $id = $request->input('id', '');
        if(!$id){
            return $this->failed('参数不正确');
        }
        $category = VideoCategory::select(['id', 'name', 'description'])->find($id);

        return $this->success($category);
    }

    /**
     * 编辑分类
     * @param Request $request
     * @return mixed
     */
    public function edit(Request $request)
    {
        $id = $request->input('id', '');
        if(!$id){
            return $this->failed('参数不正确');
        }
        $category = VideoCategory::select(['id', 'name', 'description'])->find($id);

        $category->name = $request->input('name', '');
        $category->description = $request->input('description', '');
        if($category->save()){
            return $this->message('编辑成功');
        }else{
            return $this->failed('编辑失败');
        }
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
        $category = VideoCategory::select(['id', 'name', 'description'])->find($id);
        if($category->delete()){
            return $this->message('删除成功');
        }else{
            return $this->failed('删除失败');
        }
    }

}
