<?php if (!defined('THINK_PATH')) exit();?>        <div class="pollBox pt10">
          <div class="LogList">
            <ul >
              <?php if(is_array($data)): ?><?php $i = 0;?><?php $__LIST__ = $data?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$vo): ?><?php ++$i;?><?php $mod = ($i % 2 )?><li class="lineD_btm mb10 pb5">
                  <div style="float:left;">
                    <div class="userPic"><a href="<?php echo U('home/space/index',array('uid'=>$vo[uid]));?>"  class="tips" rel="<?php echo U('home/space/index',array('uid'=>$vo[uid]));?>"><?php echo getUserSpace($vo["uid"],'','','{uavatar}') ?></a></div>
                    <div class="OverH" style="clear: left;*width:60px;text-align:center"><a href="<?php echo U('home/space/index',array('uid'=>$vo[uid]));?>" class="U"><?php echo (getUserName($vo["uid"])); ?></a></div>
                  </div>
                  <div class="userinfo">
                  <div class="num right">
                      <div><strong><?php echo ($vo["vote_num"]); ?></strong>参与人数</div>
                    </div>
                    <h3 class="f14px"><a href="<?php echo U('vote/Index/pollDetail',array('id'=>$vo['id']));?>" class="U"><strong><?php echo ($vo["title"]); ?></strong></a><?php if( $vo['deadline'] < time() ){ ?>
                    <span class="cRed ">(已结束)</span></p>
                    <?php }else{ ?>
                     <?php } ?></h3>
                    <?php if(is_array($vo["opts"])): ?><?php $i = 0;?><?php $__LIST__ = $vo["opts"]?><?php if( count($__LIST__)==0 ) : echo "" ; ?><?php else: ?><?php foreach($__LIST__ as $key=>$opt): ?><?php ++$i;?><?php $mod = ($i % 2 )?><?php if($vo['type'] == "0"){ ?>
                      <p>
                        <input type="radio" name="checkbox" id="checkbox" disabled="true"/>
                        <?php }else{ ?>
                      <p>
                        <input type="checkbox" name="checkbox" id="checkbox" disabled="true"/>
                        <?php } ?>
                        <?php echo ($opt["name"]); ?></p><?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?>
                    <?php if( $vo['deadline'] < time() ){ ?>
                    <p><span class="right cGray2">发起时间：<?php echo (friendlyDate($vo["cTime"])); ?>&nbsp;&nbsp; <a href="<?php echo U('vote/Index/pollDetail',array('id'=>$vo['id']));?>">查看投票&gt;&gt;</a></span>．．．</p>
                    <?php }else{ ?>
                    <p><span class="right cGray2">发起时间：<?php echo (friendlyDate($vo["cTime"])); ?>&nbsp;&nbsp; <a href="<?php echo U('vote/Index/pollDetail',array('id'=>$vo['id']));?>">参与投票&gt;&gt;</a></span>．．．</p>
                    <?php } ?>
                  </div>
                </li><?php endforeach; ?><?php endif; ?><?php else: echo "" ;?><?php endif; ?>
            </ul>
            <!--<div id="Pagination" class="pagination"><?php echo ($html); ?></div>-->
            <div class="page"><?php echo ($list["html"]); ?></div>
          </div>
        </div>