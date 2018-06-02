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
    '__pattern__' => [
        'name' => '\w+',
    ],
    '[hello]'     => [
        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['index/hello', ['method' => 'post']],
    ],

    //登录入口绑定，例如输入web.gf.com/index/1
    //'index/:id'   =>  ['user/Publics/signin',['method'=>'get'],['id'=>'\d+']],

//  配置MISS路由
//    '[blog]' =>  [
//        'edit/:id'  => ['Blog/edit',['method' => 'get'], ['id' => '\d+']],
//        ':id'       => ['Blog/read',['method' => 'get'], ['id' => '\d+']],
//        '__miss__'  => 'blog/miss',
//    ],
//    'new/:id'   => 'News/read',
//    '__miss__'  => 'public/miss',
];
