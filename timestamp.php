<?php

/**
 *      [CodeZm!] Author CodeZm[codezm@163.com].
 *
 *      时间戳转换工具
 *      $Id: timestamp.php 2017-05-20 13:21:25 codezm $
 */

date_default_timezone_set('PRC');
$iconPngUrl = 'icon.png';
if(isset($argv[1])) {
    $query = urldecode($argv[1]);
}
//$microTime = round(microtime(true) * 1000);

if(empty($query)) {
    list($usec, $query) = explode(" ", microtime());
    //$query = time();
    $date = date('Y-m-d', $query);
    $time = date('Y-m-d H:i:s', $query);
    $usec = substr($usec, 2, 3);
    $microTime = $query . $usec;

    $outputs = [
        'items' => [
            [
                'arg' => $query, 
                'title' => $query, 
                'subtitle' => 'Timestamp - 时间戳', 
                'icon' => [
                    'path' => $iconPngUrl
                ], 
                'valid' => true,
            ], 
            [
                'arg' => $date, 
                'title' => $date, 
                'subtitle' => 'Date - 日期', 
                'icon' => [
                    'path' => $iconPngUrl
                ], 
                'valid' => true,
            ], 
            [
                'arg' => $time, 
                'title' => $time, 
                'subtitle' => 'Date/time - 日期时间', 
                'icon' => [
                    'path' => $iconPngUrl
                ], 
                'valid' => true,
            ],
            [
                'arg' => strtotime($date), 
                'title' => strtotime($date), 
                'subtitle' => 'Timestamp - 今日凌晨时间戳', 
                'icon' => [
                    'path' => $iconPngUrl
                ], 
                'valid' => true,
            ], 
            [
                'arg' => $time . '.' . $usec, 
                'title' => $time . '.' . $usec, 
                'subtitle' => 'Date/time - 日期时间（微秒）', 
                'icon' => [
                    'path' => $iconPngUrl
                ], 
                'valid' => true,
            ],
            [
                'arg' => $microTime, 
                'title' => $microTime, 
                'subtitle' => 'Timestamp - 当前13位时间戳', 
                'icon' => [
                    'path' => $iconPngUrl
                ], 
                'valid' => true,
            ],
        ]
    ];

    echo json_encode($outputs);
    exit;
}

$query = str_replace(array('年', '月', '日', '时', '分', '秒'), array('-', '-', ' ', ':', ':', ':'), $query);
$query = trim($query);

// 非时间格式
if(in_array($query, array('n', 'now'))) {
    $query = time();
}
if(!strtotime($query) && (strlen(intval($query)) != 10 && strlen(intval($query)) != 13)) {
    $outputs = [
        'items' => [
            [
                'uid' => '时间格式输入有误', 
                'arg' => '', 
                'title' => '请输入时间戳或日期格式', 
                'subtitle' => '日期/时间字符串 - Power by PHP strtotime Date/Time 函数.', 
                'icon' => [
                    'path' => $iconPngUrl
                ], 
                'valid' => false
            ]
        ]
    ];

    echo json_encode($outputs);
    exit;
}
$microTime = '';
if (preg_match('/^\d{13}$/', $query)) {
    $microTime = '.' . substr($query, -3);
    $query = substr($query, 0, 10);
} else {
    $query = preg_match('/^\d{10}$/', $query) ? $query : strtotime($query);
}
$date = date('Y-m-d', $query);
$time = date('Y-m-d H:i:s', $query);

$outputs = [
    'items' => [
        [
            'arg' => $query, 
            'title' => $query, 
            'subtitle' => 'Timestamp - 时间戳', 
            'icon' => [
                'path' => $iconPngUrl
            ], 
            'valid' => true,
        ], 
        [
            'arg' => $date, 
            'title' => $date, 
            'subtitle' => 'Date - 日期', 
            'icon' => [
                'path' => $iconPngUrl
            ], 
            'valid' => true,
        ], 
        [
            'arg' => $time . $microTime, 
            'title' => $time . $microTime, 
            'subtitle' => 'Date/time - 日期时间', 
            'icon' => [
                'path' => $iconPngUrl
            ], 
            'valid' => true,
        ],
        [
            'arg' => strtotime($date), 
            'title' => strtotime($date), 
            'subtitle' => 'Timestamp - 今日凌晨时间戳', 
            'icon' => [
                'path' => $iconPngUrl
            ], 
            'valid' => true,
        ]
    ]
];

echo json_encode($outputs);
exit;
