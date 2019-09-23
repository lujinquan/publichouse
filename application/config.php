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
    // +----------------------------------------------------------------------
    // | 应用设置
    // +----------------------------------------------------------------------

    // 应用命名空间
    'app_namespace'          => 'app',
    // 应用调试模式
    'app_debug'              => true,
    // 应用Trace
    'app_trace'              => false,
    // 应用模式状态
    'app_status'             => '',
    // 是否支持多模块
    'app_multi_module'       => true,
    // 入口自动绑定模块
    'auto_bind_module'       => false,
    // 注册的根命名空间
    'root_namespace'         => [],
    // 扩展函数文件
    'extra_file_list'        => [THINK_PATH . 'helper' . EXT],
    // 默认输出类型
    'default_return_type'    => 'html',
    // 默认AJAX 数据返回格式,可选json xml ...
    'default_ajax_return'    => 'json',
    // 默认JSONP格式返回的处理方法
    'default_jsonp_handler'  => 'jsonpReturn',
    // 默认JSONP处理方法
    'var_jsonp_handler'      => 'callback',
    // 默认时区
    'default_timezone'       => 'PRC',
    // 是否开启多语言
    'lang_switch_on'         => false,
    // 默认全局过滤方法 用逗号分隔多个
    'default_filter'         => '',
    // 默认语言
    'default_lang'           => 'zh-cn',
    // 应用类库后缀
    'class_suffix'           => false,
    // 控制器类后缀
    'controller_suffix'      => false,

    // +----------------------------------------------------------------------
    // | 模块设置
    // +----------------------------------------------------------------------

    // 默认模块名
    'default_module'         => 'user',
    // 禁止访问模块
    'deny_module_list'       => ['common'],
    // 默认控制器名
    'default_controller'     => 'Publics',
    // 默认操作名
    'default_action'         => 'signin',
    // 默认验证器
    'default_validate'       => '',
    // 默认的空控制器名
    'empty_controller'       => 'Error',
    // 操作方法后缀
    'action_suffix'          => '',
    // 自动搜索控制器
    'controller_auto_search' => false,

    // +----------------------------------------------------------------------
    // | URL设置
    // +----------------------------------------------------------------------

    // PATHINFO变量名 用于兼容模式
    'var_pathinfo'           => 's',
    // 兼容PATH_INFO获取
    'pathinfo_fetch'         => ['ORIG_PATH_INFO', 'REDIRECT_PATH_INFO', 'REDIRECT_URL'],
    // pathinfo分隔符
    'pathinfo_depr'          => '/',
    // URL伪静态后缀
    'url_html_suffix'        => 'html',
    // URL普通方式参数 用于自动生成
    'url_common_param'       => false,
    // URL参数方式 0 按名称成对解析 1 按顺序解析
    'url_param_type'         => 0,
    // 是否开启路由
    'url_route_on'           => true,
    // 路由使用完整匹配
    'route_complete_match'   => false,
    // 路由配置文件（支持配置多个）
    'route_config_file'      => ['route'],
    // 是否强制使用路由
    'url_route_must'         => false,
    // 域名部署
    'url_domain_deploy'      => false,
    // 域名根，如thinkphp.cn
    'url_domain_root'        => '',
    // 是否自动转换URL中的控制器和操作名
    'url_convert'            => false,
    // 默认的访问控制器层
    'url_controller_layer'   => 'controller',
    // 表单请求类型伪装变量
    'var_method'             => '_method',
    // 表单ajax伪装变量
    'var_ajax'               => '_ajax',
    // 表单pjax伪装变量
    'var_pjax'               => '_pjax',
    // 是否开启请求缓存 true自动缓存 支持设置请求缓存规则
    'request_cache'          => false,
    // 请求缓存有效期
    'request_cache_expire'   => null,

    // +----------------------------------------------------------------------
    // | 模板设置
    // +----------------------------------------------------------------------

    'template'               => [
        // 模板引擎类型 支持 php think 支持扩展
        'type'         => 'Think',
        // 模板路径
        'view_path'    => '',
        // 模板后缀
        'view_suffix'  => 'html',
        // 模板文件名分隔符
        'view_depr'    => DS,
        // 模板引擎普通标签开始标记
        'tpl_begin'    => '{',
        // 模板引擎普通标签结束标记
        'tpl_end'      => '}',
        // 标签库标签开始标记
        'taglib_begin' => '{',
        // 标签库标签结束标记
        'taglib_end'   => '}',
    ],

    // 视图输出字符串内容替换
    'view_replace_str'       => [],
    // 默认跳转页面对应的模板文件
    'dispatch_success_tmpl'  => THINK_PATH . 'tpl' . DS . 'dispatch_jump.tpl',
    'dispatch_error_tmpl'    => THINK_PATH . 'tpl' . DS . 'dispatch_jump.tpl',

   // 'dispatch_success_tmpl'  => __TEMPLATES__. 'dispatch_jump.tpl',
   // 'dispatch_error_tmpl'    => __TEMPLATES__. 'dispatch_jump.tpl',

    // +----------------------------------------------------------------------
    // | 异常及错误设置
    // +----------------------------------------------------------------------

    // 异常页面的模板文件,上线的时候去掉该注释
    // 'exception_tmpl'         => __TEMPLATES__.'404.html',

    // 错误显示信息,非调试模式有效
    'error_message'          => '页面错误！请稍后再试～',
    // 显示错误信息
    'show_error_msg'         => false,
    // 异常处理handle类 留空使用 \think\exception\Handle
    'exception_handle'       => '',

    'http_exception_template' => [
        //定义404错误的重定向页面地址
        500 => __TEMPLATES__.'404.html',
        //还可以定义其他的HTTP status
        404 => __TEMPLATES__.'404.html',
    ],

    // +----------------------------------------------------------------------
    // | 日志设置
    // +----------------------------------------------------------------------

    'log'                    => [
        // 日志记录方式，内置 file socket 支持扩展
        'type'  => 'File',
        // 日志保存目录
        'path'  => LOG_PATH,
        // 日志记录级别
        'level' => [],
    ],

    // +----------------------------------------------------------------------
    // | Trace设置 开启 app_trace 后 有效
    // +----------------------------------------------------------------------
    'trace'                  => [
        // 内置Html Console 支持扩展
        'type' => 'Html',
    ],

    // +----------------------------------------------------------------------
    // | 缓存设置
    // +----------------------------------------------------------------------

//    'cache'                  => [
//        // 驱动方式
//        'type'   => 'File',
//        // 缓存保存目录
//        'path'   => CACHE_PATH,
//        // 缓存前缀
//        'prefix' => 'ph_',
//        // 缓存有效期 0表示永久缓存
//        'expire' => 0,
//    ],

    'cache' =>  [
        // 使用复合缓存类型
        'type'  =>  'complex',
        // 默认使用的缓存
        'default'   =>  [
            // 驱动方式
            'type'   => 'File',
            // 缓存保存目录
            'path'   => CACHE_PATH,
        ],
        // 文件缓存
        'file'   =>  [
            // 驱动方式
            'type'   => 'file',
            // 设置不同的缓存保存目录
            'path'   => RUNTIME_PATH . 'file/',
        ],
        // redis缓存
        'redis'   =>  [

            'type'     => 'redis',     //驱动方式
            'port'     => 6379,        // 服务器端口
            'host'     => '127.0.0.1',
            'password' => '123456',    // redis 密码
            'expire'   => 0,
        ],
        // memcache缓存
        'memcache'   =>  [
            // 驱动方式
            'type'   => 'memcache',
            // 服务器地址
            'host'       => '127.0.0.1',
            'port'     => 11211,        // 服务器端口
        ],
    ],

    //分页配置
    'paginate'               => [
        'type'      => 'bootstrap',
        'var_page'  => 'page',
        'list_rows' => 15,
    ],

    

    // 开发模式开启，0关闭
    'develop_mode' => 0,

    //短信接口配置
    'AppKey' => '349bd70312dbac392114f5fa9a348930',
    'AppSecret' => '8bdb56f89269',
    'TemplateNumber' => '3059645',

    'session'                => [
        'id'             => '',
        // SESSION_ID的提交变量,解决flash上传跨域
        'var_session_id' => 'ph',
        // SESSION 前缀
        'prefix'         => 'ph_admin_',
        // 驱动方式 支持redis memcache memcached
        'type'           => '',
        //'expire'         => '7200',
        // 是否自动开启 SESSION
        'auto_start'     => true, 
        'path'           => SESSION_PATH,
    ],

    'cookie'                 => [
        // cookie 名称前缀
        'prefix'    => 'ph_admin_',
        // cookie 保存时间
        'expire'    => 7200,
        // cookie 保存路径
        'path'      => '/',
        // cookie 有效域名
        'domain'    => '',
        //  cookie 启用安全传输
        'secure'    => false,
        // httponly设置
        'httponly'  => '',
        // 是否使用 setcookie
        'setcookie' => true,
    ],

    'owners'          => [
        '1' => '市属',
        '2' => '区属',
        '3' => '代管',
        '5' => '自管',
        '6' => '生活',
        '7' => '托管',
    ],

    'structs'          => [
        '1' => '钢混',
        '2' => '砖木三等',
        '3' => '砖木二等',
        '4' => '砖混一等',
        '5' => '砖混二等',
        '6' => '砖木一等',
        '7' => '简易',
    ],

    'insts' => [
        '1'=>'武昌区公司','2'=>'紫阳所','3'=>'粮道所','4'=>'紫阳所01管段','5'=>'紫阳所02管段','6'=>'紫阳所03管段','7'=>'紫阳所04管段','8'=>'紫阳所05管段','9'=>'紫阳所06管段','10'=>'紫阳所07管段','11'=>'紫阳所08管段','12'=>'紫阳所09管段','13'=>'紫阳所10管段','14'=>'紫阳所11管段','15'=>'紫阳所12管段','16'=>'紫阳所13管段','17'=>'紫阳所14管段','18'=>'紫阳所15管段','34'=>'紫阳所16管段','19'=>'粮道所01管段','20'=>'粮道所02管段','21'=>'粮道所03管段','22'=>'粮道所04管段','23'=>'粮道所05管段','24'=>'粮道所06管段','25'=>'粮道所07管段','26'=>'粮道所08管段','27'=>'粮道所09管段','28'=>'粮道所10管段','29'=>'粮道所11管段','30'=>'粮道所12管段','31'=>'粮道所13管段','32'=>'粮道所14管段','33'=>'粮道所15管段','35'=>'粮道所16管段'
    ],

];

