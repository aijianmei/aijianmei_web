<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2009 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// $Id$

/**
 +------------------------------------------------------------------------------
 * ThinkPHP 应用程序�?执行应用过程管理
 +------------------------------------------------------------------------------
 * @category   Think
 * @package  Think
 * @subpackage  Core
 * @author    liu21st <liu21st@gmail.com>
 * @version   $Id$
 +------------------------------------------------------------------------------
 */
class App
{//类定义开�?

    /**
     +----------------------------------------------------------
     * 应用程序初始�?
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @return void
     +----------------------------------------------------------
     */
    static public function init()
    {
        // 设定错误和异常处�?
        set_error_handler(array('App','appError'));
        set_exception_handler(array('App','appException'));

        //[RUNTIME]
        // �?��项目是否编译�?
        // 在部署模式下会自动在第一次执行的时�?编译项目
        if (defined('RUNTIME_MODEL')) {
            // 运行模式无需载入项目编译缓存
        } else if (is_file(RUNTIME_PATH.'/~app.php') && (!is_file(CONFIG_PATH.'config.php') || filemtime(RUNTIME_PATH.'/~app.php')>filemtime(CONFIG_PATH.'config.php'))) {
            // 直接读取编译后的项目文件
            C(include RUNTIME_PATH.'/~app.php');
			//载入基本配置
        } else {
            // 预编译项�?
            App::build();
        }
        //[/RUNTIME]

        if (!defined('MODULE_NAME'))
            define('MODULE_NAME', App::getModule()); // Module名称
        if (!defined('ACTION_NAME'))
            define('ACTION_NAME', App::getAction()); // Action操作

        // If already slashed, strip.
        if (get_magic_quotes_gpc()) {//get_magic_quotes_gpc取得 PHP 环境变量 magic_quotes_gpc 的�?
            $_GET    = stripslashes_deep( $_GET    );
            $_POST   = stripslashes_deep( $_POST   );
            $_COOKIE = stripslashes_deep( $_COOKIE );
        }

		$_REQUEST = array_merge($_GET,$_POST);

        // 重塑Session (必须位于session_start()之前)
        if (isset($_POST['PHPSESSID'])) {
            Session::destroy();
            session_id($_POST['PHPSESSID']);
        }

        // 初始化Session
        if (C('SESSION_AUTO_START'))
            Session::start();

        // 初始化运行时缓存
        object_cache_init();

        // 修正IIS下的$_SERVER['REQUEST_URI']

        $_SERVER['REQUEST_URI'] = getRequestUri();

        // 站点设置
        App::checkSiteOption();

        // 加载�?��插件
        if (C('APP_PLUGIN_ON'))
            Addons::loadAllValidAddons();

        // 项目�?��标签
        if (C('APP_PLUGIN_ON'))
            tag('app_begin');

        // 设置系统时区 PHP5支持
        if (function_exists('date_default_timezone_set'))
            date_default_timezone_set(C('DEFAULT_TIMEZONE'));

        // 允许注册AUTOLOAD方法
        if (C('APP_AUTOLOAD_REG') && function_exists('spl_autoload_register'))
            spl_autoload_register(array('Think', 'autoload'));

        /*
         * 应用调度过滤�?
         * 如果没有加载任何URL调度�? 默认只支�?QUERY_STRING 方式
         */
        if (C('URL_DISPATCH_ON'))
            Dispatcher::dispatch();

        /*
         * PHP_FILE 由内置的Dispacher定义
         * 如果不使用该插件，需要重新定�?
         */
        if (!defined('PHP_FILE'))
            define('PHP_FILE',_PHP_FILE_);

        // 取得模块和操作名�?
        // 可以在Dispatcher中定义获取规�?

        // 使用手持设备�? 对home的访问默认跳转至移动�? 除非用户指定访问普�?版�?
        if (APP_NAME == 'home' && $_SESSION['wap_to_normal'] != '1' && cookie('wap_to_normal') != '1' && $_REQUEST['wap_to_normal'] != '1') {
            if (MODULE_NAME == 'Public' && ACTION_NAME == 'tryOtherLogin')
            	;
            else if (MODULE_NAME == 'Widget' && ACTION_NAME == 'addonsRequest')
                ;
            //else if (isiPhone() || isAndroid()) // iOS和Android跳转�?G�?
            //   U('w3g/Index/index', '', true);
            else if (isMobile() && !isiPad()) // 其他手机跳转至WAP�?
                U('wap/Index/index', '', true);
        }

        // �?��应用是否安装 (Admin和默认应用不�?��安装)
        if (MODULE_NAME != 'Admin' && !in_array(APP_NAME, C('DEFAULT_APPS')) && !model('App')->isAppNameActive(APP_NAME))
            throw_exception(L('_APP_INACTIVE_').APP_NAME);

        $GLOBALS['ts']['_app']    = APP_NAME;
        $GLOBALS['ts']['_mod']    = MODULE_NAME;
        $GLOBALS['ts']['_act']    = ACTION_NAME;

        // 加载模块配置文件
        if (is_file(CONFIG_PATH.strtolower(MODULE_NAME).'_config.php'))
            C(include CONFIG_PATH.strtolower(MODULE_NAME).'_config.php');

		//Ucenter初始�?
		App::initUcenter();
        // 用户认证
        App::checkUser();
        // 语言�?��
        App::checkLanguage();
        // 模板�?��
        App::checkTemplate();
        // �?��静�?缓存
        if (C('HTML_CACHE_ON'))
            HtmlCache::readHTMLCache();

        // 项目初始化标�?
        if (C('APP_PLUGIN_ON'))
            tag('app_init');

        return ;
    }

    //[RUNTIME]
    /**
     +----------------------------------------------------------
     * 读取配置信息 编译项目
     +----------------------------------------------------------
     * @access private
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     */
    static private function build()
    {
        // 加载惯例配置文件 sociax:2010-1-13 修改
        C(include CORE_PATH.'/sociax/convention.php');

        // 加载平台配置文件 sociax:2010-1-15 修改
        if(is_file(SITE_PATH.'/config.inc.php'))
            C(include SITE_PATH.'/config.inc.php');

        // 加载路由配置文件
        if(is_file(SITE_PATH.'/router.inc.php'))
            C(include SITE_PATH.'/router.inc.php');

        // 加载访问控制配置文件
        if(is_file(SITE_PATH.'/access.inc.php'))
            C(include SITE_PATH.'/access.inc.php');

        // 加载敏感词过滤配置文�?
        if(is_file(SITE_PATH.'/badwords.inc.php'))
            C(include SITE_PATH.'/badwords.inc.php');

        // 加载项目配置文件
        if(is_file(CONFIG_PATH.'config.php'))
            C(include CONFIG_PATH.'config.php');

        $runtime = RUNTIME_ALLINONE;
        $common   = '';
        //是否调试模式. ALL_IN_ONE模式�? 调试模式无效
        $debug  =  C('APP_DEBUG') && !$runtime;

        // 加载项目公共文件
        if(is_file(COMMON_PATH.'common.php')) {
            include COMMON_PATH.'common.php';
            if(!$debug) // 编译文件
                $common   .= compile(COMMON_PATH.'common.php',$runtime);
        }
        // 加载项目编译文件列表
        if(is_file(CONFIG_PATH.'app.php')) {
            $list   =  include CONFIG_PATH.'app.php';
            foreach ($list as $file){
                // 加载并编译文�?
                require $file;
                if(!$debug) $common   .= compile($file,$runtime);
            }
        }
        // 读取扩展配置文件
        $list = C('APP_CONFIG_LIST');
        foreach ($list as $val){
            if(is_file(CONFIG_PATH.$val.'.php'))
                C('_'.$val.'_',array_change_key_case(include CONFIG_PATH.$val.'.php'));
        }

        // 如果是调试模式加载调试模式配置文�?
        if($debug) {
            // 加载系统默认的开发模式配置文�?
            C(include THINK_PATH.'/Common/debug.php');

            // 加载站点的开发模式配�?
            if (is_file(SITE_PATH . '/debug.php'))
                C(include SITE_PATH . '/debug.php');

            // 加载应用的开发模式配�?
            if(is_file(CONFIG_PATH.'debug.php'))
                C(include CONFIG_PATH.'debug.php');
        }else{
            // 部署模式下面生成编译文件
            // 下次直接加载项目编译文件
            if(RUNTIME_ALLINONE) {
                // 获取用户自定义变�?
                $defs = get_defined_constants(TRUE);

			//sociax:2010-1-12 修改核心，删除几个编译后被重复定义的常量�?
			unset( $defs['user']['HTTP_SESSION_STARTED'],
                $defs['user']['HTTP_SESSION_CONTINUED'],
                $defs['user']['SITE_DATA_PATH'],
                $defs['user']['SITE_DOMAIN'],
                $defs['user']['UPLOAD_PATH'],
                $defs['user']['SITE_PATH'],
                $defs['user']['CORE_PATH'],
                $defs['user']['APPS_PATH'],
                $defs['user']['ADDON_PATH'],
                $defs['user']['HAS_ONE'],
                $defs['user']['BELONGS_TO'],
                $defs['user']['HAS_MANY'],
                $defs['user']['MANY_TO_MANY'],
                $defs['user']['CLIENT_MULTI_RESULTS'] );

                $content  = array_define($defs['user']);
                $content .= substr(file_get_contents(RUNTIME_PATH.'/~runtime.php'),5);
                $content .= $common."\nreturn ".var_export(C(),true).';';
                file_put_contents(RUNTIME_PATH.'/~allinone.php',strip_whitespace('<?php '.$content));
            }else{
                $content  = "<?php ".$common."\nreturn ".var_export(C(),true).";\n?>";
                file_put_contents(RUNTIME_PATH.'/~app.php',strip_whitespace($content));
            }
        }

        return ;
    }
    //[/RUNTIME]

    /**
     +----------------------------------------------------------
     * 获得实际的模块名�?
     +----------------------------------------------------------
     * @access private
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     */
    static private function getModule()
    {
        $var  =  C('VAR_MODULE');
        $module = !empty($_POST[$var]) ?
            $_POST[$var] :
            (!empty($_GET[$var])? $_GET[$var]:C('DEFAULT_MODULE'));
        if (C('URL_CASE_INSENSITIVE')) {
            // URL地址不区分大小写
            define('P_MODULE_NAME',ucfirst($module));
            // 智能识别方式 index.php/user_type/index/ 识别�?UserTypeAction 模块
            $module = ucfirst(parse_name(P_MODULE_NAME,1));
        }
        unset($_POST[$var],$_GET[$var]);
	return t($module);
    }

    /**
     +----------------------------------------------------------
     * 获得实际的操作名�?
     +----------------------------------------------------------
     * @access private
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     */
    static private function getAction()
    {
        $var  =  C('VAR_ACTION');
        $action   = !empty($_POST[$var]) ?
            $_POST[$var] :
            (!empty($_GET[$var])?$_GET[$var]:C('DEFAULT_ACTION'));
        unset($_POST[$var],$_GET[$var]);
	return t($action);
    }

    /**
     +----------------------------------------------------------
     * 语言�?��
     * �?��浏览器支持语�?��并自动加载语�?��
     +----------------------------------------------------------
     * @access private
     +----------------------------------------------------------
     * @return void
     +----------------------------------------------------------
     */
    static private function checkLanguage()
    {
        $langSet = C('DEFAULT_LANG');
        // 不开启语�?��功能，仅仅加载框架语�?��件直接返�?
        if (!C('LANG_SWITCH_ON')){
            L(include THINK_PATH.'/Lang/'.$langSet.'.php');
            return;
        }
        // 启用了语�?��功能
        // 根据是否启用自动侦测设置获取语言选择
        if (C('LANG_AUTO_DETECT')){
            if(isset($_GET[C('VAR_LANGUAGE')])){// �?��浏览器支持语�?
                $langSet = $_GET[C('VAR_LANGUAGE')];// url中设置了语言变量
                cookie('think_language',$langSet,3600);
            }elseif(cookie('think_language'))// 获取上次用户的�?�?
                $langSet = cookie('think_language');
            elseif(isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])){// 自动侦测浏览器语�?
                preg_match('/^([a-z\-]+)/i', $_SERVER['HTTP_ACCEPT_LANGUAGE'], $matches);
                $langSet = $matches[1];
                cookie('think_language',$langSet,3600);
            }
        }
		$langSet = strtolower($langSet);

		//目前只支持en、zh-cn两个版本语言
		if(!in_array($langSet,array('en','zh-cn')))
			$langSet = 'zh-cn';

        // 定义当前语言
        define('LANG_SET', $langSet);
        // 定义数据库SQL查询的当前语�?
        $sqlLangSet = array(
            'en' => 'en',
            'zh-cn' => 'cn',
        );
        define('SQL_LANG_SET', $sqlLangSet[$langSet]);

        // 加载框架语言�?
        if(is_file(THINK_PATH.'/Lang/'.$langSet.'.php'))
            L(include THINK_PATH.'/Lang/'.$langSet.'.php');

		// 加载全局语言�?
		// Xiao Chuan修改，不�?��加载额外的包。只要加载common包即�?
		if(is_file(SITE_PATH.'/public/Lang/'.$langSet.'/common.php')){
			L(include SITE_PATH.'/public/Lang/'.$langSet.'/common.php');
		}

        //加载错误语言�?

        if (is_file(LANG_PATH.$langSet.'/error.php'))
            L(include LANG_PATH.$langSet.'/error.php');
        // 读取项目公共语言�?
        if (is_file(LANG_PATH.$langSet.'/common.php'))
            L(include LANG_PATH.$langSet.'/common.php');
        // 读取当前模块语言�?
        if (is_file(LANG_PATH.$langSet.'/'.strtolower(MODULE_NAME).'.php'))
            L(include LANG_PATH.$langSet.'/'.strtolower(MODULE_NAME).'.php');
    }

    /**
     +----------------------------------------------------------
     * 模板�?��，如果不存在使用默认�?
     * 2011/9/13 新增功能：如果主题包目录下存在模板则覆盖默认模板
     +----------------------------------------------------------
     * @access private
     +----------------------------------------------------------
     * @return void
     +----------------------------------------------------------
     */
    static private function checkTemplate()
    {
        //当前页面地址
        define('__SELF__',PHP_FILE);
        //当前项目地址
        define('__APP__',PHP_FILE.'?app='.APP_NAME);
        //当前操作地址
        define('__URL__',PHP_FILE.'?app='.APP_NAME.'&mod='.MODULE_NAME);
        define('__ACTION__',__URL__);

        //模版名称
        define('TEMPLATE_NAME', C('DEFAULT_THEME'));

        //网站公共文件目录
        define('WEB_PUBLIC_PATH', SITE_URL.'/public');

        //当前风格�?
        global $ts;
        $template    =    ($ts['site']['site_theme'])?$ts['site']['site_theme']:'newstyle';
        define('THEME_PATH'    ,    SITE_PATH."/public/themes/{$template}");
        define('THEME_TEMPLATE_PATH',    THEME_PATH.'/apps/'.APP_NAME);
        define('THEME_URL'    ,    WEB_PUBLIC_PATH."/themes/{$template}");
        define('__THEME__'    ,    WEB_PUBLIC_PATH."/themes/{$template}");


        //如果在风格包中存在相关的模板�?则使用风格包中模�?
        if(file_exists(THEME_TEMPLATE_PATH.'/'.MODULE_NAME.'/'.ACTION_NAME.C('TMPL_TEMPLATE_SUFFIX'))){
            //当前模版路径
            C('TEMPLATE_PATH', THEME_TEMPLATE_PATH);
            //项目模板目录
            C('APP_TMPL_PATH', THEME_URL.'/apps/'.APP_NAME.'/');
            //项目公共文件目录
            C('APP_PUBLIC_PATH', C('APP_TMPL_PATH').'Public');

        //默认模版配置
        }else{
            //当前模版路径
            C('TEMPLATE_PATH',TMPL_PATH.TEMPLATE_NAME);
            //项目模板目录
            C('APP_TMPL_PATH', SITE_URL.'/apps/'.APP_NAME.'/'.TMPL_DIR.'/'.TEMPLATE_NAME.'/');
            //项目公共文件目录
            C('APP_PUBLIC_PATH', C('APP_TMPL_PATH').'Public');
        }

        //定义模版文件
        C('TMPL_FILE_NAME', C('TEMPLATE_PATH').'/'.MODULE_NAME.'/'.ACTION_NAME.C('TMPL_TEMPLATE_SUFFIX'));
        C('CACHE_PATH',CACHE_PATH);

        return ;
    }

    /**
     +----------------------------------------------------------
     * 模板站点配置
     +----------------------------------------------------------
     * @access private
     +----------------------------------------------------------
     * @return void
     +----------------------------------------------------------
     */
    static private function checkSiteOption(){
        global $ts;
        
        //初始化站点配置信息，在站点配置中：表情，网站头信息，网站的应用列表，应用权限�?
        $ts['site'] = model('Xdata')->lget('siteopt');

        //刷新频率 - 不对后台进行判断
        // if(APP_NAME != 'admin'){
        //     $ts['site']['max_refresh_time'] = $ts['site']['max_refresh_time'] > 0 ? $ts['site']['max_refresh_time'] : 1;
        //     $refresh_key = md5($_SERVER['REQUEST_URI']);
        //     if(isset($_SESSION['refresh'][$refresh_key]) && ($_SESSION['refresh'][$refresh_key]+$ts['site']['max_refresh_time']) > time()){
        //         send_http_header('utf8');
        //         die('不要频繁刷新,请稍候再�?');
        //     }else{
        //         $_SESSION['refresh'][$refresh_key] = time();
        //     }
        // }

        // �?��网站关闭
        if (1 == $ts['site']['site_closed']) {
            // 管理员登�?管理员�?�?验证码相�?不受站点关闭的控�?
            $home_public_action = array(
                'adminlogin','doAdminLogin','logoutAdmin',
                'verify', 'code', 'isVerifyAvailableLogin'
            );
            if ( APP_NAME == 'home' && MODULE_NAME == 'Public' && in_array(ACTION_NAME, $home_public_action) ) {
                return ;

            }else if (APP_NAME == 'admin') {
                // 管理后台不受站点关闭的控�?
                return ;

            }else {
                $reason = $ts['site']['site_closed_reason'];
                $template = $ts['site']['site_theme'] ? $ts['site']['site_theme'] : 'classic';
                include SITE_PATH."/public/themes/{$template}/close.html";
                exit;
            }
        }

        //�?��IP禁止
		$audit = model('Xdata')->lget('audit');
		if($audit['banip']==1){
			$client_ip = get_client_ip();
			//IP白名单过�?
			$banned_ips = $audit['ipwhitelist'];
			if(!empty($banned_ips)){
				$in_white_list = false;
				$banned_ips = explode('|',$banned_ips);
				foreach($banned_ips as $v){
					//带星号的IP地址段比�?
					if(strpos($v,'*')>0){
						$start_ip = ip2long(str_replace('*','1',$v));
						$stop_ip = ip2long(str_replace('*','255',$v));
						$client_ip = ip2long($client_ip);
						//判断当前是否不在白名单网�?
						if($client_ip>=$start_ip && $client_ip<=$stop_ip){
							$in_white_list = true;
						}
					}
					//不星号的IP地址绝对比较
					if($v==$client_ip){
						$in_white_list = true;
					}
				}
				//不在白名单中
				if(!$in_white_list){
					$template = $ts['site']['site_theme'] ? $ts['site']['site_theme'] : 'classic';
					include SITE_PATH."/public/themes/{$template}/ipbanned.html";
					exit;
				}
			}
			//IP黑名单过�?
			$banned_ips = $audit['ipblacklist'];
			if(!empty($banned_ips)){
				$in_black_list = false;
				$banned_ips = explode('|',$banned_ips);
				foreach($banned_ips as $v){
					//带星号的IP地址段比�?
					if(strpos($v,'*')>0){
						$start_ip = ip2long(str_replace('*','1',$v));
						$stop_ip = ip2long(str_replace('*','255',$v));
						$client_ip = ip2long($client_ip);
						//判断当前是否在被屏蔽网段
						if($client_ip>=$start_ip && $client_ip<=$stop_ip){
							$in_black_list = true;
						}
					}
					//不星号的IP地址绝对比较
					if($v==$client_ip){
						$in_black_list = true;
					}
				}
				//在白名单�?
				if($in_black_list){
					$template = $ts['site']['site_theme'] ? $ts['site']['site_theme'] : 'classic';
					include SITE_PATH."/public/themes/{$template}/ipbanned.html";
					exit;
				}
			}
		}

		//�?��是否启用rewrite
		if(isset($ts['site']['site_rewrite_on'])){
			C('URL_ROUTER_ON',($ts['site']['site_rewrite_on']==1));
		}
        
        //初始化manyou设置
        $my_status = model('Xdata')->lget('myop');
        $ts['site']['my_status'] = $my_status['my_status'];
        
        //全站微博、评论字数限制，默认140
        $ts['site']['length'] = $ts['site']['length'] > 0 ? $ts['site']['length'] : 140;
        
        //全站微博、评论频�?
        $ts['site']['max_post_time'] = $ts['site']['max_post_time'] > 0 ? $ts['site']['max_post_time'] : 5;
        
        //�?��关注用户�?
        $ts['site']['max_following'] = $ts['site']['max_following'] > 0 ? $ts['site']['max_following'] : 1000;
        $GLOBALS['max_following'] = $ts['site']['max_following'];
        
        //搜索频率
        $ts['site']['max_search_time'] = $ts['site']['max_search_time'] > 0 ? $ts['site']['max_search_time'] : 5;
        
        return;
    }

    /**
     +----------------------------------------------------------
     * Ucenter初始�?
     +----------------------------------------------------------
     * @access private
     +----------------------------------------------------------
     * @return void
     +----------------------------------------------------------
     */
	static private function initUcenter()
	{
		// 获取UCenter的应用列�?
		$filename = SITE_PATH . '/api/uc_client/uc_sync.php';

		if (file_exists($filename)) {

			require_once $filename;
			if (UC_SYNC) {
				unset($_ENV['app']);
				global $ts;
				$ts['ucenter']['app'] 			= uc_app_ls();
				$ts['ucenter']['current_appid'] = UC_APPID;
			}
		}
	}
    /**
     +----------------------------------------------------------
     * 用户访问权限验证
     +----------------------------------------------------------
     * @access private
     +----------------------------------------------------------
     * @return void
     +----------------------------------------------------------
     */
    static private function checkUser() {
        global $ts;

        // �?��
        if ($_GET['validationcode'] && $_GET['validationid'] && ACTION_NAME!='resendEmail')
            service('Validation')->dispatchValidation();
        // 验证登录
        if (!service('Passport')->isLogged()) { // 未登�?
            //后台判断
            if ( MODULE_NAME == 'Admin'  )
                    redirect(U('home/Public/adminlogin'));
            // �?��
            if (APP_NAME == 'home' && MODULE_NAME == 'Index' && ACTION_NAME=='index' && isset($_REQUEST['invite']))
                redirect(SITE_URL.'/index.php?app=home&mod=Public&act=register&invite='.$_REQUEST['invite']);

            // 是否�?��游客访问
            if (APP_NAME == 'home' && MODULE_NAME == 'Space' && !$ts['site']['site_anonymous']) {
            	redirect(U('home/Public/login'));
            }
                
            // 匿名访问控制
            if (!canAccess()) {
                if (App::isAjax() || strpos($_SERVER['REQUEST_URI'],"addon") != FALSE) { // Ajax访问禁止匿名的资源时, 不做自动跳转
                    exit;
                } else {
					$allowregAct=array('selectRegister','register','doregister','ShowImg','newShowImg','newupload','upload','setchannelinfo','fishuserinfo','saveuserinfo','uploadImageFile');
                    // 记录登录前的url地址
                    if(!$_GET['state']&&!$_GET['code']){
						if(!in_array(ACTION_NAME,$allowregAct)){
						   $_SESSION['refer_url'] = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
						}	
                    }
					if($_SESSION['shoprefer_url']!=''&&$_SESSION['refer_url']==''){
						$_SESSION['refer_url']=$_SESSION['shoprefer_url'];
						$_SESSION['shoprefer_url']='';
					}
                    if(APP_NAME !== 'index')
                    	redirect(U('home/Public/login'));
                }
            }
        } else { // 已登�?
            // 设为在线
            setOnline($_SESSION['mid']);

            // �?��用户权限. 管理后台的权限由它自己控�?
            if (!service('SystemPopedom')->hasPopedom()) {
                if (APP_NAME == 'admin')
                    redirect(U('home/Public/adminlogin'), 5, '您无权查�?);
                else
                    redirect(U('home'), 5, '您无权查�?);
            }
        }

        return;
    }

    /**
     +----------------------------------------------------------
     * 执行应用程序
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @return void
     +----------------------------------------------------------
     * @throws ThinkExecption
     +----------------------------------------------------------
     */
    static public function exec()
    {
        // 是否�?��标签扩展
        $tagOn   =  C('APP_PLUGIN_ON');
        // 项目运行标签
        if($tagOn)  tag('app_run');

        //创建Action控制器实�?
        $module  =  A(MODULE_NAME);
        if(!$module) {
            // 是否存在扩展模块
            $_module = C('_modules_.'.MODULE_NAME);
            if($_module) {
                // 'module'=>array('classImportPath'[,'className'])
                import($_module[0]);
                $class = isset($_module[1])?$_module[1]:MODULE_NAME.'Action';
                $module = new $class;
            }else{
                // 是否定义Empty模块
                $module = A("Empty");
            }
            if(!$module)
                // 模块不存�?抛出异常
                throw_exception(L('_MODULE_NOT_EXIST_').MODULE_NAME);
        }

        //获取当前操作�?
        $action = ACTION_NAME;

        //执行当前操作
        call_user_func(array(&$module,$action));

        // 项目结束标签
        if($tagOn)  tag('app_end');
        return ;
    }

    //API执行
    static public function execApi(){
        include_once (SITE_PATH.'/api/'.MODULE_NAME.'Api.class.php');
        $class = MODULE_NAME.'Api';
        $module = new $class;
        $action = ACTION_NAME;
        //执行当前操作
        $data = call_user_func(array(&$module,$action));
        $format = (in_array( $_REQUEST['format'] ,array('xml','json','php','test') ) ) ?$_REQUEST['format']:'json';
        if($format=='json'){
            exit(json_encode($data));
        }elseif ($format=='xml'){

        }elseif($format=='php'){
            //输出php格式
            exit(var_export($data));
		}elseif($format=='test'){
            //测试输出
            dump($data);
            exit;
        }
        return ;
    }

    /**
     +----------------------------------------------------------
     * 运行应用实例 入口文件使用的快捷方�?
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @return void
     +----------------------------------------------------------
     */
    static public function run() {
        App::init();
        // 记录应用初始化时�?
        if(C('SHOW_RUN_TIME'))  $GLOBALS['_initTime'] = microtime(TRUE);

        if(APP_NAME=='api'){
            App::execApi();
        }else{
            App::exec();
        }

        // 保存日志记录
        if(C('LOG_RECORD')) Log::save();
        return ;
    }


    /**
     +----------------------------------------------------------
     * 测试用的入口
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @return void
     +----------------------------------------------------------
     */
    static public function testStart() {
        //[RUNTIME]
        // �?��项目是否编译�?
        // 在部署模式下会自动在第一次执行的时�?编译项目
        if (defined('RUNTIME_MODEL')) {
            // 运行模式无需载入项目编译缓存
        } else if (is_file(RUNTIME_PATH.'/~app.php') && (!is_file(CONFIG_PATH.'config.php') || filemtime(RUNTIME_PATH.'/~app.php')>filemtime(CONFIG_PATH.'config.php'))) {
            // 直接读取编译后的项目文件
            C(include RUNTIME_PATH.'/~app.php');
        } else {
            // 预编译项�?
            App::build();
        }
        //[/RUNTIME]
        //加载�?��插件
        if (!defined('MODULE_NAME'))
            define('MODULE_NAME', App::getModule()); // Module名称
        if (!defined('ACTION_NAME'))
            define('ACTION_NAME', App::getAction()); // Action操作




        // 设置系统时区 PHP5支持
        if (function_exists('date_default_timezone_set'))
            date_default_timezone_set(C('DEFAULT_TIMEZONE'));

        // 允许注册AUTOLOAD方法
        if (C('APP_AUTOLOAD_REG') && function_exists('spl_autoload_register'))
            spl_autoload_register(array('Think', 'autoload'));


        global $ts;
        $ts['_app']    = APP_NAME;
        $ts['_mod']    = MODULE_NAME;
        $ts['_act']    = ACTION_NAME;

        // 加载模块配置文件
        if (is_file(CONFIG_PATH.strtolower(MODULE_NAME).'_config.php'))
            C(include CONFIG_PATH.strtolower(MODULE_NAME).'_config.php');

        return ;
    }

    /**
     +----------------------------------------------------------
     * 自定义异常处�?
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param mixed $e 异常对象
     +----------------------------------------------------------
     */
    static public function appException($e)
    {
        halt($e->__toString());
    }

    /**
     +----------------------------------------------------------
     * 自定义错误处�?
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param int $errno 错误类型
     * @param string $errstr 错误信息
     * @param string $errfile 错误文件
     * @param int $errline 错误行数
     +----------------------------------------------------------
     * @return void
     +----------------------------------------------------------
     */
    static public function appError($errno, $errstr, $errfile, $errline)
    {
      switch ($errno) {
          case E_ERROR:
          case E_USER_ERROR:
            if(C('LOG_RECORD')){
                $errorStr = "[$errno] $errstr ".basename($errfile)." �?$errline �?";
                Log::write($errorStr,Log::ERR);
            }
            halt($errorStr);
            break;
          case E_STRICT:
          case E_USER_WARNING:
          case E_USER_NOTICE:
          default:
            if(C('LOG_RECORD')) {
                $errorStr = "[$errno] $errstr ".basename($errfile)." �?$errline �?";
                Log::record($errorStr,Log::NOTICE);
            }
            break;
      }
    }

    /**
     +----------------------------------------------------------
     * 是否AJAX请求
     +----------------------------------------------------------
     * @access protected
     +----------------------------------------------------------
     * @return bool
     +----------------------------------------------------------
     */
    static protected function isAjax() {
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) ) {
            if('xmlhttprequest' == strtolower($_SERVER['HTTP_X_REQUESTED_WITH']))
                return true;
        }
        if(!empty($_POST[C('VAR_AJAX_SUBMIT')]) || !empty($_GET[C('VAR_AJAX_SUBMIT')]))
            // 判断Ajax方式提交
            return true;
        return false;
    }

};//类定义结�?
?>
