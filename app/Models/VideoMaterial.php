<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\VideoMaterial
 *
 * @property int $id 主键
 * @property int $category_id 分类id
 * @property string $title 标题
 * @property string|null $description 描述
 * @property string|null $url 视频地址
 * @property string|null $author 作者
 * @property int $sort 排序，数值越大越前
 * @property int $display 状态，0不显示，1显示
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VideoMaterial newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VideoMaterial newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\VideoMaterial onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VideoMaterial query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VideoMaterial whereAuthor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VideoMaterial whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VideoMaterial whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VideoMaterial whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VideoMaterial whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VideoMaterial whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VideoMaterial whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VideoMaterial whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VideoMaterial whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VideoMaterial whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VideoMaterial whereUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\VideoMaterial withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\VideoMaterial withoutTrashed()
 * @mixin \Eloquent
 */
class VideoMaterial extends Model
{

    use SoftDeletes;

    protected $dates = ['deleted_at'];


    public function tags()
    {
        return $this->hasMany('App\Models\VideoTag', 'video_material_id', 'id');
    }

    public function category()
    {
        return $this->hasOne('App\Models\VideoCategory', 'id', 'category_id');
    }

    public function author()
    {
        return $this->hasOne('App\Models\Member', 'id', 'author');
    }



}
