<?php

/**
 *      [CodeZm!] Author CodeZm[codezm@163.com].
 *
 *      时间戳转换工具
 *      $Id: timestamp.php 2017-05-20 13:21:25 codezm $
 */

date_default_timezone_set('PRC');
require_once 'workflows.php';
$w = new Workflows('Alfred-codezm-workflows-timestamp-convert');
$ico_png = 'icon.png';
if(isset($argv[1])) {
    $query = urldecode($argv[1]);
}

if(empty($query)) {
    $query = time();
    $date = date('Y-m-d', $query);
    $time = date('Y-m-d H:i:s', $query);

    $w->result(0, $query, $query, 'Timestamp - 时间戳' . $originQuery, $ico_png);
    $w->result(1, $date, $date, 'Date - 日期', '');
    $w->result(2, $time, $time, 'Date/time - 日期时间', '');
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
    $w->result('用户输入有误', '', '请输入时间戳或日期格式', '日期/时间字符串 - Power by PHP strtotime Date/Time 函数.', $ico_png, 'no', '');
    echo $w->toxml();
    exit;
}

$query = preg_match('/^\d{10}$/', $query) ? $query : strtotime($query);
$date = date('Y-m-d', $query);
$time = date('Y-m-d H:i:s', $query);
$w->result(0, $query, $query, 'Timestamp - 时间戳' . $originQuery, $ico_png);
$w->result(1, $date, $date, 'Date - 日期', '');
$w->result(2, $time, $time, 'Date/time - 日期时间', '');
echo $w->toxml();
