<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('auth/login', ['as' => 'login', 'uses' => 'home\AuthenticateController@login']);
Route::get('wechat/auth', ['as' => 'login', 'uses' => 'home\AuthenticateController@wechatAuth']);
Route::get('wechat/auth/bind', ['as' => 'login', 'uses' => 'home\AuthenticateController@weChatAuthBind']);

Route::post('file/upload/image', 'FileController@uploadImage')->name('upload.image');
Route::post('file/upload/images', 'FileController@uploadImages')->name('upload.images');
Route::post('file/upload/video', 'FileController@uploadVideo')->name('upload.video');

Route::get('video/categories', 'home\VideoCategoryController@all')->name('video.categories');
Route::get('video/materials', 'home\VideoMaterialController@list')->name('video.materials');

Route::group(['middleware' => ['auth.token:member']], function(){

    //通知
    Route::get('job/notices', 'home\NoticeController@jobs')->name('job.notices');
    Route::get('job/notices/clear', 'home\NoticeController@clear')->name('job.notices.clear');

    // 运营
    Route::group(['middleware' => ['checkOperater']], function(){
        Route::post('member/publish/video/material', 'home\OperaterController@publishVideoMaterial')->name('member.publish.video.material');
        Route::get('member/artisters', 'home\OperaterController@getArtisters')->name('member.artisters');
        Route::post('member/publish/job', 'home\OperaterController@publishJob')->name('member.publish.job');

        Route::get('member/unfinished/jobs', 'home\OperaterController@unfinishedJobs')->name('member.unfinished.jobs');
        Route::get('member/job/detail', 'home\OperaterController@jobDetail')->name('member.job.detail');

        Route::get('member/job/cancle', 'home\OperaterController@jobCancle')->name('member.job.cancle');
        Route::get('member/job/reviewed', 'home\OperaterController@jobReviewed')->name('member.job.reviewed');
        Route::get('member/job/reviewedact', 'home\OperaterController@jobReviewedAct')->name('member.job.reviewed.act');
        Route::post('member/publish/reviewedjob', 'home\OperaterController@publishReviewedJob')->name('member.publish.reviewed.job');

    });

    // 艺人
    Route::group(['middleware' => ['checkArtister']], function(){
        Route::get('artister/jobs', 'home\ArtisterController@jobs')->name('artister.jobs');
        Route::get('artister/job/detail', 'home\ArtisterController@jobDetail')->name('artister.job.detail');

        Route::post('artister/publish/job', 'home\ArtisterController@publishJob')->name('artister.publish.job');
        Route::get('artister/job/reviewed', 'home\ArtisterController@jobReviewed')->name('artister.job.reviewed');

    });

});

/********************************************************************************************************/

Route::post('admin/auth/login', ['as' => 'login', 'uses' => 'admin\AuthenticateController@login']);

Route::group(['middleware' => ['auth.token:user'], 'prefix' => 'admin'], function(){
    // 首页配置信息
    Route::get('servers', 'admin\IndexController@server')->name('admin.servers');

    // 用户列表
    Route::get('members', 'admin\MemberController@index')->name('admin.members');
    Route::get('members/info', 'admin\MemberController@info')->name('admin.members.info');
    Route::post('members/edit', 'admin\MemberController@edit')->name('admin.members.edit');
    Route::get('members/delete', 'admin\MemberController@delete')->name('admin.members.delete');

    // 分类列表
    Route::get('video/categories', 'admin\VideoCategoryController@index')->name('admin.video.categories');
    Route::post('video/categories/add', 'admin\VideoCategoryController@add')->name('admin.video.categories.add');
    Route::get('video/categories/info', 'admin\VideoCategoryController@info')->name('admin.video.categories.info');
    Route::post('video/categories/edit', 'admin\VideoCategoryController@edit')->name('admin.video.categories.edit');
    Route::get('video/categories/delete', 'admin\VideoCategoryController@delete')->name('admin.video.categories.delete');

    // 素材列表
    Route::get('video/materials', 'admin\VideoMaterialController@index')->name('admin.video.materials');
    Route::get('video/materials/info', 'admin\VideoMaterialController@info')->name('admin.video.materials.info');
    Route::get('video/materials/delete', 'admin\VideoMaterialController@delete')->name('admin.video.materials.delete');

    // 通告列表
    Route::get('artist/jobs', 'admin\ArtistJobController@index')->name('admin.artist.jobs');
    Route::get('artist/jobs/info', 'admin\ArtistJobController@info')->name('admin.artist.jobs.info');
    Route::get('artist/jobs/delete', 'admin\ArtistJobController@delete')->name('admin.artist.jobs.delete');

    // 管理员列表
    Route::get('users', 'admin\UserController@index')->name('admin.users');
    Route::post('users/add', 'admin\UserController@add')->name('admin.users.add');
    Route::get('users/info', 'admin\UserController@info')->name('admin.users.info');
    Route::post('users/edit', 'admin\UserController@edit')->name('admin.users.edit');
    Route::get('users/delete', 'admin\UserController@delete')->name('admin.users.delete');
});


