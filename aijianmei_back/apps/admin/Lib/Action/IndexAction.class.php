<?php
class IndexAction extends AdministratorAction {
    //后台框架页
    public function index() {
        $this->assign('channel', $this->_getChannel());
        $this->assign('menu',    $this->_getMenu());
        $this->display();
    }

    //后台首页
    public function main() {
        echo '<h2>这里是后台首页</h2>';
        $this->display();
    }

    protected function _getChannel() {
        return array(
            'index'			=>	'首页',
            'global'		=>	'全局',
            'content'		=>	'内容',
            'user'			=>	'用户',
            'apps'			=>	'应用',
            'extension'		=>	'插件',
            'article'       =>  '文章',
        );
    }

    protected function _getMenu() {
        $menu = array();
        //注意顺序！！

        // 后台管理首页
        $menu['index'] 		=   array(
            '首页'			=>	array(
                '首页'		=>	U('admin/Home/statistics'),
                '缓存更新'    =>  SITE_URL . '/cleancache.php?all',
                '系统升级'	 =>	U('admin/Home/update'),
                '数据备份'    =>  U('admin/Tool/backup'),
                'CNZZ统计'   =>  U('admin/Tool/cnzz'),
            ),
        );

        //全局
        $menu['global'] 	=   array(
            '全局配置'		=>  array(
                '站点配置'	=>	U('admin/Global/siteopt'),
                '注册配置'	=>	U('admin/Global/register'),
                '邀请配置'	=>	U('admin/Global/invite'),
                '积分配置'	=>	U('admin/Global/credit'),
                '公告配置'	=>	U('admin/Global/announcement'),
                '邮件配置'	=>	U('admin/Global/email'),
                '附件配置'	=>	U('admin/Global/attachConfig'),
                '文章配置'	=>	U('admin/Global/document'),
                '审核配置'	=>	U('admin/Global/audit'),
                '地区配置'    =>  U('admin/Tool/area'),
                '粉丝榜配置' =>  U('admin/User/follower'),
                '底部标签配置' =>  U('admin/Global/buttomTag')
            ),
        );

        //内容
        $menu['content'] 	=   array(
            '内容管理'		=>  array(                
                '广告管理'	=>	U('admin/Content/ad'),
                '模板管理'	=>	U('admin/Content/template'),
                '附件管理'	=>	U('admin/Content/attach'),
                '评论管理'	=>	U('admin/Content/comment'),
                '私信管理'	=>	U('admin/Content/message'),
                '通知管理'	=>	U('admin/Content/notify'),
                '动态管理'	=>	U('admin/Content/feed'),
                '举报管理'	=>	U('admin/Content/denounce'),
                '管理日志'   =>	U('admin/Content/adminLog'),
                '底部内容管理'        =>      U('admin/Content/footer'),
                '用户反馈管理'	=>	U('admin/Content/feedback'),
            ),
        );

        //用户
        $menu['user']		=	array(
            '用户'			=>	array(
                '用户管理'	=>	U('admin/User/user'),
                '用户组管理'	=>	U('admin/User/userGroup'),
                '资料配置'	=>	U('admin/User/setField'),
                '消息群发'	=>	U('admin/User/message'),
                '邀请统计'    =>  U('admin/Tool/inviteRecord'),
                '登录日志'	=>	U('admin/Login/index'),
            ),
            '权限'			=>	array(
                '节点管理'	=>	U('admin/User/node'),
                '权限管理'	=>	U('admin/User/popedom'),
            ),
        );

        //应用
        $menu['apps'] 		=	array(
            '应用'		=>	array(
                '应用列表'	=>	U('admin/Apps/applist'),
                '应用安装'	=>	U('admin/Apps/install'),
            ),
        );

            $menu['apps']['应用']['漫游平台'] = SITE_URL . '/apps/myop/myop.php?my_suffix=' . urlencode('/appadmin/list');
            $menu['apps']['应用']['微博'] = U('weibo/Admin/index');

            $apps = model('App')->getAdminApp('app_name,app_alias,admin_entry');
            foreach ($apps as $v) {
                $menu['apps']['应用'][$v['app_alias']] = U($v['app_name'].'/'.$v['admin_entry']);
                //$apps_menu[$v['app_alias']] = U($v['app_name'].'/'.$v['admin_entry']);
            }


        $menu['extension']	=	array(
            '插件'			=>	array(
                '插件列表'   =>  U('admin/Addons/index'),
            ),
        );

            $addons = model('Addons')->getAddonsAdmin();
            foreach($addons as $value){
                $menu['extension']['插件'][$value[0]] = U('admin/Addons/admin',array('pluginid' => $value[1]));
            }
        
            
        // 文章
        $menu['article'] = array(
            '文章管理'        => array(
                '添加新文章' => U('admin/Article/add'),
                '浏览'    => U('admin/Article/broswe'),
            ),	
            '分类'     => array(
                '新建分类' => U('admin/Article/addCategory'),
                '所有分类' => U('admin/Article/category'),	
            ),
            '视频管理'        => array(
                '添加视频' => U('admin/Article/addVideo'),
                '所有视频' => U('admin/Article/video'),	
            ),
            '天天锻炼'     => array(
                '添加'    => U('admin/Article/addDaily'),
                '管理'    => U('admin/Article/daily'),	
            ),
            '推荐商品'     => array(
                '添加'    => U('admin/Article/addPromote'),
                '管理'    => U('admin/Article/promote'),	
            ),
            '肌肉增加视频' => array(
                '添加'    => U('admin/Article/addMuscle'),
                '管理'    => U('admin/Article/muscle'),	
            ),
        );


        return $menu;
    }
}
