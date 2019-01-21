<?php

namespace App\Helpers;

class NoticeService {

    public function jobSend($sender_id, $receiver_id, $job_id, $content)
    {
        $notice = new \App\Models\JobNotice();
        $notice->sender_id = $sender_id;
        $notice->receiver_id = $receiver_id;
        $notice->job_id = $job_id;
        $notice->content = $content;
        $notice->save();
    }

}
