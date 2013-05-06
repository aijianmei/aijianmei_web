<?php
//站点链接
function getmyopurlInApi() {
    $uri = $_SERVER['REQUEST_URI'] ? $_SERVER['REQUEST_URI'] : ( $_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'] );
    return shtmlspecialchars('http://'.$_SERVER['HTTP_HOST'].substr($uri, 0, strrpos($uri, '/')-4));
}

//取消HTML代码
function shtmlspecialchars($string) {
    if(is_array($string)) {
        foreach($string as $key => $val) {
            $string[$key] = shtmlspecialchars($val);
        }
    } else {
        $string = preg_replace('/&amp;((#(\d{3,5}|x[a-fA-F0-9]{4})|[a-zA-Z][a-z0-9]{2,5});)/', '&\\1',
            str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $string));
    }
    return $string;
}

function doLog($data = 'No Data.', $title = '@Sociax2.0') {
    return ;
    $filename	= API_ROOT . '/log_myop.html';
    $str		= "<h3>$title</h3>" . date('Y-m-d H:i:s') . "<br />";
    $str	   .= '<pre><code>' . print_r($data,1) . '</code></pre>';
    $handle 	= fopen($filename, 'a');
    fwrite($handle, $str);
    fclose($handle);
}

function getCurrentUser() {
    $_cookie_user		= cookie('LOGGED_USER');
    $_session_user_id	= intval($_SESSION['mid']);

    // 验证本地系统登录
    if($_session_user_id){
        return $_session_user_id;
    }elseif ($_cookie_user){
        $cookieId = explode( '.', jiemi($_cookie_user) );
        if ($cookieId[0] !== 'thinksns') {
            return false;
        }

        $db_prefix	= getDbPrefix();
        $userInfo	  = doQuery("SELECT * FROM {$db_prefix}user WHERE `uid` = '{$cookieId[1]}'");
        $user       = doQuery("SELECT * FROM {$db_prefix}user WHERE `email` = '{$userInfo[0]['email']}'");
        if ($user) {
            $_SESSION['mid']	= $user[0]['uid'];
            return $_SESSION['mid'];
        }else {
            return false;
        }
    }else{
        return false;
    }
}

function refreshConfig($auto_redirect = true) {
    global $_SITE_CONFIG;
    $db_prefix  = getDbPrefix();
    $_SITE_CONFIG['uid']         = getCurrentUser();
    $_SITE_CONFIG['charset']     = 'utf-8';
    $_SITE_CONFIG['lang']        = 'zh_CN';
    $_SITE_CONFIG['timeoffset']  = 8;

    // 系统信息
    $sql = "SELECT `key`,`value` FROM {$db_prefix}system_data WHERE `list` = 'myop' OR `list` = 'siteopt'";
    $res = doQuery($sql);
    foreach ($res as $v) {
        $_SITE_CONFIG[$v['key']] = unserialize($v['value']);
    }

    // 用户信息
    $sql = "SELECT * FROM {$db_prefix}user WHERE `uid` = {$_SITE_CONFIG['uid']}";
    $res = doQuery($sql);
    $_SITE_CONFIG['userInfo']  = $res[0];

    // 消息统计
    $sql = "SELECT COUNT(*) AS count FROM {$db_prefix}message WHERE `to_uid` = {$_SITE_CONFIG['uid']} AND `is_read` = 0 AND `deleted_by` <> {$_SITE_CONFIG['uid']}";
    $res = doQuery($sql);
    $_SITE_CONFIG['userCount']['message']    = $res[0]['count'];
    $sql = "SELECT COUNT(*) AS count FROM {$db_prefix}notify WHERE `receive` = {$_SITE_CONFIG['uid']} AND `is_read` = 0";
    $res = doQuery($sql);
    $_SITE_CONFIG['userCount']['notify']     = $res[0]['count'];
    $sql = "SELECT COUNT(*) AS count FROM {$db_prefix}myop_myinvite WHERE `touid` = {$_SITE_CONFIG['uid']} AND `is_read` = 0";
    $res = doQuery($sql);
    $_SITE_CONFIG['userCount']['appmessage'] = $res[0]['count'];
    $sql = "SELECT * FROM {$db_prefix}user_count WHERE `uid` = {$_SITE_CONFIG['uid']}";
    $res = doQuery($sql);
    $res = $res[0];
    $_SITE_CONFIG['userCount']['comment']    = $res['comment'];
    $_SITE_CONFIG['userCount']['atme']       = $res['atme'];
    $_SITE_CONFIG['userCount']['total']      = array_sum($_SITE_CONFIG['userCount']);

    // 广告
    $place_array = array('middle','header','left','right','footer');
    $sql = 'SELECT `content`,`place` FROM ' . $db_prefix . 'ad WHERE `is_active` = "1" AND `content` <> "" ORDER BY `display_order` ASC,`ad_id` ASC';
    $ads = doQuery($sql);
    foreach($ads as $v) {
        $v['content'] = htmlspecialchars_decode($v['content']);
        $_SITE_CONFIG['ad'][$place_array[$v['place']]][] = $v;
    }

    // 底部文章
    $sql = 'SELECT `document_id`,`title`,`content` FROM ' . $db_prefix . 'document WHERE `is_active` = "1" AND `is_on_footer` = "1" ORDER BY `display_order` ASC,`document_id` ASC';
    $docs = doQuery($sql);
    foreach($docs as $k => $v) {
        if ( mb_substr($v['content'],0,6,'UTF8') == 'ftp://' ||
             mb_substr($v['content'],0,7,'UTF8') == 'http://' ||
             mb_substr($v['content'],0,8,'UTF8') == 'https://' ||
             mb_substr($v['content'],0,9,'UTF8') == 'mailto://' ) {
            $docs[$k]['url'] = $v['content'];
        }
        unset($docs[$k]['content']);
    }
    $_SITE_CONFIG['footer_document'] = $docs;
}

function setTitle($title = '') {
    global $_SITE_CONFIG;
    $_SITE_CONFIG['page_title'] = $title;
}

function getPublicConfig() {
    static $_config = '';
    if ( empty($_config) ) {
        $_config = include SITE_ROOT . '/config.inc.php';
    }
    return $_config;
}

function getDb() {
    static $_db = '';
    if ( empty($_db) ) {
        require_once API_ROOT . '/lib/ez_sql_core.php';
        require_once API_ROOT . '/lib/ez_sql_mysql.php';
        include SITE_ROOT . '/config.inc.php';
        $_config = include SITE_ROOT . '/config.inc.php';
        $_db = new ezSQL_mysql($_config['DB_USER'], $_config['DB_PWD'], $_config['DB_NAME'], $_config['DB_HOST']);
    }
    return $_db;
}

function getDbPrefix() {
    static $_prefix = '';
    if ( empty($_prefix) ) {
        $_prefix = getPublicConfig();
        $_prefix = $_prefix['DB_PREFIX'];
    }
    return $_prefix;
}

function getLastSql() {
    static $_sql = '';
    if ( empty($_sql) ) {
        $db		 = getDb();
        $_sql	 = $db->last_query;
    }
    return $_sql;
}

function doQuery($sql = '') {
    if ( empty($sql) )
        return false;

    $_db = getDb();

    //当INSERT/DELETE/UPDATE/REPLACE时调用ez_sql的query函数，否则调用get_results函数
    if ( preg_match("/^(insert|delete|update|replace)\s+/i", $sql) ) {
        $res = $_db->query($sql);
    } else {
        $res = $_db->get_results($sql, ARRAY_A);
    }
    return $res;
}

//添加数据
function inserttable($tablename, $insertsqlarr, $returnid=0, $replace = false, $silent=0) {
    $tablename			= getDbPrefix() . $tablename;
    $insertkeysql		= $insertvaluesql = $comma = '';
    foreach ($insertsqlarr as $insert_key => $insert_value) {
        $insertkeysql 	.= $comma.'`'.$insert_key.'`';
        $insertvaluesql .= $comma.'\''.$insert_value.'\'';
        $comma = ', ';
    }
    $method = $replace ? 'REPLACE' : 'INSERT';
    $res	= doQuery($method.' INTO '.$tablename.' ('.$insertkeysql.') VALUES ('.$insertvaluesql.')');
    if($returnid && !$replace) {
        return $res;
    }
}

//更新数据
function updatetable($tablename, $setsqlarr, $wheresqlarr, $silent=0) {
    $tablename 	= getDbPrefix() . $tablename;
    $setsql 	= $comma = '';
    foreach ($setsqlarr as $set_key => $set_value) {//fix
        $setsql .= $comma.'`'.$set_key.'`'.'=\''.$set_value.'\'';
        $comma = ', ';
    }
    $where = $comma = '';
    if(empty($wheresqlarr)) {
        $where = '1';
    } elseif(is_array($wheresqlarr)) {
        foreach ($wheresqlarr as $key => $value) {
            $where .= $comma.'`'.$key.'`'.'=\''.$value.'\'';
            $comma = ' AND ';
        }
    } else {
        $where = $wheresqlarr;
    }
    return doQuery('UPDATE '.$tablename.' SET '.$setsql.' WHERE '.$where);
}

//  Format a mySQL string correctly for safe mySQL insert (no mater if magic quotes are on or not)
function escape($str) {
    return mysql_escape_string(stripslashes($str));
}

//去掉slassh
function sstripslashes($string) {
    if(is_array($string)) {
        foreach($string as $key => $val) {
            $string[$key] = sstripslashes($val);
        }
    } else {
        $string = stripslashes($string);
    }
    return $string;
}

function getUserName($uid) {
    $db_prefix	= getDbPrefix();
    $res 		= doQuery("SELECT uname FROM {$db_prefix}user WHERE `uid` = $uid AND `is_active` = 1");
    return $res[0]['uname'];
}

//获取用户空间信息
function getspace($key, $indextype='uid', $auto_open=0) {
    //My.class.php / callback()
    $res = array();
    $res['uid']		= $key;
    $res['uname']	= getUserName($key);
    return $res;



    global $_SGLOBAL, $_SCONFIG, $_SN;

    $var = "space_{$key}_{$indextype}";
    if(empty($_SGLOBAL[$var])) {
        $space = array();
        $query = $_SGLOBAL['db']->query("SELECT sf.*, s.* FROM ".tname('space')." s LEFT JOIN ".tname('spacefield')." sf ON sf.uid=s.uid WHERE s.{$indextype}='$key'");
        if(!$space = $_SGLOBAL['db']->fetch_array($query)) {
            $space = array();
            if($indextype=='uid' && $auto_open) {
                //自动�??空间
                include_once(S_ROOT.'./uc_client/client.php');
                if($user = uc_get_user($key, 1)) {
                    include_once(S_ROOT.'./source/function_space.php');
                    $space = space_open($user[0], addslashes($user[1]), 0, addslashes($user[2]));
                }
            }
        }
        if($space) {
            $_SN[$space['uid']] = ($_SCONFIG['realname'] && $space['name'] && $space['namestatus'])?$space['name']:$space['username'];
            $space['self'] = ($space['uid']==$_SGLOBAL['supe_uid'])?1:0;

            //好友缓存
            $space['friends'] = array();
            if(empty($space['friend'])) {
                if($space['friendnum']>0) {
                    $fstr = $fmod = '';
                    $query = $_SGLOBAL['db']->query("SELECT fuid FROM ".tname('friend')." WHERE uid='$space[uid]' AND status='1'");
                    while ($value = $_SGLOBAL['db']->fetch_array($query)) {
                        $space['friends'][] = $value['fuid'];
                        $fstr .= $fmod.$value['fuid'];
                        $fmod = ',';
                    }
                    $space['friend'] = $fstr;
                }
            } else {
                $space['friends'] = explode(',', $space['friend']);
            }

            $space['username'] = addslashes($space['username']);
            $space['name'] = addslashes($space['name']);
            $space['privacy'] = empty($space['privacy'])?(empty($_SCONFIG['privacy'])?array():$_SCONFIG['privacy']):unserialize($space['privacy']);

            //通知�?
            $space['allnotenum'] = 0;
            foreach (array('notenum','pokenum','addfriendnum','mtaginvitenum','eventinvitenum','myinvitenum') as $value) {
                $space['allnotenum'] = $space['allnotenum'] + $space[$value];
            }
            if($space['self']) {
                $_SGLOBAL['member'] = $space;
            }
        }
        $_SGLOBAL[$var] = $space;
    }
    return $_SGLOBAL[$var];
}

// URL组装 支持不同模式和路�?2010-2-5 更新
function U($url, $params = false, $redirect = false, $suffix = true)
{
    // 普�?模式
    if (false === strpos($url, '/')) {
        $url .='//';
    }

    // 填充默认参数
    $urls = explode('/',$url);
    $app  = ($urls[0]) ? $urls[0] : APP_NAME;
    $mod  = ($urls[1]) ? $urls[1] : 'Index';
    $act  = ($urls[2]) ? $urls[2] : 'index';

    // 组合默认路径
    $site_url = SITE_URL.'/index.php?app='.$app.'&mod='.$mod.'&act='.$act;

    // 填充附加参数
    if ($params) {
        if (is_array($params)) {
            $params = http_build_query($params);
            $params = urldecode($params);
        }
        $params = str_replace('&amp;', '&', $params);
        $site_url .= '&' . $params;
    }

    // �?��路由和Rewrite
    $_config = getPublicConfig();
    if ($_config['URL_ROUTER_ON']) {
        // 载入路由
        static $router_ruler = array();
        if ( empty($router_ruler) ) {
            $router_ruler = include SITE_ROOT . '/router.inc.php';
            $router_ruler = $router_ruler['router'];
        }
        $router_key   = $app . '/' . ucfirst($mod) . '/' . $act;

        //路由命中
        if (isset($router_ruler[$router_key])) {
            //填充路由参数
            $site_url = SITE_URL . '/' . $router_ruler[$router_key];

            //填充附加参数
            if ($params) {
                // 解析替换URL中的参数
                parse_str($params, $r);
                foreach ($r as $k => $v) {
                    if (strpos($site_url, '['.$k.']'))
                        $site_url = str_replace('['.$k.']', $v, $site_url);
                    else
                        $lr[$k]	= $v;
                }

                // 填充剩余参数
                if (is_array($lr) && count($lr) > 0)
                    $site_url .= '?' . http_build_query($lr);
            }
            // 去除URL中无替换的参�?
            $site_url = preg_replace('/\/\[(.+?)\]/i', '', $site_url);
        }
    }

    // 输出地址或跳�?
    if ($redirect)
        redirect($site_url);
    else
        return $site_url;
}

//产生form防伪�?
function formhash() {
    global $_MY_GLOBAL, $_SITE_CONFIG;

    if(empty($_MY_GLOBAL['formhash'])) {
        $hashadd = defined('IN_MYOP_ADMIN') ? 'Only For UCenter Home AdminCP' : '';
        $_MY_GLOBAL['formhash'] = substr(md5(substr($_MY_GLOBAL['timestamp'], 0, -7).'|'.$_SITE_CONFIG['uid'].'|'.md5($_SITE_CONFIG['sitekey']).'|'.$hashadd), 8, 8);
    }
    return $_MY_GLOBAL['formhash'];
}

//判断提交是否正确
function submitcheck($var) {
    if(!empty($_POST[$var]) && $_SERVER['REQUEST_METHOD'] == 'POST') {
        if((empty($_SERVER['HTTP_REFERER']) || preg_replace("/https?:\/\/([^\:\/]+).*/i", "\\1", $_SERVER['HTTP_REFERER']) == preg_replace("/([^\:]+).*/", "\\1", $_SERVER['HTTP_HOST'])) && $_POST['formhash'] == formhash()) {
            return true;
        } else {
            exit('Invalid Submit.');
        }
    } else {
        return false;
    }
}

//浏览器友好的变量输出
function dump($var, $echo=true,$label=null, $strict=true) {
    $label = ($label===null) ? '' : rtrim($label) . ' ';
    if(!$strict) {
        if (ini_get('html_errors')) {
            $output = print_r($var, true);
            $output = '<pre style="text-align:left">'.$label.htmlspecialchars($output,ENT_QUOTES).'</pre>';
        } else {
            $output = $label . " : " . print_r($var, true);
        }
    }else {
        ob_start();
        var_dump($var);
        $output = ob_get_clean();
        if(!extension_loaded('xdebug')) {
            $output = preg_replace("/\]\=\>\n(\s+)/m", "] => ", $output);
            $output = '<pre style="text-align:left">'. $label. htmlspecialchars($output, ENT_QUOTES). '</pre>';
        }
    }
    if ($echo) {
        echo($output);
        return null;
    }else
        return $output;
}

/**
 * 去一个二维数组中的每个数组的固定的键知道的�?来形成一个新的一维数�?
 * @param $pArray �?��二维数组
 * @param $pKey 数组的键的名�?
 * @return 返回新的�?��数组
 */
function getSubByKey($pArray, $pKey="", $pCondition=""){
    $result = array();
    foreach($pArray as $temp_array){
        if(is_object($temp_array)){
            $temp_array = (array) $temp_array;
        }
        if((""!=$pCondition && $temp_array[$pCondition[0]]==$pCondition[1]) || ""==$pCondition) {
            $result[] = (""==$pKey) ? $temp_array : isset($temp_array[$pKey]) ? $temp_array[$pKey] : "";
        }
    }
    return $result;
}

// URL重定�?
function redirect($url,$time=0,$msg='') {
    //多行URL地址支持
    $url = str_replace(array("\n", "\r"), '', $url);
    if(empty($msg))
        $msg    =   "系统将在{$time}秒之后自动跳转到{$url}�?;
    if (!headers_sent()) {
        // redirect
        if(0===$time) {
            header("Location: ".$url);
        }else {
            header("refresh:{$time};url={$url}");
            echo($msg);
        }
        exit();
    }else {
        $str    = "<meta http-equiv='Refresh' content='{$time};URL={$url}'>";
        if($time!=0)
            $str   .=   $msg;
        exit($str);
    }
}

/**
 +----------------------------------------------------------
 * Cookie 设置、获取�?清除 (支持数组或对象直接设�? 2009-07-9
 +----------------------------------------------------------
 * 1 获取cookie: cookie('name')
 * 2 清空当前设置前缀的所有cookie: cookie(null)
 * 3 删除指定前缀�?��cookie: cookie(null,'think_') | 注：前缀将不区分大小�?
 * 4 设置cookie: cookie('name','value') | 指定保存时间: cookie('name','value',3600)
 * 5 删除cookie: cookie('name',null)
 +----------------------------------------------------------
 * $option 可用设置prefix,expire,path,domain
 * 支持数组形式:cookie('name','value',array('expire'=>1,'prefix'=>'think_'))
 * 支持query形式字符�?cookie('name','value','prefix=tp_&expire=10000')
 * 2010-1-17 去掉自动序列化操作，兼容其它语言程序�?
 */
function cookie($name,$value='',$option=null) {
    // 默认设置
    $config = array(
        'prefix' => 'TS_', 		// cookie 名称前缀
        'expire' => 24*3600, 	// cookie 保存时间
        'path'   => '/',   		// cookie 保存路径
        'domain' => '', 		// cookie 有效域名
    );

    // 参数设置(会覆盖黙认设�?
    if (!empty($option)) {
        if (is_numeric($option)) {
            $option = array('expire'=>$option);
        }else if( is_string($option) ) {
            parse_str($option,$option);
        }
        $config	=	array_merge($config,array_change_key_case($option));
    }

    // 清除指定前缀的所有cookie
    if (is_null($name)) {
       if (empty($_COOKIE)) return;
       // 要删除的cookie前缀，不指定则删除config设置的指定前�?
       $prefix = empty($value)? $config['prefix'] : $value;
       if (!empty($prefix))// 如果前缀为空字符串将不作处理直接返回
       {
           foreach($_COOKIE as $key=>$val) {
               if (0 === stripos($key,$prefix)){
                    setcookie($_COOKIE[$key],'',time()-3600,$config['path'],$config['domain']);
                    unset($_COOKIE[$key]);
               }
           }
       }
       return;
    }
    $name = $config['prefix'].$name;

    if (''===$value){
        //return isset($_COOKIE[$name]) ? unserialize($_COOKIE[$name]) : null;// 获取指定Cookie
        return isset($_COOKIE[$name]) ? ($_COOKIE[$name]) : null;// 获取指定Cookie
    }else {
        if (is_null($value)) {
            setcookie($name,'',time()-3600,$config['path'],$config['domain']);
            unset($_COOKIE[$name]);// 删除指定cookie
        }else {
            // 设置cookie
            $expire = !empty($config['expire'])? time()+ intval($config['expire']):0;
            //setcookie($name,serialize($value),$expire,$config['path'],$config['domain']);
            setcookie($name,($value),$expire,$config['path'],$config['domain']);
            //$_COOKIE[$name] = ($value);
        }
    }
}

function pkcs5_pad ($text, $blocksize) {
    $pad = $blocksize - (strlen($text) % $blocksize);
    return $text . str_repeat(chr($pad), $pad);
}

function pkcs5_unpad($text) {
    $pad = ord($text{strlen($text)-1});
    if ($pad > strlen($text))
        return false;
    if (strspn($text, chr($pad), strlen($text) - $pad) != $pad)
        return false;
    return substr($text, 0, -1 * $pad);
}


//获取用户头像
function getUserFace($uid,$size='m'){
    $size = ($size)?$size:'m';
    if($size=='m'){
        $type = 'middle';
    }elseif ($size=='s'){
        $type = 'small';
    }else{
        $type = 'big';
    }
    $apiImg=doQuery("select profileImageUrl from ai_others where uid='".$uid."'");
    if($apiImg){
        $userface=$apiImg[0]['profileImageUrl'];
        return $userface;
    }
    $userface = SITE_PATH.'/data/uploads/avatar/'.$uid.'/'.$type.'.jpg';
    if(is_file($userface)){
        return SITE_URL.'/data/uploads/avatar/'.$uid.'/'.$type.'.jpg';
    }else{
        return THEME_URL."/images/user_pic_$type.gif";
    }
}

//获取关注�?
function getUserFollow($uid){
    $db_prefix	= getDbPrefix();
    $res		= doQuery("SELECT COUNT(*) AS count FROM {$db_prefix}weibo_follow WHERE `uid` = $uid AND `type` = 0");
    $count['following']	= $res[0]['count'];
    $res		= doQuery("SELECT COUNT(*) AS count FROM {$db_prefix}weibo_follow WHERE `fid` = $uid AND `type` = 0");
    $count['follower']	= $res[0]['count'];
    return $count;
}

//获取微博条数
function getWeiboCount($uid){
    $db_prefix	= getDbPrefix();
    $count		= doQuery("SELECT COUNT(*) AS count FROM {$db_prefix}weibo WHERE `uid` = $uid");
    return $count[0]['count'];
}

function getDefaultApp($order = 'displayorder ASC, appid ASC') {
    $db_prefix	= getDbPrefix();
    return doQuery("SELECT * FROM {$db_prefix}myop_myapp WHERE `flag` = 1 ORDER BY $order");
}

function getMyopMenuNum($uid) {
    $db_prefix	= getDbPrefix();
    $menu_num	= doQuery("SELECT `myop_menu_num` FROM {$db_prefix}user WHERE `uid` = $uid");
    return $menu_num[0]['myop_menu_num'];
}

function getInstalledByUser($uid, $limit = '', $order = 'displayorder ASC, appid ASC') {
    $db_prefix	= getDbPrefix();
    $sql		= "SELECT * FROM {$db_prefix}myop_userapp WHERE `uid` = $uid ORDER BY $order ";
    if ( !empty($limit) ) {
        $sql  .= "LIMIT 0,$limit";
    }
    return doQuery($sql);
}

function bindstate($uid,$type) {
    $db_prefix = getDbPrefix();
    $sql = "SELECT COUNT(*) AS count FROM {$db_prefix}login WHERE `uid` = '$uid' AND `type` = '$type'";
    $res = doQuery($sql);
    return $res[0]['count'];
}

function getUserGroupIcon($uid){
    $prefix = getDbPrefix();
    $sql = "SELECT `icon`,`title` FROM {$prefix}user_group WHERE `user_group_id` IN (SELECT `user_group_id` FROM {$prefix}user_group_link WHERE `uid` = $uid)";
    $groupIcon = doQuery($sql);

    if($groupIcon){
        foreach ($groupIcon as $v){
            if($v['icon']){
                $html.="<img class='ts_icon' src=".THEME_URL."/images/".$v['icon']." title=".$v['title'].">";
            }
        }
        return $html;
    }else{
        return '';
    }
}

function getUserVerifiedIcon($uid)
{
    $prefix = getDbPrefix();
    $sql = "SELECT `info` FROM {$prefix}user_verified WHERE uid={$uid} AND verified='1'";
    $verified = doQuery($sql);
    if ($verified[0]) {
        $html = "<img class='ts_icon' src=" . THEME_URL."/images/v_01.gif title=" . $verified[0]['info'] . ">";
    }
    return $html;
}

function getUserApp($uid) {
    static $_user_app = array();
    if ( !empty($_user_app) ) {
        return $_user_app;
    }

    // 默认应用 + 用户安装的可选应�?
    $prefix = getDbPrefix();
    $sql = "SELECT a.* FROM  {$prefix}app AS a LEFT JOIN {$prefix}user_app AS u ON a.app_id = u.app_id " .
           "WHERE a.status = '1' OR ( a.status = '2' AND u.uid = '$uid' ) GROUP BY `app_id` " .
           "ORDER BY a.status ASC,u.display_order ASC,a.display_order ASC,a.app_id ASC";
    $res = doQuery($sql);

    $user_app = array();
    foreach ($res as $k => $v) {
        $v['app_entry']	  = U($v['app_name'].'/'.$v['app_entry']);
        $v['admin_entry']   = U($v['app_name'].'/'.$v['admin_entry']);
        $v['sidebar_entry'] = U($v['app_name'].'/'.$v['sidebar_entry']);

        if ($v['status']==1)
            $user_app['local_default_app'][] = $v;
        else
            $user_app['local_app'][] = $v;
    }

    // 漫游应用
    global $_SITE_CONFIG;
    if ($_SITE_CONFIG['my_status']) {
        $default = getDefaultApp();
        $myopapp = getInstalledByUser($_SITE_CONFIG['uid']);
        $ids = array();
        foreach ($myopapp as $v) {
            if (in_array($v['appid'], $ids))
                continue ;
            $ids[] = $v['appid'];
            $user_app['myop_app'][] = array('app_id'		=> $v['appid'],
                                            'app_alias'		=> $v['appname'],
                                            'display_order' => $v['displayorder']);
        }
        foreach ($default as $v) {
            if (in_array($v['appid'], $ids))
                continue ;
            $ids[] = $v['appid'];
            $user_app['myop_default_app'][] = array('app_id'		=> $v['appid'],
                                                    'app_alias'		=> $v['appname'],
                                                    'display_order' => $v['displayorder']);
        }
    }
    $_user_app = $user_app;
    return $_user_app;
}

/**
 * �?��给定用户是否拥有给定节点的权�?
 *
 * @param int    $uid
 * @param string $node
 * @param bool   $has_admin_popedom 当没有设置admin节点权限时的是否默认拥有admin权限 ( true:有权�?false:没有权限 )
 */
function hasPopedom($uid, $node, $has_admin_popedom = true) {
    global $_SITE_CONFIG;

    if ( empty($uid) || empty($node) )
        return false;

    // �?��是否为超级管理员
    if ( $uid == $_SITE_CONFIG['userInfo']['uid'] && $_SITE_CONFIG['userInfo']['admin_level'] == '1' )
        return true;

    $node 	= explode('/', $node);
    $app  	= $node[0];
    $mod  	= $node[1];
    $act  	= $node[2];
    unset($node);

    // 获取有权限查看此节点的用户组ID
    $prefix = getDbPrefix();
    $where	= "n.app_name='$app' AND ( ( n.mod_name='$mod' AND ( n.act_name='$act' OR n.act_name='*' ) ) OR n.mod_name='*' )";
    $sql 	= "SELECT p.user_group_id FROM {$prefix}node AS n INNER JOIN {$prefix}user_group_popedom AS p ON n.node_id = p.node_id WHERE $where";
    $gid    = doQuery($sql);
    $gid	= getSubByKey($gid, 'user_group_id');

    if (empty($gid)) {
        return $has_admin_popedom ? true : $app != 'admin';
    }else {
        // �?��用户是否有权�?即：是否在相应的用户�?
        $gid	= implode("','", $gid);
        $sql	= "SELECT * FROM {$prefix}user_group_link WHERE `uid` = '$uid' AND `user_group_id` IN ( '$gid' )";
        $res	= doQuery($sql);
        return !empty($res[0]);
    }
}

function getUserCredit($uid) {
    if( empty($uid) )
        return false;

    $db_preifx = getDbPrefix();
    $credit_type = doQuery("SELECT * FROM {$db_preifx}credit_type ORDER BY id ASC");

    $user_credit_info = doQuery("SELECT * FROM {$db_preifx}credit_user WHERE `uid` = {$uid}");
    $user_credit_info = $user_credit_info[0];

    foreach($credit_type as $v) {
        $user_credit[$v['name']] = array('credit'=>intval($user_credit_info[$v['name']]),'alias'=>$v['alias']);
    }
    return $user_credit;
}