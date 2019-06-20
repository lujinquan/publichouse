<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: yunwuxin <448901948@qq.com>
// +----------------------------------------------------------------------

return [
    //验证码配置
    'captcha'  => [
        //验证码字符
        //'codeSet' => '2345678abcdefghijkmnpqrstuvwxyzABCDEFGHJKLMNPQRTUVWXY',
        'codeSet' => '2345678',
        // 验证码字体大小(px)
        'fontSize' => 18,
        // 是否话混淆曲线
        'useCurve'  => false,
        // 是否添加杂点
        'useNoise' => false,
        //验证码图片高度
        'imageH'  => 37,
        //验证码图片宽度
        'imageW'  =>  140,
        // 验证码长度（位数）
        'length'   => 4,
        // 验证成功后是否重置
        'reset'   =>  true
    ],
];