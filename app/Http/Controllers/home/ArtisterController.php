<?php

namespace App\Http\Controllers\home;

use App\Helpers\NoticeService;
use App\Models\ArtistJob;
use App\Models\ArtistJobRecord;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArtisterController extends BaseController
{

    protected $noticeService;

    public function __construct(NoticeService $noticeService)
    {
        $this->noticeService = $noticeService;
    }

    /**
     * 视频拍摄和商业活动
     * @param Request $request
     * @return mixed
     */
    public function jobs(Request $request)
    {
        $type = $request->input('type', 0);
        $jobs = ArtistJob::select(['id', 'name', 'operater_id', 'completed_at', 'type', 'status'])->with(['operater' => function($query){
            $query->select(['id', 'alias', 'avatar']);
        }])->where(['type' => $type, 'artister_id' => auth('member')->id(), 'status' => 0])->orderBy('id', 'desc')->paginate(10);

        return $this->success($jobs);
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
            ->with(['operater' => function($query){
                $query->select(['id', 'alias', 'avatar']);
            }])->with(['record' => function($query){
                $query->select(['id', 'name', 'artist_job_id', 'video_urls', 'image_urls', 'content'])->orderBy('id', 'desc');
            }])->find($request->input('id'));
        return $this->success($job);
    }

    /**
     * 发布通告
     * @param Request $request
     * @return mixed
     */
    public function publishJob(Request $request)
    {
        $jobId = $request->input('id');
        if(!$job = ArtistJob::find($jobId)){
            return $this->failed('参数错误');
        }

        $artistJobRecord = new ArtistJobRecord();
        $artistJobRecord->artist_job_id = $job->id;
        $artistJobRecord->publish_id = auth('member')->id();
        $artistJobRecord->deadline_at = $job->completed_at;
        if($job->type == 0){
            $artistJobRecord->video_urls = $request->input('video_urls');
            if($artistJobRecord->video_urls == ''){
                return $this->failed('请上传视频');
            }
        }else{
            $artistJobRecord->image_urls = $request->input('image_urls');
            if($artistJobRecord->image_urls == ''){
                return $this->failed('请上传图片');
            }
        }
        if($artistJobRecord->save()){
            $job->status = 1;
            $job->save();
            $this->noticeService->jobSend($job->artister_id, $job->operater_id, $job->id, '你有一条新的审核');
            return $this->message('提交成功');
        }else{
            return $this->failed('提交失败');
        }

    }

    /**
     * 审核/待审核
     * @param Request $request
     * @return mixed
     */
    public function jobReviewed(Request $request)
    {
        $status = $request->input('status',  3);

        $jobs = ArtistJob::select(['id', 'name', 'operater_id', 'completed_at', 'type'])->with(['operater' => function($query){
            $query->select(['id', 'alias', 'avatar']);
        }])->with(['record' => function($query){
            $query->select(['id', 'name', 'artist_job_id', 'video_urls', 'image_urls', 'content'])->orderBy('id', 'desc');
        }])->where(['status' => $status, 'artister_id' => auth('member')->id()])->orderBy('id', 'desc')->paginate(10);

        return $this->success($jobs);
    }

}
