<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArtistJobRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artist_job_records', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable()->comment('标题');
            $table->smallInteger('artist_job_id')->comment('通告id');
            $table->integer('publish_id')->comment('发布者id');
            $table->timestamp('deadline_at')->comment('截止时间');
            $table->string('place')->nullable()->comment('任务地点');
            $table->text('video_urls')->nullable()->comment('视频地址');
            $table->text('video_posters')->nullable()->comment('视频封面地址');
            $table->text('image_urls')->nullable()->comment('图片地址');
            $table->text('content')->nullable()->comment('内容');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('artist_job_records');
    }
}
