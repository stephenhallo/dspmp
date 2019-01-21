<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends BaseController
{

    public function server()
    {
        $servers = [
            'php_os' => PHP_OS,
            'server_software' => $_SERVER['SERVER_SOFTWARE'],
            'php_version' => PHP_VERSION,
            'zend_version' => zend_version(),
//            'mysql_close' => function_exists('mysql_close')?"是":"否",
//            'mysql_allow' => @get_cfg_var("mysql.allow_persistent")?"是 ":"否",
            'upload_max' => @get_cfg_var("upload_max_filesize")?@get_cfg_var ("upload_max_filesize"):"不允许上传附件",
            'execution_max' => @get_cfg_var("max_execution_time")."秒 ",
            'memory_limit' => @get_cfg_var("memory_limit") ? @get_cfg_var("memory_limit"):"无",
            'datetime' => date("Y-m-d G:i:s"),

        ];
        return $this->success($servers);
    }

}
