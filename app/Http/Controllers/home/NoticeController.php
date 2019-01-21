<?php

namespace App\Http\Controllers\home;

use App\Models\JobNotice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Error\Notice;

class NoticeController extends BaseController
{

    /*
     * 获取小红点
     */
    public function jobs()
    {
        $loginUser = auth('member')->user();

        $notices = JobNotice::select(['*','artist_jobs.id as aj_id', 'artist_jobs.status as aj_status'])->join('artist_jobs', 'job_id', '=', 'artist_jobs.id')
            ->where(['receiver_id' => $loginUser->id, 'job_notices.status' => 0])->get();
//        return $this->success($notices);
        if($loginUser->type == 1){
            $arr = [
                'job' => 0,
                'notice' => 0
            ];
            foreach($notices as $key => $job){
                if($job->aj_status == 0){
                    $arr['job'] = '1';
                }else if($job->aj_status >= 1){
                    $arr['notice'] = '1';
                }
            }

            return $this->success($arr);
        }else{
            if(count($notices) > 0){
                return $this->success(['job' => 0, 'notice' => 1]);
            }else{
                return $this->success(['job' => 0, 'notice' => 0]);
            }
        }
    }

    /**
     * 清除小红点
     * @param Request $request
     * @return mixed
     */
    public function clear(Request $request)
    {
        $type = $request->input('type', 1);

        $loginUser = auth('member')->user();

        if($type == 1){
            $notices = JobNotice::select(['job_notices.*','artist_jobs.id as aj_id', 'artist_jobs.status as aj_status'])->join('artist_jobs', 'job_id', '=', 'artist_jobs.id')
                ->where(['receiver_id' => $loginUser->id, 'job_notices.status' => 0, 'artist_jobs.status' => 0])->get();
        }else{
            $notices = JobNotice::select(['job_notices.*','artist_jobs.id as aj_id', 'artist_jobs.status as aj_status'])->join('artist_jobs', 'job_id', '=', 'artist_jobs.id')
                ->where(['receiver_id' => $loginUser->id, 'job_notices.status' => 0])->where('artist_jobs.status', '>=', 1)->get();
//            return $this->message($notices);

        }

//        return $this->success($notices);


        if($notices){
            foreach($notices as $notice){
//                return $this->success($notice);
                $notice->status = 1;
                $notice->save();
//                DB::table('job_notices')->where(['id' => $notice->id])->update(['status' => 1]);
            }
        }

        return $this->message('清除成功');
    }

}
