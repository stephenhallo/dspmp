<?php

namespace App\Http\Controllers\home;

use App\Models\User;
use FFMpeg\FFMpeg;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends BaseController
{

    public function index()
    {
        $a = new User;
        dd($a);
        $ffmpeg = FFMpeg::create(
            array(
                'ffmpeg.binaries'  => '/usr/bin/ffmpeg',
                'ffprobe.binaries' => '/usr/bin/ffprobe',
                'timeout'          => 3600, // The timeout for the underlying process
                'ffmpeg.threads'   => 12,   // The number of threads that FFMpeg should use
            )
        );
        $video = $ffmpeg->open(url('uploads'). '/videos/1.mp4');
        $frame = $video->frame(\FFMpeg\Coordinate\TimeCode::fromSeconds(1))->save('uploads/video_posters/1.jpg');
    }

}
