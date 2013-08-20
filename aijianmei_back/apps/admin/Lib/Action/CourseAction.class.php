<?php
class CourseAction extends AdministratorAction {
	public function actionList() {
		$pg = $_GET ['pg'] ? intval ( $_GET ['pg'] ) : 1;
		$nums = 15;
		$dailycount = M ( 'action_list' )->order ( 'id desc' )->findAll ();
		$from = ($pg - 1) * $nums;
		$sql = "select * from ai_action_list order by id desc limit {$from},{$nums}";
		$daily = $this->getSqlDataAll ( $sql );
		$pageArr = $this->pageHtml ( count ( $dailycount ), $nums, $pg, '/index.php?app=admin&mod=Course&act=actionList&pg=%s' );

		foreach ( $daily as $key => &$value ) {
			$sql = null;
			$sql = "select group_concat( `name` SEPARATOR  ',' ) AS name  from ai_action_category_list where cid in (" . $value ['cid'] . ")";
			$cname = $this->getSqlDataAll ( $sql );
			$daily [$key] ['cidname'] = $cname [0] ['name'];
			$value ['attribute'] = implode ( " , ", unserialize ( $value ['attribute'] ) );
		}
		
		$this->assign ( 'daily', $daily );
		$this->assign ( 'pageArr', $pageArr );
		$this->display ( 'actionList' );
	}
	protected function arrayLinkByKey(&$value, $key, $link) {
		if (! empty ( $value ) || ! empty ( $link ))
			$value = implode ( $link, $value );
	}
	public function generateFontWith() {
		$sql = $category_list = null;
		$sql = "select * from ai_action_category_list order by sequence desc";
		$category_list = $this->getSqlDataAll ( $sql );
		foreach ( $category_list as $key => $value ) {
			$cid = $value ['cid'];
			$sql = "select a.id,a.name from ai_action_list a left join ai_action_category  b  on a.id=b.aid where b.cid=$cid";
			$actionList = $this->getSqlDataAll ( $sql );
			$category_list [$key] ['childList'] = ! empty ( $actionList ) ? $actionList : '';
		}
		$str=null;
		foreach ( $category_list as $key => $value ) {
			$str .=empty($str) ? '{"part" : "' . $value ['name'] . '","lists" : [' : ',{"part" : "' . $value ['name'] . '","lists" : [' ;
			$cstr=null;
			if (! empty ( $value ['childList'] )) {
				foreach ( $value ['childList'] as $k => $v ) {
					$cstr.=empty($cstr)? '"'.$v['name'].'"' : ',"'.$v['name'].'"' ;
				}
			}
			$str .=$cstr.']}';
		}
		$str='['.$str.']';
		file_put_contents('Templates/tool/json/CourseAction.json', $str);
	}
	public function editAction() {
		! empty ( $_GET ['id'] ) ? $id = intval ( $_GET ['id'] ) : die ();
		if ($_POST ['subact'] == 'edit') {
			$data ['id'] = $id;
			! empty ( $_GET ['name'] ) ? $data ['name'] = ( string ) $_POST ['name'] : '';
			
			if (! empty ( $_POST ['attribute_name'] ) && ! empty ( $_POST ['attribute_unit'] )) {
				$tmpname = array ();
				foreach ( $_POST ['attribute_name'] as $key => &$value ) {
					if (! in_array ( $value, $tmpname )) {
						$tmpname [] = $value;
						$attribute [$key] = $value . "|" . $_POST ['attribute_unit'] [$key];
					}
				}
				$data ['attribute'] = serialize ( $attribute );
			}
			if (is_array ( $_POST ['cid'] )) {
				$tmpname = array ();
				foreach ( $_POST ['cid'] as $key => &$value ) {
					if (! in_array ( $value, $tmpname )) {
						$tmpname [] = $value;
					}
				}
				$_POST ['cid'] = $tmpname;
				
				$data ['cid'] = implode ( ",", $_POST ['cid'] );
				$delActionCategorySql = "delete from ai_action_category where aid=$id";
				M ( '' )->query ( $delActionCategorySql );
				foreach ( $_POST ['cid'] as $key => &$value ) {
					M ( 'action_category' )->add ( array (
							'aid' => $id,
							'cid' => $value 
					) );
				}
			}
			$data ['recommend'] =$_POST ['recommend']?$_POST ['recommend']:0;
			$this->generateFontWith ();
			M ( 'action_list' )->save ( $data );
			redirect ( U ( 'admin/Course/actionList' ) );
		}
		
		$sql = "select * from ai_action_list where id=$id";
		$actionInfo = $this->getSqlDataOne ( $sql );
		$cateList = explode ( ",", $actionInfo ['cid'] );
		$attributeList = unserialize ( $actionInfo ['attribute'] );
		foreach ( $attributeList as &$value ) {
			$tmp = array ();
			$tmp = explode ( "|", $value );
			$value = array (
					'name' => $tmp [0],
					'unit' => $tmp [1] 
			);
		}
		$cate = M ( 'action_category_list' )->findAll ();
		$this->assign ( 'cateList', $cateList );
		$this->assign ( 'attributeList', $attributeList );
		$this->assign ( 'cate', $cate );
		//var_dump($actionInfo);

		$this->assign ( 'actionInfo', $actionInfo );
		$this->display ( 'editAction' );
	}
	public function addAction() {
		if (! empty ( $_POST ['name'] )) {
			
			$insertData ['name'] = t ( $_POST ['name'] );
			$insertData ['recommend'] = ! empty ( $_POST ['recommend'] ) ? intval ( $_POST ['recommend'] ) : 0;
			if (is_array ( $_POST ['cid'] ))
				$_POST ['cid'] = array_unique ( $_POST ['cid'] );
			$insertData ['cid'] = (count ( $_POST ['cid'] ) == 1) && ! is_array ( $_POST ['cid'] ) ? intval ( $_POST ['cid'] ) : implode ( ",", $_POST ['cid'] );
			
			foreach ( $_POST ['attribute_name'] as $key => $value ) {
				if (! empty ( $value )) {
					$attribute [$key] = $value . "|" . $_POST ['attribute_unit'] [$key];
				}
			}
			
			$insertData ['attribute'] = serialize ( $attribute );
			
			$insertId = M ( 'action_list' )->add ( $insertData );
			if (! empty ( $insertId ) && ! empty ( $_POST ['cid'] )) {
				if (is_array ( $_POST ['cid'] )) {
					foreach ( $_POST ['cid'] as $key => &$value ) {
						M ( 'action_category' )->add ( array (
								'aid' => $insertId,
								'cid' => $value 
						) );
					}
				} else {
					M ( 'action_category' )->add ( array (
							'aid' => $insertId,
							'cid' => $_POST ['cid'] 
					) );
				}
			}
			$this->generateFontWith ();
			redirect ( U ( 'admin/Course/actionList' ) );
		}
		$cate = M ( 'action_category_list' )->where ( array (
				'parentid' => 0 
		) )->findAll ();
		$this->assign ( 'cate', $cate );
		$this->display ( 'addAction' );
	}
	protected function getSqlDataAll($sql) {
		if (empty ( $sql ))
			return false;
		$data = null;
		$data = M ( '' )->query ( $sql );
		return $data;
	}
	protected function getSqlDataOne($sql) {
		if (empty ( $sql ))
			return false;
		$data = null;
		$data = M ( '' )->query ( $sql );
		return $data [0];
	}
	public function addCategory() {
		if (isset ( $_POST ['name'] )) {
			$data ['name'] = t ( $_POST ['name'] );
			$data ['parentid'] = $_POST ['parentid'] ? intval ( $_POST ['parentid'] ) : 0;
			$vid = M ( 'action_category_list' )->add ( $data );
			$this->generateFontWith ();
			redirect ( U ( 'admin/Course/CategoryPm' ) );
		}
		$cate = M ( 'action_category_list' )->where ( array (
				'parentid' => 0 
		) )->findAll ();
		$this->assign ( 'cate', $cate );
		$this->display ( 'addCategory' );
	}
	public function editCategory() {
		$id = intval ( $_GET ['cid'] );
		if (! empty ( $_POST ['name'] )) {
			$data ['cid'] = $id;
			$data ['name'] = t ( $_POST ['name'] );
			$data ['recommend'] = $_POST ['recommend'] ? 1 : 0;
			M ( 'action_category_list' )->save ( $data );
		}
		$list = M ( 'action_category_list' )->where ( array (
				'cid' => $id 
		) )->find ();
		$cate = M ( 'action_category_list' )->where ( array (
				'parentid' => 0 
		) )->findAll ();
		$this->assign ( 'list', $list );
		$this->assign ( 'cate', $cate );
		$this->assign ( 'type', 'edit' );
		$this->display ( 'editCategory' );
	}
	public function doDeleteAction() {
		if (! isset ( $_POST ['ids'] )) {
			echo '0';
			exit ();
		}
		$table = $_POST ['table'] ? $_POST ['table'] : '';
		$map ['cid'] = array (
				'in',
				t ( $_POST ['ids'] ) 
		);
		$catemap ['aid'] = array (
				'in',
				t ( $_POST ['ids'] ) 
		);
		M ( 'action_category' )->where ( $catemap )->delete ();
		echo M ( 'action_list' )->where ( $map )->delete () ? '1' : '0';
	}
	public function doDeleteCategory() {
		if (! isset ( $_POST ['ids'] )) {
			echo '0';
			exit ();
		}
		if (! isset ( $_POST ['table'] )) {
			echo '0';
			exit ();
		}
		$table = $_POST ['table'] ? $_POST ['table'] : '';
		$map ['cid'] = array (
				'in',
				t ( $_POST ['ids'] ) 
		);
		echo M ( $table )->where ( $map )->delete () ? '1' : '0';
	}
	public function CategoryPm() {
		$pg = $_GET ['pg'] ? intval ( $_GET ['pg'] ) : 1;
		$nums = 15;
		$dailycount = M ( 'action_category_list' )->order ( 'cid desc' )->findAll ();
		// $daily=M ( 'daily' )->order ( 'create_time desc' )->findAll ();
		$from = ($pg - 1) * $nums;
		$daily = M ( '' )->query ( "select * from ai_action_category_list order by cid desc limit {$from},{$nums}" );
		foreach ( $daily as $key => &$value ) {
			if ($value ['parentid'] > 0) {
				$data = null;
				$getCateNameSql = "select name from ai_action_category_list where cid='" . $value ['parentid'] . "'";
				$data = M ( '' )->query ( $getCateNameSql );
				if (! empty ( $data )) {
					$value ['parentid'] = $data [0] ['name'];
				}
			} else {
				$value ['parentid'] = '顶级父类';
			}
		}
		$pageArr = $this->pageHtml ( count ( $dailycount ), $nums, $pg, '/index.php?app=admin&mod=Course&act=CategoryPm&pg=%s' );
		
		$this->assign ( 'pageArr', $pageArr );
		$this->assign ( 'daily', $daily );
		$this->display ( 'actionCategory' );
	}
	public function doDeleteDaily() {
		$this->delete ( 'daily' );
	}
	protected function getCategories() {
		$category = M ( 'article_category' )->findAll ();
		return $category;
	}
	public function pageHtml($count, $nums, $pg = null, $url = null) {
		$enum = $snum = 0;
		$pager = null;
		$pagehtml = null;
		$listnum = ceil ( $count / $nums );
		if ($pg == 1 || ! $pg) {
			$pre = '<li><a>Prev</a></li>';
		} else {
			$pre = '<li><a href="' . $url . ($pg - 1) . '">Prev</a></li>';
			$pre = '<li><a href="' . sprintf ( $url, $pg - 1 ) . '">Prev</a></li>';
		}
		if ($pg == $listnum) {
			$next = '<li><a>Next</a></li>';
		} else {
			$next = '<li><a href="' . $url . ($pg + 1) . '">Next</a></li>';
			$next = '<li><a href="' . sprintf ( $url, $pg + 1 ) . '">Next</a></li>';
		}
		for($i = 1; $i <= $listnum; $i ++) {
			if ($i == $pg) {
				$cuCss = 'class="active"';
			} else {
				$cuCss = '';
			}
			if (! $pg) {
				if ($i == 1) {
					$cuCss = 'class="active"';
				}
			}
			$pageArr [$i] = '<li ' . $cuCss . '><a href="' . $url . $i . '">' . $i . '</a></li>';
			$pageArr [$i] = '<li ' . $cuCss . '><a href="' . sprintf ( $url, $i ) . '">' . $i . '</a></li>';
		}
		if ($listnum > 10) {
			if ($pg > 5 && ($listnum - $pg) >= 5) {
				$snum = $pg - 5;
				$enum = $pg + 5;
			}
			if ($pg < 5 && ($listnum - $pg) > 5) {
				$snum = 1;
				$enum = 10;
			}
			if ($pg > 5 && ($listnum - $pg) < 5) {
				$snum = $pg - 5 - (5 - ($listnum - $pg)) + 1;
				$enum = $listnum;
			}
			if ($pg == 5) {
				$snum = 1;
				$enum = 10;
			}
			foreach ( $pageArr as $k => $v ) {
				if ($k < $snum || $k > $enum) {
					// unset($pageArr[$k]);
				} else {
					$pagehtml .= $v;
				}
			}
		} else {
			foreach ( $pageArr as $k => $v ) {
				$pagehtml .= $v;
			}
		}
		$html ['backstr'] = $pre;
		$html ['nextstr'] = $next;
		$html ['thestr'] = $pagehtml;
		return $html;
	}
}
?>