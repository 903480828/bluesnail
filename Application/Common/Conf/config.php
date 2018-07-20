<?php
return array(
	//'配置项'=>'配置值'
	
	'DB_TYPE'               =>  'mysql',     // 数据库类型
	'DB_HOST'               =>  'localhost', // 服务器地址
	'DB_NAME'               =>  'bluesnail',          // 数据库名
	'DB_USER'               =>  'root',      // 用户名
	'DB_PWD'                =>  '',          // 密码
	'DB_PORT'               =>  '3306',        // 端口
	'DB_PREFIX'             =>  'bsn_',    // 数据库表前缀
	'DB_FIELDTYPE_CHECK'    =>  false,       // 是否进行字段类型检查 3.2.3版本废弃
	'DB_FIELDS_CACHE'       =>  true,        // 启用字段缓存
	'DB_CHARSET'            =>  'utf8',      // 数据库编码默认采用utf8
	'DB_DEPLOY_TYPE'        =>  0, // 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)
	'DB_RW_SEPARATE'        =>  false,       // 数据库读写是否分离 主从式有效
	'DB_MASTER_NUM'         =>  1, // 读写分离后 主服务器数量
	'DB_SLAVE_NO'           =>  '', // 指定从服务器序号
	'DB_SQL_BUILD_CACHE'    =>  false, // 数据库查询的SQL创建缓存 3.2.3版本废弃
	'DB_SQL_BUILD_QUEUE'    =>  'file',   // SQL缓存队列的缓存方式 支持 file xcache和apc 3.2.3版本废弃
	'DB_SQL_BUILD_LENGTH'   =>  20, // SQL缓存的队列长度 3.2.3版本废弃
	'DB_SQL_LOG'            =>  false, // SQL执行日志记录 3.2.3版本废弃
	'DB_BIND_PARAM'         =>  false, // 数据库写入数据自动参数绑定
	'DB_DEBUG'              =>  false,  // 数据库调试模式 3.2.3新增 
	'DB_LITE'               =>  false,  // 数据库Lite模式 3.2.3新增 

	'TMPL_CONTENT_TYPE'     =>  'text/html', // 默认模板输出类型
	'TMPL_ACTION_ERROR'     =>  THINK_PATH.'Tpl/dispatch_jump.tpl', // 默认错误跳转对应的模板文件
	'TMPL_ACTION_SUCCESS'   =>  THINK_PATH.'Tpl/dispatch_jump.tpl', // 默认成功跳转对应的模板文件
	'TMPL_EXCEPTION_FILE'   =>  THINK_PATH.'Tpl/think_exception.tpl',// 异常页面的模板文件
	'TMPL_DETECT_THEME'     =>  false,       // 自动侦测模板主题
	'TMPL_TEMPLATE_SUFFIX'  =>  '.html',     // 默认模板文件后缀
	'TMPL_FILE_DEPR'        =>  '/', //模板文件CONTROLLER_NAME与ACTION_NAME之间的分割符
	'TMPL_ENGINE_TYPE'      =>  'Think',     // 默认模板引擎 以下设置仅对使用Think模板引擎有效
	'TMPL_CACHFILE_SUFFIX'  =>  '.php',      // 默认模板缓存后缀
	'TMPL_DENY_FUNC_LIST'   =>  'echo,exit',    // 模板引擎禁用函数
	'TMPL_DENY_PHP'         =>  false, // 默认模板引擎是否禁用PHP原生代码
	'TMPL_L_DELIM'          =>  '{',            // 模板引擎普通标签开始标记
	'TMPL_R_DELIM'          =>  '}',            // 模板引擎普通标签结束标记
	'TMPL_VAR_IDENTIFY'     =>  'array',     // 模板变量识别。留空自动判断,参数为'obj'则表示对象
	'TMPL_STRIP_SPACE'      =>  true,       // 是否去除模板文件里面的html空格与换行
	'TMPL_CACHE_ON'         =>  false,        // 是否开启模板编译缓存,设为false则每次都会重新编译
	'TMPL_CACHE_PREFIX'     =>  '',         // 模板缓存前缀标识，可以动态改变
	'TMPL_CACHE_TIME'       =>  0,         // 模板缓存有效期 0 为永久，(以数字为值，单位:秒)
	'TMPL_LAYOUT_ITEM'      =>  '{__CONTENT__}', // 布局模板的内容替换标识
	'LAYOUT_ON'             =>  false, // 是否启用布局
	'LAYOUT_NAME'           =>  'layout', // 当前布局名称 默认为layout
	'SESSION_AUTO_START' =>false,//系统不自动启动Session
    'SESSION_OPTIONS'=>array(
        'use_trans_sid'=>1,
        'expire'=>3600,//设置过期时间session.gc_maxlifetime的值为1小时
    ),
	'MAIL_PORT'=>80,
	'MAIL_HOST' =>'smtp.163.com',//smtp服务器的名称
    'MAIL_SMTPAUTH' =>TRUE, //启用smtp认证
    'MAIL_USERNAME' =>'lansewoniuteam@163.com',//你的邮箱名
    'MAIL_FROM' =>'lansewoniuteam@163.com',//发件人地址
    'MAIL_FROMNAME'=>'蓝色蜗牛官方团队',//发件人姓名
    'MAIL_PASSWORD' =>'lansewoniu321w',//邮箱密码
    'MAIL_CHARSET' =>'utf-8',//设置邮件编码
    'MAIL_ISHTML' =>FALSE, // 是否HTML格式邮件
);