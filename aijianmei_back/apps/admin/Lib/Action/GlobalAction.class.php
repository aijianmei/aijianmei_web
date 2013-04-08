<?php
class GlobalAction extends AdministratorAction {

    private function __isValidRequest($field, $array = 'post') {
        $field = is_array($field) ? $field : explode(',', $field);
        $array = $array == 'post' ? $_POST : $_GET;
        foreach ($field as $v){
            $v = trim($v);
            if ( !isset($array[$v]) || $array[$v] == '' ) return false;
        }
        return true;
    }

    /** ϵͳ���� - վ������ **/

    //վ������
    public function siteopt() {
        $site_opt = model('Xdata')->lget('siteopt');
        if(!$site_opt['site_logo']){
            $site_opt['site_logo']='logo.png';
            $this->assign('site_logo',THEME_URL.'/images/'.$site_opt['site_logo']);
        }
        $this->assign($site_opt);
        require_once ADDON_PATH . '/libs/Io/Dir.class.php';
        $theme_list = new Dir(SITE_PATH.'/public/themes/');
        $expression_list = new Dir(SITE_PATH.'/public/themes/'.$site_opt['site_theme'].'/images/expression/');
        $this->assign('expression_list',$expression_list->toArray());
        $this->assign('theme_list',$theme_list->toArray());

        $this->display();
    }

    //����վ��
    public function doSetSiteOpt() {
        if (empty($_POST)) {
            $this->error('��������');
        }

        //��֤���ֲ���
        if( intval($_POST['max_post_time'])<0 
             || intval($_POST['max_refresh_time'])<0 
             || intval($_POST['max_following'])<0
             || intval($_POST['max_search_time'])<0  
        ){
            $this->error('���ֱ�����ֵ������ڵ���0');
        }
        $_POST['max_post_time'] = intval($_POST['max_post_time']);
        $_POST['max_refresh_time'] = intval($_POST['max_refresh_time']);
        $_POST['max_following'] = intval($_POST['max_following']);
        $_POST['max_search_time'] = intval($_POST['max_search_time']);

        if (intval($_POST['length']) <= 0) {
            $this->error('ȫվ΢���������������Ƶ�ֵ�������0');
        }

        //����LOGO
        if(!empty($_FILES['site_logo']['name'])){
            $logo_options['save_to_db'] = false;
            $logo = X('Xattach')->upload('site_logo',$logo_options);
            if($logo['status']){
                $logofile = UPLOAD_URL.'/'.$logo['info'][0]['savepath'].$logo['info'][0]['savename'];
            }
            $_POST['site_logo'] = $logofile;
        }

        if(!empty($_FILES['banner_logo']['name'])){
            $logo_options['save_to_db'] = false;
            $logo = X('Xattach')->upload('site_logo',$logo_options);
            if($logo['status']){
                $logofile = UPLOAD_URL.'/'.$logo['info'][0]['savepath'].$logo['info'][0]['savename'];
            }
            $_POST['banner_logo'] = $logofile;
        }



        $_POST['site_name']                 = t($_POST['site_name']);
        $_POST['site_slogan']               = t($_POST['site_slogan']);
        $_POST['site_header_keywords']      = t($_POST['site_header_keywords']);
        $_POST['site_header_description']   = t($_POST['site_header_description']);
        $_POST['site_closed']               = intval($_POST['site_closed']);
        $_POST['site_closed_reason']        = t($_POST['site_closed_reason']);
        $_POST['site_icp']                  = t($_POST['site_icp']);
        $_POST['site_verify']               = isset($_POST['site_verify']) ? $_POST['site_verify'] : '';
        $_POST['expression']                = t($_POST['expression']);
        $_LOG['uid'] = $this->mid;
        $_LOG['type'] = '3';
        $data[] = 'ȫ�� - վ������ ';
        $site_opt = model('Xdata')->lget('siteopt');
        $data[] = $site_opt;
        if( $_POST['__hash__'] ) unset( $_POST['__hash__'] );
        $data[] = $_POST;
        $_LOG['data'] = serialize($data);
        $_LOG['ctime'] = time();
        M('AdminLog')->add($_LOG);

        $res = model('Xdata')->lput('siteopt', $_POST);
        if ($res) {
            //������Ҫflushһ��
            model('Expression')->getAllExpression(true);
            $this->assign('jumpUrl', U('admin/Global/siteopt'));
            $this->success('����ɹ�');
        }else {
            $this->error('����ʧ��');
        }
    }

    /** ϵͳ���� - ע������ **/

    public function register() {
        $register = model('Xdata')->lget('register');
        $this->assign($register);
        $invite   = model('Invite')->getSet();
        $this->assign($invite);
        $this->display();
    }

    public function doSetRegisterOpt() {

        $invite_set['invite_set'] = t($_POST['invite_set']);

        $invite   = model('Invite')->getSet();

        $site_opt = model('Xdata')->lget('register');

        unset($_POST['invite_set']);
        if ( model('Xdata')->lput('register', $_POST) && model('Xdata')->lput('inviteset', $invite_set) ) {
            $this->assign('jumpUrl', U('admin/Global/register'));

            $_LOG['uid'] = $this->mid;
            $_LOG['type'] = '3';
            $data[] = 'ȫ�� - ע������ ';
            $site_opt['invite_set'] = $invite['invite_set'];
            if( $site_opt['__hash__'] ) unset( $site_opt['__hash__'] );
            $data[] = $site_opt;
            $_POST['invite_set'] = $invite_set['invite_set'];
            if( $_POST['__hash__'] ) unset( $_POST['__hash__'] );
            $data[] = $_POST;
            $_LOG['data'] = serialize($data);
            $_LOG['ctime'] = time();
            M('AdminLog')->add($_LOG);

            $this->success('����ɹ�');
        }else {
            $this->error('����ʧ��');
        }
    }

    /** ϵͳ���� - �������� **/
    //�����������
    public function creditType(){
        $creditType = M('credit_type')->order('id ASC')->findAll();
        $this->assign('creditType',$creditType);
        $this->display();
    }
    public function editCreditType(){
        $type   = $_GET['type'];
        if($cid = intval($_GET['cid'])){
            $creditType = M('credit_type')->where("`id`=$cid")->find();//�������
            if (!$creditType) $this->error('�޴˻�������');
            $this->assign('creditType',$creditType);
        }

        $this->assign('type', $type);
        $this->display();
    }
    public function doAddCreditType(){
        // if ( !$this->__isValidRequest('name') ) $this->error('���ݲ�����');
        $name = h(t($_POST['name']));
        $alias=h(t($_POST['alias']));
        if(empty($name) ){
            $this->error('���Ʋ���Ϊ��');
        }
        if(empty($alias) ){
            $this->error('��������Ϊ��');
        }

        $_POST = array_map('t',$_POST);
        $_POST = array_map('h',$_POST);

        $_LOG['uid'] = $this->mid;
        $_LOG['type'] = '1';
        $data[] = 'ȫ�� - ��������  - ��������';
        if( $_POST['__hash__'] )unset( $_POST['__hash__'] );
        $data[] = $_POST;
        $_LOG['data'] = serialize($data);
        $_LOG['ctime'] = time();
        M('AdminLog')->add($_LOG);

        $res = M('credit_type')->add($_POST);
        if ($res) {
            $db_prefix  = C('DB_PREFIX');
            $model = M('');
            $setting = $model->query("ALTER TABLE {$db_prefix}credit_setting ADD {$_POST['name']} INT(11) DEFAULT 0;");
            $user    = $model->query("ALTER TABLE {$db_prefix}credit_user ADD {$_POST['name']} INT(11) DEFAULT 0;");
            // �建��
            F('_service_credit_type', null);
            $this->assign('jumpUrl', U('admin/Global/creditType'));
            $this->success('����ɹ�');
        }else {
            $this->error('����ʧ��');
        }
    }
    public function doEditCreditType(){
        // if ( !$this->__isValidRequest('id,name') ) $this->error('���ݲ�����');
        $name = h(t($_POST['name']));
        $alias=h(t($_POST['alias']));
        if(empty($name) ){
            $this->error('���Ʋ���Ϊ��');
        }
        if(empty($alias) ){
            $this->error('��������Ϊ��');
        }
        $_POST = array_map('t',$_POST);
        $_POST = array_map('h',$_POST);
        $creditTypeDao = M('credit_type');
        //��ȡԭ�ֶ���
        $oldName = $creditTypeDao->find($_POST['id']);
        //�޸��ֶ���
        $res = $creditTypeDao->save($_POST);

        $_LOG['uid'] = $this->mid;
        $_LOG['type'] = '3';
        $data[] = 'ȫ�� - �������� - �������� ';
        $data[] = $oldName;
        if( $_POST['__hash__'] )unset( $_POST['__hash__'] );
        $data[] = $_POST;
        $_LOG['data'] = serialize($data);
        $_LOG['ctime'] = time();
        M('AdminLog')->add($_LOG);

        if ($res) {
            $db_prefix  = C('DB_PREFIX');
            $model = M('');
            $setting = $model->query("ALTER TABLE {$db_prefix}credit_setting CHANGE {$oldName['name']} {$_POST['name']} INT(11);");
            $user    = $model->query("ALTER TABLE {$db_prefix}credit_user CHANGE {$oldName['name']} {$_POST['name']} INT(11);");
            // �建��
            F('_service_credit_type', null);
            $this->assign('jumpUrl', U('admin/Global/creditType'));
            $this->success('����ɹ�');
        }else {
            $this->error('����ʧ��');
        }
    }
    public function doDeleteCreditType(){
        $ids = t($_POST['ids']);
        $ids = explode(',', $ids);
        if ( empty($ids) ) {echo 0; return ;}

        $map['id'] = array('in', $ids);
        $creditTypeDao = M('credit_type');
        //��ȡ�ֶ���
        $typeName = $creditTypeDao->where($map)->findAll();

        $_LOG['uid'] = $this->mid;
        $_LOG['type'] = '2';
        $data[] = 'ȫ�� - �������� - �������� ';
        $data[] = $typeName;
        $_LOG['data'] = serialize($data);
        $_LOG['ctime'] = time();
        M('AdminLog')->add($_LOG);

        //���type��Ϣ�Ͷ�Ӧ�ֶ�
        $res = M('credit_type')->where($map)->delete();
        if ($res){
            $db_prefix  = C('DB_PREFIX');
            $model = M('');
            foreach($typeName as $v){
                $setting = $model->query("ALTER TABLE {$db_prefix}credit_setting DROP {$v['name']};");
                $user    = $model->query("ALTER TABLE {$db_prefix}credit_user DROP {$v['name']};");
            }
            // �建��
            F('_service_credit_type', null);
            echo 1;
        }else{
            echo 0;
        }
    }
    //���ֹ�������
    public function credit() {
        $list = M('credit_setting')->order('type ASC')->findPage(30);
        $creditType = M('credit_type')->order('id ASC')->findAll();
        $this->assign('creditType',$creditType);
        $this->assign($list);
        $this->display();
    }
    public function addCredit() {
        $creditType = M('credit_type')->order('id ASC')->findAll();//�������
        $this->assign('creditType',$creditType);
        $this->assign('type','add');
        $this->display('editCredit');
    }
    public function doAddCredit() {
        $name = trim($_POST['name']);
        if($name == "" && $_POST['name'] != ""){
            $this->error('���Ʋ���Ϊ�ո�');
        }
        if ( !$this->__isValidRequest('name') ) $this->error('���ݲ�����');

        $_POST = array_map('t',$_POST);
        $_POST = array_map('h',$_POST);

        $creditType = M('credit_type')->order('id ASC')->findAll();
        foreach($creditType as $v){
            if(!is_numeric($_POST[$v['name']])){
                $this->error($v['alias'].'��ֵ����Ϊ���֣�');
            }
        }

        $_LOG['uid'] = $this->mid;
        $_LOG['type'] = '1';
        $data[] = 'ȫ�� - �������� - ���ֹ��� ';
        if( $_POST['__hash__'] )unset( $_POST['__hash__'] );
        $data[] = $_POST;
        $_LOG['data'] = serialize($data);
        $_LOG['ctime'] = time();
        M('AdminLog')->add($_LOG);

        $res = M('credit_setting')->add($_POST);
        if ($res) {
            // �建��
            F('_service_credit_rules', null);
            $this->assign('jumpUrl', U('admin/Global/credit'));
            $this->success('����ɹ�');
        }else {
            $this->error('����ʧ��');
        }
    }
    public function editCredit() {
        $cid    = intval($_GET['cid']);
        $credit = M('credit_setting')->where("`id`=$cid")->find();
        if (!$credit) $this->error('�޴˻��ֹ���');

        $creditType = M('credit_type')->order('id ASC')->findAll();//�������
        $this->assign('creditType',$creditType);

        $this->assign('credit', $credit);
        $this->assign('type', 'edit');
        $this->display();
    }
    public function doEditCredit() {
        $name = trim($_POST['name']);
        if($name == "" && $_POST['name'] != ""){
            $this->error('���Ʋ���Ϊ�ո�');
        }
        if ( !$this->__isValidRequest('id,name') ) $this->error('���ݲ�����');

        $_POST = array_map('t',$_POST);
        $_POST = array_map('h',$_POST);

        $creditType = M('credit_type')->order('id ASC')->findAll();
        foreach($creditType as $v){
            if(!is_numeric($_POST[$v['name']])){
                $this->error($v['alias'].'��ֵ����Ϊ���֣�');
            }
        }

        $_LOG['uid'] = $this->mid;
        $_LOG['type'] = '3';
        $data[] = 'ȫ�� - �������� - ���ֹ��� ';
        $credit_info = M('credit_setting')->where('id='.$_POST['id'])->find();
        $data[] = $credit_info;
        $_POST['info'] = $credit_info['info'];
        if( $_POST['__hash__'] )unset( $_POST['__hash__'] );
        $data[] = $_POST;
        $_LOG['data'] = serialize($data);
        $_LOG['ctime'] = time();
        M('AdminLog')->add($_LOG);

        $res = M('credit_setting')->save($_POST);
        if ($res) {
            // �建��
            F('_service_credit_rules', null);
            $this->assign('jumpUrl', U('admin/Global/credit'));
            $this->success('����ɹ�');
        }else {
            $this->error('����ʧ��');
        }
    }
    public function doDeleteCredit() {
        $ids = t($_POST['ids']);
        $ids = explode(',', $ids);
        if ( empty($ids) ) {echo 0; return ;}

        $map['id'] = array('in', $ids);

        $_LOG['uid'] = $this->mid;
        $_LOG['type'] = '2';
        $data[] = 'ȫ�� - �������� - ���ֹ��� ';
        $data[] = M('credit_setting')->where('id='.$_POST['id'])->find();
        $_LOG['data'] = serialize($data);
        $_LOG['ctime'] = time();
        M('AdminLog')->add($_LOG);

        $res = M('credit_setting')->where($map)->delete();
        if ($res) {
            // �建��
            F('_service_credit_rules', null);
            echo 1;
        } else {
            echo 0;
        }
    }
    //�����û���������
    public function creditUser(){
        $creditType = M('credit_type')->order('id ASC')->findAll();
        $this->assign('creditType',$creditType);
        $this->assign('grounlist',model('UserGroup')->getUserGroupByMap('','user_group_id,title'));
        $this->display();
    }
    public function doCreditUser(){
        set_time_limit(0);
        //��ѯ�û�ID
        $_POST['uId'] && $map['uid'] = array('in',explode(',',t($_POST['uId'])));
        $_POST['gId']!='all' && $map['admin_level'] = intval($_POST['gId']);
        $_POST['active']!='all' && $map['is_active'] = intval($_POST['active']);
        $user = D('User','home')->where($map)->field('uid')->findAll();
        if($user == false){
            $this->error('��ѯʧ�ܣ�û��������������');
        }
        //��װ���ֹ���
        $setCredit = X('Credit');
        $creditType = $setCredit->getCreditType();
        foreach($creditType as $v){
            $action[$v['name']] = intval($_POST[$v['name']]);
        }



        if($_POST['action'] == 'set'){//�����޸�Ϊ
            foreach($user as $v){
                $setCredit->setUserCredit($v['uid'],$action,'reset');
                if($setCredit->getInfo()===false)$this->error('����ʧ��');
            }
        }else{//��������
            foreach($user as $v){
                $setCredit->setUserCredit($v['uid'],$action);
                if($setCredit->getInfo()===false)$this->error('����ʧ��');
            }
        }

        $this->assign('jumpUrl', U('admin/Global/creditUser'));

        $_LOG['uid'] = $this->mid;
        $_LOG['type'] = '1';
        if( $_POST['action'] == 'set' ){
            $data[] = 'ȫ�� - �������� - �����û����� - �����޸Ĳ��� ';
        }else{
            $data[] = 'ȫ�� - �������� - �����û����� - ������������ ';
        }
        $data['1'] = $action;
        $data['1']['uid'] = $_POST['uId'];
        $data['1']['gId'] = $_POST['gId'];
        $data['1']['active'] = $_POST['active'];
        $data['1']['action'] = $_POST['action'];
        $_LOG['data'] = serialize($data);
        $_LOG['ctime'] = time();
        M('AdminLog')->add($_LOG);

        $this->success('����ɹ�');
    }

    /** ϵͳ���� - �������� **/

    //��������
    function invite(){
        $data = model('Invite')->getSet();
        $this->assign( $data );
        $this->display();
    }

    //�����뷢��
    function invitecode(){
        $num = intval($_POST['send_type_num']);
        $user = t($_POST['send_type_user']);

        if($_POST['send_type']==1){
            $user = M('user')->where('is_init=1 AND is_active=1')->field('uid')->findall();
            foreach ($user as $key=>$value){
                model('Invite')->sendcode($value['uid'],$num);
            }
        }else{
            $user = explode(',', $user);
            foreach ($user as $k=>$v){
                model('Invite')->sendcode($v,$num);
                x('Notify')->sendIn($v,'admin_sendinvitecode',array('num'=>$num)); //֪ͨ����
            }
        }

        if( $_POST ){
            $_LOG['uid'] = $this->mid;
            $_LOG['type'] = '1';
            $data[] = 'ȫ�� - �������� ';
            if( $_POST['__hash__'] )unset( $_POST['__hash__'] );
            $data[] = $_POST;
            $_LOG['data'] = serialize($data);
            $_LOG['ctime'] = time();
            M('AdminLog')->add($_LOG);
        }


        $this->success('�����ɹ�');
    }

    /** ϵͳ���� - �������� **/

    public function announcement() {
        if ($_POST) {
            $_LOG['uid'] = $this->mid;
            $_LOG['type'] = '3';
            $data[] = 'ȫ�� - �������� ';
            $data[] = model('Xdata')->lget('announcement');
            if( $_POST['__hash__'] )unset( $_POST['__hash__'] );
            $data[] = $_POST;
            $_LOG['data'] = serialize($data);
            $_LOG['ctime'] = time();
            M('AdminLog')->add($_LOG);

            unset($data);
            $data['is_open'] = intval($_POST['is_open']);
            $data['content'] = t($_POST['content'], false, ENT_QUOTES);
            model('Xdata')->lput('announcement', $data);

            F('_home_user_action_announcement', null);

            $this->assign('jumpUrl', U('admin/Global/announcement'));
            $this->success('����ɹ�');
        }else {
            $announcement = model('Xdata')->lget('announcement');
            $this->assign($announcement);
            $this->display();
        }
    }

    /** ϵͳ���� - �ʼ����� **/

    public function email(){
        if($_POST){

            $_LOG['uid'] = $this->mid;
            $_LOG['type'] = '3';
            $data[] = 'ȫ�� - �ʼ����� ';
            $data[] = model('Xdata')->lget('email');
            if( $_POST['__hash__'] )unset( $_POST['__hash__'] );
            $data[] = $_POST;
            $_LOG['data'] = serialize($data);
            $_LOG['ctime'] = time();
            M('AdminLog')->add($_LOG);

            unset($_POST['__hash__']);
            model('Xdata')->lput('email',$_POST);
            $this->assign('jumpUrl', U('admin/Global/email'));
            $this->success('����ɹ�');
        }else{
            $email = model('Xdata')->lget('email');
            $this->assign($email);
            $this->display();
        }
    }

    /** ϵͳ���� - �������� **/

    public function attachConfig() {
        if ($_POST) {

            $_LOG['uid'] = $this->mid;
            $_LOG['type'] = '3';
            $data[] = 'ȫ�� - �������� ';
            $data[] = model('Xdata')->lget('attach');
            if( $_POST['__hash__'] )unset( $_POST['__hash__'] );
            $data[] = $_POST;
            $_LOG['data'] = serialize($data);
            $_LOG['ctime'] = time();
            M('AdminLog')->add($_LOG);

            $_POST['attach_path_rule']       = t($_POST['attach_path_rule']);
            $_POST['attach_max_size']        = floatval($_POST['attach_max_size']);
            $_POST['attach_allow_extension'] = t($_POST['attach_allow_extension']);
            $this->assign('jumpUrl', U('admin/Global/attachConfig'));
            if ( model('Xdata')->lput('attach', $_POST) )
                $this->success('����ɹ�');
            else
                $this->error('����ʧ��');

        }else {
            $data = model('Xdata')->lget('attach');
            $this->assign($data);
            $this->display();
        }
    }

    /** ϵͳ���� - �������� **/

    public function document() {
        $data = M('document')->order('`display_order` ASC,`document_id` ASC')->findAll();
        $this->assign('data', $data);
        $this->display();
    }

    public function addDocument() {
        $this->assign('type', 'add');
        $this->display('editDocument');
    }

    public function editDocument() {
        $map['document_id'] = intval($_GET['id']);
        $document = M('document')->where($map)->find();
        if ( empty($document) )
            $this->error('�����²�����');
        $this->assign($document);

        $this->assign('type', 'edit');
        $this->display();
    }

    public function doEditDocument()
    {
        if (($_POST['document_id'] = intval($_POST['document_id'])) <= 0)
            unset($_POST['document_id']);

        // ��ʽ������
        $_POST['title']         = H(t($_POST['title']));
        $_POST['is_active']     = intval($_POST['is_active']);
        $_POST['is_on_footer']  = intval($_POST['is_on_footer']);
        $_POST['last_editor_id']= $this->mid;
        $_POST['mtime']         = time();
        if (preg_match('/^\s*((?:https?|ftp):\/\/(?:www\.)?(?:[a-zA-Z0-9][a-zA-Z0-9\-]*\.)?[a-zA-Z0-9][a-zA-Z0-9\-]*(?:\.[a-zA-Z]+)+(?:\:[0-9]*)?(?:\/[^\x{2e80}-\x{9fff}\s<\'\"��������]*)?)\s*$/u', strip_tags(html_entity_decode($_POST['content'], ENT_QUOTES, 'UTF-8')), $url)
            || preg_match('/^\s*((?:mailto):\/\/[a-zA-Z0-9_]+@[a-zA-Z0-9][a-zA-Z0-9\.]*[a-zA-Z0-9])\s*$/u', strip_tags(html_entity_decode($_POST['content'], ENT_QUOTES, 'UTF-8')), $url)) {
            $_POST['content'] = h($url[1]);
        } else {
            //$_POST['content'] = t(h($_POST['content']));
            $_POST['content'] = $_POST['content'];
        }
        if (!isset($_POST['document_id'])) {
            // �½�����
            $_POST['author_id'] = $this->mid;
            $_POST['ctime']     = $_POST['mtime'];
        }

        // ���ݼ��
        if (empty($_POST['title']))
            $this->error('���ⲻ��Ϊ��');

        $_LOG['uid'] = $this->mid;
        $_LOG['type'] = isset($_POST['document_id']) ? '3' : '1';
        $data[] = 'ȫ�� - �������� ';
        isset($_POST['document_id']) && $data[] =  model('Xdata')->lget('platform');
        if( $_POST['__hash__'] ) unset( $_POST['__hash__'] );
        $data[] = $_POST;
        $_LOG['data'] = serialize($data);
        $_LOG['ctime'] = time();
        M('AdminLog')->add($_LOG);

        // �ύ
        $res = isset($_POST['document_id']) ? M('document')->save($_POST) : M('document')->add($_POST);

        if ($res) {
            // ������
            F('_action_footer_document', null);
            if ( isset($_POST['document_id']) ) {
                $this->assign('jumpUrl', U('admin/Global/document'));
            } else {
                // Ϊ���򷽱�, �½���Ϻ�, ��display_order����Ϊad_id
                M('document')->where("`document_id`=$res")->setField('display_order', $res);
                $this->assign('jumpUrl', U('admin/Global/addDocument'));
            }
            $this->success('����ɹ�');
        } else {
            $this->error('����ʧ��');
        }
    }

    public function doDeleteDocument()
    {
        if (empty($_POST['ids'])) {
            echo 0;
            exit ;
        }

        $_LOG['uid'] = $this->mid;
        $_LOG['type'] = '2';
        $data[] = 'ȫ�� - �������� ';
        $data[] = model('Xdata')->lget('platform');
        if( $_POST['__hash__'] )unset( $_POST['__hash__'] );
        $data[] = $_POST;
        $_LOG['data'] = serialize($data);
        $_LOG['ctime'] = time();
        M('AdminLog')->add($_LOG);

        $map['document_id'] = array('in', t($_POST['ids']));
        echo M('document')->where($map)->delete() ? '1' : '0';
        // ������
        F('_action_footer_document', null);
    }

    public function doDocumentOrder() {
        $_POST['document_id']   = intval($_POST['document_id']);
        $_POST['baseid']        = intval($_POST['baseid']);
        if ( $_POST['document_id'] <= 0 || $_POST['baseid'] <= 0 ) {
            echo 0;
            exit;
        }

        // ��ȡ����
        $map['document_id'] = array('in', array($_POST['document_id'], $_POST['baseid']));
        $res = M('document')->where($map)->field('document_id,display_order')->findAll();
        if ( count($res) < 2 ) {
            echo 0;
            exit;
        }

        //תΪ�����Ϊarray('id'=>'order')�ĸ�ʽ
        foreach($res as $v) {
            $order[$v['document_id']] = intval($v['display_order']);
        }
        unset($res);

        //����orderֵ
        $res =         M('document')->where('`document_id`=' . $_POST['document_id'])->setField(  'display_order', $order[$_POST['baseid']] );
        $res = $res && M('document')->where('`document_id`=' . $_POST['baseid'])->setField( 'display_order', $order[$_POST['document_id']]  );

        if ($res) {
            // ������
            F('_action_footer_document', null);
            echo 1;
        } else {
            echo 0;
        }
    }

    /** ������� **/
    public function audit(){
        $audit = model('Xdata')->lget('audit');
        $this->assign($audit);
        $this->display();
    }

    /*�ײ���ǩ����*/
    public function buttomTag(){
        $sql = "select * from ai_buttom_tag";
        $tags = M('')->query($sql);
        foreach($tags as $val){     //�õ���������ʽ��array('key'=>array('name'=>$name,'url'=>$url))
            $result[$val['key_name']] = array('name'=>$val['name'],'url'=>$val['url'],'id'=>$val['id']);
        }
        //var_dump($result);
        $this->assign('buttomTag',$result);
        $this->display('bottomTag');
    }
    
    /*���յײ���ǩ��������*/
    public function doButtomTag(){
        //var_dump($_POST);
        if($_POST['actcode']=='delbuttominfo'&&!empty($_POST['delid'])){
            echo $_POST['delid'];exit;
        }
        $v = $_POST;
        //$newTagInfo = array_splice($v,-3,3);
        //����ԭ��¼
        if($v['newTagName']==''){unset($v['newTagName']);}else{$newTagInfo['newTagName']=$v['newTagName'];}
        if($v['newTagUrl']==''){unset($v['newTagUrl']);}else{$newTagInfo['newTagUrl']=$v['newTagUrl'];}
        if($v['newTag']==''){unset($v['newTag']);}else{$newTagInfo['newTag']=$v['newTag'];}
        foreach($v as $key=>$value){
            if(!empty($value[0])&&!empty($value[1])){
                //$sql=null;
                $sql = "update ai_buttom_tag set name='".$value[0]."',url='".$value[1]."' where id='".$key."'";
                $res = M('')->query($sql);
            }
        }
        //������¼
        if(($_POST['newTag']!=""||$_P['newTagName'])){
            $tagKey = $_POST['newTag'];
            $name = $_POST['newTagName'];
            $url = $_POST['newTagUrl'];
            $insertSql = "insert into ai_buttom_tag(name,url,key_name) values('$name','$url','$tagKey')";
            $result = M('')->query($insertSql);
            if(!empty($result))echo 123;
        }
        $filename="buttomTagInfo.php";
        $fp=fopen($filename,'wb');
        $writeInfoSql="select * from ai_buttom_tag";
        $writeInfoResult = M('')->query($writeInfoSql);
        foreach($writeInfoResult as $val){     //�õ���������ʽ��array('key'=>array('name'=>$name,'url'=>$url))
            $writeInfo[$val['key_name']] = array('name'=>$val['name'],'url'=>$val['url'],'id'=>$val['id']);
        }
        fwrite($fp,"<?php\n\r return '".serialize($writeInfo)."';");
        fclose($fp);
        
        
    }
    
    public function doSaveAudit(){
        if($_POST){
            $_LOG['uid'] = $this->mid;
            $_LOG['type'] = '3';
            $data[] = 'ȫ�� - ������� ';
            $data[] = model('Xdata')->lget('audit', $map);
            if( $_POST['__hash__'] )unset( $_POST['__hash__'] );
            $data[] = $_POST;
            $_LOG['data'] = serialize($data);
            $_LOG['ctime'] = time();
            M('AdminLog')->add($_LOG);

            model('Xdata')->lput('audit', $_POST);
        }
        $this->assign('jumpUrl', U('admin/Global/audit'));
        $this->success("���óɹ�");
    }

    public function testSendEmail(){
        $service = service('Mail');
        $subject = '����һ������ʼ�';
        $content = '����һ������'.SITE_URL.'�Ĳ����ʼ��������յ�����ʼ������ʼ���������������ȷ��<br />
                    ��������������ʼ������ɣ���ɾ����Ϊ���������Ĳ����ʾǸ��';
        echo ( $info = $service->send_email($_POST['testSendEmailTo'], $subject, $content) )?$info:'1';
    }
}
