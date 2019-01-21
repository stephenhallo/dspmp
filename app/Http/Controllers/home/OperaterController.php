<?php

namespace App\Http\Controllers\home;

use App\Helpers\NoticeService;
use App\Http\Requests\home\ArtistJobPublishRequest;
use App\Http\Requests\home\VideoMaterialPublishRequest;
use App\Models\ArtistJob;
use App\Models\ArtistJobRecord;
use App\Models\Member;
use App\Models\VideoMaterial;
use App\Models\VideoTag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class OperaterController extends BaseController
{
    protected $noticeService;

    public function __construct(NoticeService $noticeService)
    {
        $this->noticeService = $noticeService;
    }

    /**
     * 发布素材
     * @param VideoMaterialPublishRequest $request
     * @return mixed
     */
    public function publishVideoMaterial(VideoMaterialPublishRequest $request)
    {

        $videoMaterial = new VideoMaterial();
        $videoMaterial->title = $request->input('title');
        $videoMaterial->category_id = $request->input('category_id');
        $videoMaterial->description = $request->input('description');
        $videoMaterial->url = $request->input('url');
        $videoMaterial->video_posters = $request->input('video_posters');
        $videoMaterial->author = auth('member')->id();
        if($videoMaterial->save()){
            $tags = $request->input('tags');
            $tagsArrs = explode(',', $tags);
            $videoTags = [];
            foreach($tagsArrs as $key => $tag){
                $videoTags[] = [
                    'name' => $tag,
                    'video_material_id' => $videoMaterial->id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            }
            $videoTag = DB::table('video_tags')->insert($videoTags);
            return $videoTag ? $this->message('发布素材成功') : $this->failed('发布素材失败');
        }else{
            return $this->failed('发布素材失败');
        }
    }


    /**
     * 所有艺人
     * @return mixed
     */
    public function getArtisters()
    {
        $artisters = Member::select(['id', 'alias'])->where(['type' => 1])->orderBy('id', 'desc')->get();
        return $this->success($artisters);
    }

    /**
     * 发布通告
     * @param ArtistJobPublishRequest $request
     * @return mixed
     */
    public function publishJob(ArtistJobPublishRequest $request)
    {
        $artistJob = new ArtistJob();
        $artistJob->name = $request->input('name');
        $artistJob->artister_id = $request->input('artister_id');
        $artistJob->operater_id = auth('member')->id();
        $artistJob->completed_at = $request->input('completed_at');
        $artistJob->place = $request->input('place');
        $artistJob->video_urls = $request->input('video_urls');
        $artistJob->image_urls = $request->input('image_urls');
        $artistJob->content = $request->input('content');
        $artistJob->type = $request->input('type');
        if($artistJob->save()){
            $jobRecord = new ArtistJobRecord();
            $jobRecord->name = $artistJob->name;
            $jobRecord->artist_job_id = $artistJob->id;
            $jobRecord->publish_id = auth('member')->id();
            $jobRecord->deadline_at = $request->input('completed_at');
            $jobRecord->place = $request->input('place');
            $jobRecord->video_urls = $request->input('video_urls');
            $jobRecord->image_urls = $request->input('image_urls');
            $jobRecord->content = $request->input('content');
            if($jobRecord->save()){
                $this->noticeService->jobSend($artistJob->operater_id, $artistJob->artister_id, $artistJob->id, '你有一条新的通告');
                return $this->message('发布通告成功');
            }else{
                return $this->failed('发布通告失败');
            }
        }else{
            return $this->failed('发布通告失败');
        }
    }

    /**
     * 未完成通告
     * @return mixed
     */
    public function unfinishedJobs()
    {
        $unfinishedJobs = ArtistJob::select(['id', 'name', 'artister_id', 'completed_at', 'type'])->with(['artister' => function($query){
            $query->select(['id', 'alias', 'avatar']);
        }])->where(['status' => 0, 'operater_id' => auth('member')->id()])->orderBy('id', 'desc')->paginate(10);
        return $this->success($unfinishedJobs);
    }

    /**
     * 通告详情
     * @param Request $request
     * @return mixed
     */
    public function jobDetail(Request $request)
    {
        if(!$jobId = $request->input('id')){
            return $this->failed('参数不正确');
        }
        $job = ArtistJob::select(['*'])
            ->with(['artister' => function($query){
            $query->select(['id', 'alias', 'avatar']);
        }])->with(['record' => function($query){
                $query->select(['id', 'artist_job_id', 'video_urls', 'image_urls'])->orderBy('id', 'desc');
            }])->find($request->input('id'));
        return $this->success($job);
    }

    /**
     * 取消通告
     * @param Request $request
     * @return mixed
     */
    public function jobCancle(Request $request)
    {
        if(!$jobId = $request->input('id')){
            return $this->failed('参数不正确');
        }
        $job = ArtistJob::find($request->input('id'));
        $job->status = 4;
        if($job->save()){
            $this->noticeService->jobSend($job->operater_id, $job->artister_id, $job->id, '取消了一条通告');
            return $this->message('取消通告成功');
        }else{
            return $this->failed('取消通告失败');
        }
    }

    /**
     * 审核/待审核
     * @param Request $request
     * @return mixed
     */
    public function jobReviewed(Request $request)
    {
        $status = $request->input('status',  1);

        $jobs = ArtistJob::select(['id', 'name', 'artister_id', 'completed_at', 'type'])->with(['artister' => function($query){
            $query->select(['id', 'alias', 'avatar']);
        }])->where(['status' => $status, 'operater_id' => auth('member')->id()])->orderBy('id', 'desc')->paginate(10);

        return $this->success($jobs);
    }

    /**
     * 通告审核
     * @param Request $request
     * @return mixed
     */
    public function jobReviewedAct(Request $request)
    {
        $job = ArtistJob::find($request->input('id'));
        if(!$job){
            return $this->failed('参数不正确');
        }

        $status = $request->input('status', 2);
        if($status != 2){
            return $this->failed('参数不正确');
        }

        $job->status = 2;

        if($job->save()){
            if($job->type == 1){
                $jobRecord = new ArtistJobRecord();
                $jobRecord->artist_job_id = $job->id;
                $jobRecord->publish_id = auth('member')->id();
                $jobRecord->deadline_at = $job->completed_at;
                $jobRecord->content = $request->input('content');
                $jobRecord->save();
            }
            $this->noticeService->jobSend($job->operater_id, $job->artister_id, $job->id, '审核通过一条通告');
            return $this->message('审核通过');
        }else{
            return $this->failed('审核失败');
        }

    }

    /**
     * 审核不通过添加备注
     * @param Request $request
     * @return mixed
     */
    public function publishReviewedJob(Request $request)
    {
        $job = ArtistJob::find($request->input('id'));
        if(!$job){
            return $this->failed('参数不正确');
        }
        $job->completed_at = $request->input('completed_at');
        $job->status = 3;
        $job->video_urls = $request->input('video_urls');

        $jobRecord = new ArtistJobRecord();
        $jobRecord->name = $request->input('name');
        $jobRecord->artist_job_id = $job->id;
        $jobRecord->publish_id = auth('member')->id();
        $jobRecord->deadline_at = $request->input('completed_at');
        $jobRecord->video_urls = $request->input('video_urls');
        $jobRecord->content = $request->input('content');

        if($jobRecord->save()){
            $job->save();
            $this->noticeService->jobSend($job->operater_id, $job->artister_id, $job->id, '审核不通过一条通告');
            return $this->message('提交成功');
        }else{
            return $this->failed('提交失败');
    }
    }

}
