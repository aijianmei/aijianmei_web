<?php if (!defined('THINK_PATH')) exit();?><link rel="stylesheet" href="__PUBLIC__/js/selectfriends/ui.selectfriends.css" type="text/css" media="screen" charset="utf-8" />
<?php if(!$no){ ?>
	<script type="text/javascript" src="__PUBLIC__/js/selectfriends/ui.selectfriends.js"></script>
	<script>var no_edit = 0;</script>
<?php } ?>
<script>
    $(document).ready( function(){
        var id ="";
        var test = new giant.ui.friendsuggest({

			btnAll:"#ui-fs<?php echo ($id); ?> .ui-fs-icon",
			btnCloseAllFriend:"#ui-fs<?php echo ($id); ?> .ui-fs-all .close",
			btnNextPage:"#ui-fs<?php echo ($id); ?> .ui-fs-all .next",
			btnPrevPage:"#ui-fs<?php echo ($id); ?> .ui-fs-all .prev",
			selectFriendType:"#ui-fs-friendtype<?php echo ($id); ?>",
			allFriendContainer:"#ui-fs<?php echo ($id); ?> .ui-fs-all" ,
			allFriendListContainer:"#ui-fs<?php echo ($id); ?> .ui-fs-all .ui-fs-allinner div.list",
			frinedNumberContainer:"#ui-fs<?php echo ($id); ?> .ui-fs-allinner .page b",
			resultContainer:"#ui-fs<?php echo ($id); ?> .ui-fs-result",
			input:"#ui-fs<?php echo ($id); ?> .ui-fs-input input",
			inputContainer:"#ui-fs<?php echo ($id); ?> .ui-fs-input",
			dropDownListContainer:"#ui-fs<?php echo ($id); ?> .ui-fs-list",
			inputDefaultTip:"<?php echo L('input_friend_name');?>",
			noDataTip:"<?php echo L('friend_noexist');?>",

			totalSelectNum:10,
			ajaxBefore:null,
			ajaxError:null,
			selectType:"multiple",


            ajaxUrl: U('home/SelectFriends/getOne'),
            ajaxLoadAllUrl: U('home/SelectFriends/getAll'),
            ajaxGetCountUrl: U('home/SelectFriends/getCount'),
            ajaxGetFriendTypeUrl: U('home/SelectFriends/getType'),
            selectCallBack:function(fid, name, image) {
                alert("<?php echo L('you_chose_id');?>"+fid);
                this.setDropDownListHide();
                this.setAllFriendHide();
            }
        });

        <?php if($uid){ ?>
        //指定发给某人
        var uid = "<?php echo ($uid); ?>";
        if(uid){
        	var image = "<?php echo (getUserFace($uid)); ?>";
        	var name  = "<?php echo (getUserName($uid)); ?>";
        	//$(".ui-fs-input").remove();
        	$('.ui-fs-input input').val('');
        	$(".ui-fs-result").html("<a href='javascript:void(0)' ><img width='20' height='20' src='" + image + "' title='" + name + "' alt='' /> "+ name + "</a>");
        	// 表单已选
        	$("#ui_fri_ids").val(uid);
        	// js结果已选
        	test.resultArr = uid.split(',');
        }   
        <?php } ?>

        if( $( '#ui_fri_ids<?php echo ($id); ?>' ).val() ){
          $( '.ui-fs-result' ).css( 'display','block' );
        }
    });
</script>
<!-- 选择好友组件-->
<div id="ui-fs<?php echo ($id); ?>" class="ui-fs" style="border: 1px solid #bdc7d8;background:#fff">
	<div class="ui-fs-result clearfix" style="display:none;">
	</div>
	<div class="ui-fs-input" style="position:relative;">
		<input type="text" value="<?php echo L('input_friend_name');?>" maxlength="30" style="_width:85%"/>
		<a class="ui-fs-icon" href="javascript:void(0)" title="<?php echo L('view_all_friends');?>"></a>
	</div>
	<div class="ui-fs-list">
		<?php echo L('data_loading');?>
	</div>
	<div class="ui-fs-all" style="display:none">
		<div class="top">
			<select id="ui-fs-friendtype<?php echo ($id); ?>"><!--<option value="-1">与我互粉的人</option>--></select>
			<div class="close" title="<?php echo L('close');?>"></div>
		</div>
		<div class="ui-fs-allinner">
			<div class="page clearfix">
				<div class="llight1">还可选<b id="ui_fri_num"><?php if(($uid)  ==  ""): ?>10<?php endif; ?><?php if(($uid)  !=  ""): ?>9<?php endif; ?></b>人 </div><div class="button"><span class="prev"><?php echo L('pre_page');?></span><span class="next"><?php echo L('next_page');?></span></div>
			</div>
			<div class="list clearfix">
				<?php echo L('data_loading');?>
			</div>
		</div>
	</div>
</div>
<!--选择好友组件 end-->

<input type="hidden" id="ui_fri_ids<?php echo ($id); ?>" name="<?php echo ($name); ?><?php echo ($id); ?>"  dataType="LimitB" min="1"  msg="<?php echo L('must_choose');?>">

<!-- <input type="hidden" id="<?php echo ($id); ?>" name="fri_ids<?php echo ($id); ?>"  dataType="LimitB" min="1"  msg="必须选择用户!"> -->