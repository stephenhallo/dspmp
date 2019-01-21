<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\ArtistJobRecord
 *
 * @property int $id
 * @property int $artist_job_id 通告id
 * @property int $publish_id 发布者id
 * @property \Illuminate\Support\Carbon $deadline_at 截止时间
 * @property string|null $place 任务地点
 * @property string|null $video_urls 视频地址
 * @property string|null $image_urls 图片地址
 * @property string|null $content 内容
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArtistJobRecord newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArtistJobRecord newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ArtistJobRecord onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArtistJobRecord query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArtistJobRecord whereArtistJobId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArtistJobRecord whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArtistJobRecord whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArtistJobRecord whereDeadlineAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArtistJobRecord whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArtistJobRecord whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArtistJobRecord whereImageUrls($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArtistJobRecord wherePlace($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArtistJobRecord wherePublishId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArtistJobRecord whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArtistJobRecord whereVideoUrls($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ArtistJobRecord withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ArtistJobRecord withoutTrashed()
 * @mixin \Eloquent
 */
class ArtistJobRecord extends Model
{

    use SoftDeletes;

    protected $dates = ['deleted_at', 'deadline_at'];

}
