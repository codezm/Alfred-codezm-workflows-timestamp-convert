<?php

/**
 *      [CodeZm!] Author CodeZm[codezm@163.com].
 *
 *      时间戳转换工具
 *      $Id: timestamp.php 2017-05-20 13:21:25 codezm $
 */

date_default_timezone_set('PRC');
require_once 'workflows.php';
$w = new Workflows();
$ico_png = 'icon.png';
if(isset($argv[1])) {
    $query = urldecode($argv[1]);
}

if(empty($query)) {
    $w->result('等待用户输入', '', '获取当前时间 n或now', '请输入时间戳或日期格式', $ico_png);
    echo $w->toxml();
    exit;
}

$query = str_replace(array('年', '月', '日', '时', '分', '秒'), array('-', '-', ' ', ':', ':', ':'), $query);
$query = trim($query);

// 非时间格式
if(in_array($query, array('n', 'now'))) {
    $query = time();
}
if(!strtotime($query) && strlen(intval($query)) != 10) {
    $w->result('用户输入有误', '', '获取当前时间 n或now', '请输入时间戳或日期格式', $ico_png);
    echo $w->toxml();
    exit;
}

$query = preg_match('/^\d{10}$/', $query) ? $query : strtotime($query);
$date = date('Y-m-d', $query);
$time = date('Y-m-d H:i:s', $query);
$w->result('timestamp', $query, $query, '时间戳' . $originQuery, $ico_png);
$w->result('date', $date, $date, '日期', '');
$w->result('time', $time, $time, '日期时间', '');
echo $w->toxml();
