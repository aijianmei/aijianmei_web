<?php
return array (
	'au_login' => array ('email' => 1,'userpassword' => 1,'usertype' => 0 ),

	'au_register' => array ('username' => 0,'userpassword' => 0,'email' => 0,'usertype' => 0,'snsid' => 0,'profileImageUrl' => 0,'sex' => 0,'age' => 0,'body_weight' => 0,'height' => 0,'keyword' => 0,'province' => 0,'city' => 0 ),

	'au_getinformationlist' => array ('listtype' => 0,'category' => 0,'id' => 0,'type' => 0,'page' => 0,'pnums' => 0,'uid' => 0,'start' => 0,'offset' => 0 ),

	'au_getinformationdetail' => array ('id' => 1,'channel' => 1,'uid' => 0 ),

	'au_sendcomment' => array ('id' => 0,'channel' => 0,'channeltype' => 0,'uid' => 0,'commentcontent' => 0 ),

	'au_delcomment' => array ('id' => 1,'channel' => 0,'channeltype' => 0,'uid' => 1 ),

	'au_sendlike' => array ('id' => 1,'channel' => 0,'channeltype' => 0,'uid' => 1 ),

	'au_getfplist' => array ('type' => 0,'page' => 0,'pnums' => 0,'uid' => 0,'start' => 0,'offset' => 0 ),

	'au_getversion' => array ('type' => 0 ),

	'au_sendsuggestion' => array ('uid' => 1,'content' => 1 ),

	'au_updateUserInfo' => array ('uid' => 1,'username' => 0,'userface' => 0,'userbgimg' => 0,'keyword' => 0,'description' => 0,'sex' => 0,'age' => 0,'weight' => 0,'height' => 0,'province' => 0,'city' => 0 ),

	'au_getuserinfobysnsid' => array ('snsid' => 1,'usertype' => 1 ),

	'au_updatepassword' => array ('uid' => 1,'oldpassword' => 1,'newpassword' => 1 ),

	'au_getuserinfobyuid' => array ('uid' => 1 ),

	'au_getuidbysnsid' => array ('snsid' => 1 ),

	'au_uploadimg' => array ('uid' => 0,'imagetype' => 0 ),

	'articlestatus' => array ('uid' => 0,'aid' => 0,'vid' => 0 ),

	'getcommentbyid' => array ('id' => 1,'channeltype' => 0 ),

	'getCircleList' => array ('id' => 0,'uid' => 0,'group' => 0,'start' => 0,'offset' => 0 ),

	'postCircleList' => array ('uid' => 0, ),

	'postCircleComment' =>array('uid'=>1,'id'=>1,'content'=>1,),

	'postCircleLike' =>array('uid'=>0,'statusId'=>0,),

	'getWeightInfo' =>array('uid'=>0,),

	'postWeightInfo'=>array('uid'=>0,),

	'getCourseInfo'=>array('uid'=>0,),

	'getAllAtionList'=>array('uid'=>0,),

	'postUserActionList'=>array('uid'=>0,),

	'getUserActionListById'=>array('uid'=>0,),

	'getUserCourseImage'=>array('uid'=>0,),

	'postUserCourseImage'=>array('uid'=>0,),

	'getUserCourseLogImage'=>array('uid'=>0,),

	'postUserCourseLogImage'=>array('uid'=>0,),

	'postCourseInfo'=>array('uid'=>0,),

	'deleteCourseInfo'=>array('uid'=>0,),

	'getUserRankList'=>array('uid'=>0,),
	
	'showChartPage'=>array('uid'=>0,),
	
	'getDefaultUserLineData'=>array('uid'=>0,),
	);
?>