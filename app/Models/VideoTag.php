<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\VideoTag
 *
 * @property int $id
 * @property string $name 标签名称
 * @property int $video_material_id 视频素材id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VideoTag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VideoTag newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\VideoTag onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VideoTag query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VideoTag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VideoTag whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VideoTag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VideoTag whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VideoTag whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VideoTag whereVideoMaterialId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\VideoTag withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\VideoTag withoutTrashed()
 * @mixin \Eloquent
 */
class VideoTag extends Model
{

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $guarded = [];

}
