<?php

namespace App\Http\Controllers\home;

use App\Models\VideoMaterial;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VideoMaterialController extends BaseController
{

    public function list(Request $request)
    {
        $category_id = $request->input('category_id');
        $condition['display'] = 1;
        if($category_id){
            $condition['category_id'] = $category_id;
        }
        $videoMaterials = VideoMaterial::select(['id', 'title', 'description', 'url', 'video_posters', 'author', 'category_id'])
            ->with(['author' =>function($query){
            $query->select(['id', 'alias', 'avatar']);
        }])->with(['category' => function($query){
            $query->select(['id', 'name']);
        }])->with(['tags' => function($query){
            $query->select(['id', 'name', 'video_material_id']);
        }])->where($condition)->orderBy('id', 'desc')->paginate(10);
        return $this->success($videoMaterials);
    }

}
