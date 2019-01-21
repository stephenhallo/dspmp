<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\ArtistJob
 *
 * @property int $id
 * @property string $name 名称
 * @property int $artister_id 艺人id
 * @property int $operater_id 运营id
 * @property \Illuminate\Support\Carbon $completed_at 完成时间
 * @property string|null $place 任务地点
 * @property string|null $video_urls 通告视频
 * @property string|null $image_urls 通告图片
 * @property string|null $content 活动内容
 * @property int $type 类型，0视频拍摄，1商业活动
 * @property int $status 是否完成，0待完成1待审核，2已审核，3已取消
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArtistJob newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArtistJob newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ArtistJob onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArtistJob query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArtistJob whereArtisterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArtistJob whereCompletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArtistJob whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArtistJob whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArtistJob whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArtistJob whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArtistJob whereImageUrls($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArtistJob whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArtistJob whereOperaterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArtistJob wherePlace($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArtistJob whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArtistJob whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArtistJob whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArtistJob whereVideoUrls($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ArtistJob withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ArtistJob withoutTrashed()
 * @mixin \Eloquent
 * @property-read \App\Models\Member $artister
 * @property-read \App\Models\ArtistJobRecord $lastrecord
 * @property-read \App\Models\Member $operater
 * @property-read \App\Models\ArtistJobRecord $record
 */
class ArtistJob extends Model
{

    use SoftDeletes;

    protected $dates = ['deleted_at', 'completed_at'];

    public function artister()
    {
        return $this->hasOne('App\Models\Member', 'id', 'artister_id');
    }

    public function operater()
    {
        return $this->hasOne('App\Models\Member', 'id', 'operater_id');
    }

    public function record()
    {
        return $this->hasOne('App\Models\ArtistJobRecord', 'artist_job_id', 'id');
    }

}
