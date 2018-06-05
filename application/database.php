<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

return [
    // 数据库类型
    'type' => 'mysql',
//    // 公房正式服务器地址
//    'hostname' => 'sh-cdb-r6siqtqq.sql.tencentcdb.com',
//    // 数据库名
//    'database' => 'ph',
//    // 用户名
//    'username' => 'root',
//    // 密码
//    'password' => 'wfw@ctnm0404',
//    // 端口
//    'hostport' => '63179',

   // // 公房测试服务器地址
   // 'hostname' => 'sh-cdb-r8lcilx2.sql.tencentcdb.com',
   // // 数据库名
   // 'database' => 'PH',
   // // 用户名
   // 'username' => 'root',
   // // 密码
   // 'password' => 'Wfw@ctnm0401',
   // // 端口
   // 'hostport' => '63889',

    // 服务器地址
     'hostname'        => 'localhost',
     // 数据库名
     'database'        => 'ph20180604',
     // 用户名
     'username'        => 'root',
     // 密码
     'password'        => 'ctnm',
     // 端口
     'hostport'        => '3306',

    // 连接dsn
    'dsn' => '',
    // 数据库连接参数
    'params' => [
     	PDO::ATTR_CASE              => PDO::CASE_NATURAL,
        //PDO::ATTR_ERRMODE           => PDO::ERRMODE_EXCEPTION,
        //PDO::ATTR_ORACLE_NULLS      => PDO::NULL_NATURAL,
        //PDO::ATTR_STRINGIFY_FETCHES => false,
        PDO::ATTR_EMULATE_PREPARES  => true,
    ],
    // 数据库编码默认采用utf8
    'charset' => 'utf8',
    // 数据库表前缀
    'prefix' => 'ph_',
    // 数据库调试模式
    'debug' => true,
    // 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)
    'deploy' => 0,
    // 数据库读写是否分离 主从式有效
    'rw_separate' => false,
    // 读写分离后 主服务器数量
    'master_num' => 1,
    // 指定从服务器序号
    'slave_no' => '',
    // 是否严格检查字段是否存在
    'fields_strict' => true,
    // 数据集返回类型
    'resultset_type' => 'array',
    // 自动写入时间戳字段
    'auto_timestamp' => false,
    // 时间字段取出后的默认时间格式
    'datetime_format' => 'Y-m-d H:i:s',
    // 是否需要进行SQL性能分析
    'sql_explain' => false,
    // Builder类
    'builder' => '',
    // Query类
    'query' => '\\think\\db\\Query',
];
