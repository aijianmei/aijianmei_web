<?php if ($this->_var['helps']): ?>
<?php $_from = $this->_var['helps']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'help_cat');if (count($_from)):
    foreach ($_from AS $this->_var['help_cat']):
?>
<dl>
  <dt><a href='<?php echo $this->_var['help_cat']['cat_id']; ?>' title="<?php echo $this->_var['help_cat']['cat_name']; ?>"><?php echo $this->_var['help_cat']['cat_name']; ?></a></dt>
  <?php $_from = $this->_var['help_cat']['article']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['item']):
?>
  <dd><a href="<?php echo $this->_var['item']['url']; ?>" title="<?php echo htmlspecialchars($this->_var['item']['title']); ?>"><?php echo $this->_var['item']['short_title']; ?></a></dd>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</dl>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
<?php endif; ?>
    <div class="block">
    
   <div class="clearfix">
<dl>
  <dt class="dt1"><a href="<?php echo $this->_var['_buttomTagInfo']['shopguide']['url']; ?>" title="<?php echo $this->_var['_buttomTagInfo']['shopguide']['name']; ?>" rel="nofollow"><?php echo $this->_var['_buttomTagInfo']['shopguide']['name']; ?></a></dt>
    <dd><a href="<?php echo $this->_var['_buttomTagInfo']['shop_need_know']['url']; ?>" title="<?php echo $this->_var['_buttomTagInfo']['shop_need_know']['name']; ?>" rel="nofollow"><?php echo $this->_var['_buttomTagInfo']['shop_need_know']['name']; ?></a></dd>
    <dd><a href="<?php echo $this->_var['_buttomTagInfo']['orderinfo']['url']; ?>" title="<?php echo $this->_var['_buttomTagInfo']['orderinfo']['name']; ?>" rel="nofollow"><?php echo $this->_var['_buttomTagInfo']['orderinfo']['name']; ?></a></dd>
    <dd><a href="<?php echo $this->_var['_buttomTagInfo']['shopprocess']['url']; ?>" title="<?php echo $this->_var['_buttomTagInfo']['shopprocess']['name']; ?>" rel="nofollow"><?php echo $this->_var['_buttomTagInfo']['shopprocess']['name']; ?></a></dd>
  </dl>
<dl>
  <dt class="dt2"><a href="<?php echo $this->_var['_buttomTagInfo']['expressdelivery']['url']; ?>" title="<?php echo $this->_var['_buttomTagInfo']['expressdelivery']['name']; ?>" rel="nofollow"><?php echo $this->_var['_buttomTagInfo']['expressdelivery']['name']; ?></a></dt>
    <dd><a href="<?php echo $this->_var['_buttomTagInfo']['shoprange']['url']; ?>" title="<?php echo $this->_var['_buttomTagInfo']['shoprange']['name']; ?> " rel="nofollow"><?php echo $this->_var['_buttomTagInfo']['shoprange']['name']; ?></a></dd>
    <dd><a href="<?php echo $this->_var['_buttomTagInfo']['shipmethos']['url']; ?>" title="<?php echo $this->_var['_buttomTagInfo']['shipmethos']['name']; ?> " rel="nofollow"><?php echo $this->_var['_buttomTagInfo']['shipmethos']['name']; ?></a></dd>
    <dd><a href="<?php echo $this->_var['_buttomTagInfo']['acceptance']['url']; ?>" title="<?php echo $this->_var['_buttomTagInfo']['acceptance']['name']; ?>" rel="nofollow"><?php echo $this->_var['_buttomTagInfo']['acceptance']['name']; ?></a></dd>
  </dl>
<dl>
  <dt class="dt3"><a href="<?php echo $this->_var['_buttomTagInfo']['howtopay']['url']; ?>" title="<?php echo $this->_var['_buttomTagInfo']['howtopay']['name']; ?>" rel="nofollow"><?php echo $this->_var['_buttomTagInfo']['howtopay']['name']; ?></a></dt>
    <dd><a href="<?php echo $this->_var['_buttomTagInfo']['onlinebankingpay']['url']; ?>" title="<?php echo $this->_var['_buttomTagInfo']['onlinebankingpay']['name']; ?> " rel="nofollow"><?php echo $this->_var['_buttomTagInfo']['onlinebankingpay']['name']; ?></a></dd>
    <dd><a href="<?php echo $this->_var['_buttomTagInfo']['alipay']['url']; ?>" title="<?php echo $this->_var['_buttomTagInfo']['alipay']['name']; ?>" rel="nofollow"><?php echo $this->_var['_buttomTagInfo']['alipay']['name']; ?></a></dd>
    <dd><a href="<?php echo $this->_var['_buttomTagInfo']['prepayment']['url']; ?>" title="<?php echo $this->_var['_buttomTagInfo']['prepayment']['name']; ?>" rel="nofollow"><?php echo $this->_var['_buttomTagInfo']['prepayment']['name']; ?></a></dd>
  </dl>
<dl>
  <dt class="dt4"><a href="<?php echo $this->_var['_buttomTagInfo']['salesservice']['url']; ?>" title="<?php echo $this->_var['_buttomTagInfo']['salesservice']['name']; ?>" rel="nofollow"><?php echo $this->_var['_buttomTagInfo']['salesservice']['name']; ?></a></dt>
    <dd><a href="<?php echo $this->_var['_buttomTagInfo']['returnprocess']['url']; ?>" title="<?php echo $this->_var['_buttomTagInfo']['returnprocess']['name']; ?>" rel="nofollow"><?php echo $this->_var['_buttomTagInfo']['returnprocess']['name']; ?></a></dd>
    <dd><a href="<?php echo $this->_var['_buttomTagInfo']['returnpolicy']['url']; ?>" title="<?php echo $this->_var['_buttomTagInfo']['returnpolicy']['name']; ?> " rel="nofollow"><?php echo $this->_var['_buttomTagInfo']['returnpolicy']['name']; ?></a></dd>
    <dd><a href="<?php echo $this->_var['_buttomTagInfo']['refundinstructions']['url']; ?>" title="<?php echo $this->_var['_buttomTagInfo']['refundinstructions']['name']; ?>" rel="nofollow"><?php echo $this->_var['_buttomTagInfo']['refundinstructions']['name']; ?></a></dd>
  </dl>
<dl>
  <dt class="dt5"><a href="<?php echo $this->_var['_buttomTagInfo']['askedquestions']['url']; ?>" title="<?php echo $this->_var['_buttomTagInfo']['askedquestions']['name']; ?>" rel="nofollow"><?php echo $this->_var['_buttomTagInfo']['askedquestions']['name']; ?></a></dt>
    <dd><a href="<?php echo $this->_var['_buttomTagInfo']['about']['url']; ?>" title="<?php echo $this->_var['_buttomTagInfo']['about']['name']; ?>" rel="nofollow"><?php echo $this->_var['_buttomTagInfo']['about']['name']; ?></a></dd>
    <dd><a href="<?php echo $this->_var['_buttomTagInfo']['termsservice']['url']; ?>" title="<?php echo $this->_var['_buttomTagInfo']['termsservice']['name']; ?>" rel="nofollow"><?php echo $this->_var['_buttomTagInfo']['termsservice']['name']; ?></a></dd>
    <dd><a href="<?php echo $this->_var['_buttomTagInfo']['shoppingguide']['url']; ?>" title="<?php echo $this->_var['_buttomTagInfo']['shoppingguide']['name']; ?>" rel="nofollow"><?php echo $this->_var['_buttomTagInfo']['shoppingguide']['name']; ?></a></dd>
  </dl>
</div>
</div>
<script type="text/javascript">
            //添加事件监听
            var addevent = function(element,type,handle){
                if(element.addEventListener){
                    element.addEventListener(type,handle,false)
                }
                else if(element.attachEvent){
                    element.attachEvent("on" + type,handle)
                } 
                else {
                    element["on" + type] = handler;
                    this.AddEvent = function(element, type, handler)
                    {
                        element["on" + type] = handler;
                    };
                }
            }
            //获取dom元素
            var getdom = function(){
                this.$ = function(id){
                    return document.getElementById(id);
                }

                this.getElementsByClass = function(searchClass,node,tag) {
                    var classElements = new Array();
                    if ( node == null )
                            node = document;
                    if ( tag == null )
                            tag = '*';
                    var els = node.getElementsByTagName(tag);
                    var elsLen = els.length;
                    var pattern = new RegExp("(^|\\s)"+searchClass+"(\\s|$)");
                    for (i = 0, j = 0; i < elsLen; i++) {
                            if ( pattern.test(els[i].className) ) {
                                    classElements[j] = els[i];
                                    j++;
                            }
                    }
                    return classElements;
                }
                this.GetCurrentStyle = function(obj, prop){
                    if (obj.currentStyle){ //IE
                        return obj.currentStyle[prop];
                    }
                    else if (window.getComputedStyle){ //非IE
                        propprop = prop.replace (/([A-Z])/g, "-$1");
                        propprop = prop.toLowerCase ();
                        return document.defaultView.getComputedStyle(obj,null)[propprop];
                    }
                    return null;
                }
            }   

            var aijianmei = {
                newdom : new getdom,
                getclass : function(obj,T){
                  if(T){
                    return aijianmei.newdom.getElementsByClass(obj);
                  }
                  else{
                    return aijianmei.newdom.getElementsByClass(obj)[0];
                  }
                },
                p_fixed : function(obj){
                    if(navigator.userAgent.indexOf("MSIE")>0){
                        obj.className = 'header'
                    }
                    else{
                        window.onscroll = function(){
                            var top = document.body.scrollTop || window.pageYOffset;
                            if(top >= 50){
                                obj.className = 'header p_fixed';
                            }
                            else{
                                obj.className = 'header'
                            }       
                        }
                    }
                },
                hover_1 : function(){
                  var account = aijianmei.getclass('account');
                  account.style.display = 'block'
                },
                hover_2 : function(){
                  var account = aijianmei.getclass('account');
                  account.style.display = 'none'
                }
            }
            var init = function(){
                var newdom = new getdom,
                    header = newdom.getElementsByClass('header')[0],
                    login = newdom.getElementsByClass("login"),
                    body = newdom.getElementsByClass('body')[0],
                    sheet = newdom.getElementsByClass('sheet')[0],
                    close_btn = newdom.getElementsByClass('close_btn')[0],
                    more = newdom.getElementsByClass('more')[0],
                    label_1 = newdom.getElementsByClass('label_1')[0],
                    label_2 = newdom.getElementsByClass('label_2')[0],
                    len = login.length,
                    mail = document.getElementById('mail'),
                    psd = document.getElementById('psd');
                aijianmei.p_fixed(header);
                if(more){
                  addevent(more,'mouseover',aijianmei.hover_1);
                  addevent(more,'mouseout',aijianmei.hover_2)
                }
                  
                for(var i = 0;i < len;i++){
                    login[i].onclick = function(){
                        body.style.display = 'block';
                        sheet.style.display = 'block';
                        if(mail.value != ""){
                          label_1.style.display = 'none';
                          label_2.style.display = 'none'
                        }
                        mail.onfocus = function(){
                          label_1.style.display = 'none';
                        }
                        mail.onblur = function(){
                          if(this.value == ''){
                            label_1.style.display = 'block';
                          }
                          else{
                            var e_reg = new RegExp(),
                                e_reg = /^\w+((_-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|_-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/,
                                v_mail = mail.value;
                            if(e_reg.test(v_mail) == false){
                                newdom.getElementsByClass('tip')[0].style.display = 'inline';
                            }
                            else{
                                newdom.getElementsByClass('tip')[0].style.display = 'none';
                            }
                          }
                        }
                        psd.onfocus = function(){
                          label_2.style.display = 'none';
                        }
                        psd.onblur = function(){
                          if(this.value == ''){
                            label_2.style.display = 'block'
                          }
                          else{
                            var p_reg = new RegExp(),
                                p_reg = /[0-9A-Za-z]{6,16}/,
                                v_psd = psd.value;
                            if(p_reg.test(v_psd) == false){
                                newdom.getElementsByClass('tip')[1].style.display = 'inline';
                            }
                            else{
                                newdom.getElementsByClass('tip')[1].style.display = 'none';
                            }
                          }
                        }
                    }
                }
                close_btn.onclick = function(){
                    sheet.style.display = 'none';
                    body.style.display = 'none';
                }
            }
            init();
            //对象fade，添加一个功能，屏蔽按钮，显示产品即将推出
            var fade = {
                newdom : new getdom,
                init : function(obj){
                    var Obj = fade.newdom.getElementsByClass(obj)[0] || document.getElementsByTagName(obj)[0] || document.getElementById(obj);
                    Obj.onclick = function(event){
                        var _e = event ? event : window.event;
                        if(_e.preventDefault){
                            _e.preventDefault();
                        }
                        else{
                            _e.returnValue = false;
                        }
                        fade.handlecontent();
                        fade.changestyle('1');
                        this.style.background = '';
                        var closed = fade.newdom.getElementsByClass('closed')[0],
                            fade_in = fade.newdom.getElementsByClass('fade_in')[0];
                        var click_back = function(){
                            fade.changestyle('0');
                            // fade_in.removeAttribute('class')
                            fade_in.className = ''
                        }
                        addevent(closed,'click',click_back);
                        addevent(fade_in,'click',click_back);
                    }
                },
                handlecontent : function(){
                    var body = document.getElementsByTagName('body')[0],
                        div_1 = document.createElement('div'),
                        div_2 = document.createElement('div');
                    div_1.className = 'fade_in';
                    div_2.className = 'modal';
                    div_2.innerHTML = '<div class="modal_header"><a class="closed">×</a><h3>我们正在检测中</h3></div><p class="modal_body">即将推出，敬请期待...</p>';
                    body.appendChild(div_1);
                    body.appendChild(div_2);
                },
                changestyle : function(T){
                    var fade_in = fade.newdom.getElementsByClass('fade_in')[0],
                        modal = fade.newdom.getElementsByClass('modal')[0];
                    if(isFirefox=navigator.userAgent.indexOf("Firefox")>0){
                      if(T == '1'){
                          var i = 0,
                              top = fade.newdom.GetCurrentStyle(modal,'top');
                          var round = function(){
                              setTimeout(function(){
                                  i = i + 0.05;
                                  fade_in.style.opacity = i;
                                  top = parseFloat(top) + 20;
                                  modal.style.top = top + 'px';
                                  if(top < 200){
                                      round()
                                  }
                              },1);
                          }
                          round()
                      }
                      else{
                          var i = 0.75,
                              top = fade.newdom.GetCurrentStyle(modal,'top');
                          var round = function(){
                              setTimeout(function(){
                                  i = i - 0.05;
                                  fade_in.style.opacity = i;
                                  top = parseFloat(top) - 20;
                                  modal.style.top = top + 'px';
                                  if(top > -120){
                                      round()
                                  }
                              },10);
                          }
                          round()
                      }   
                    }
                    else{
                      if(T == '1'){
                        fade_in.style.opacity = 0.8;
                        modal.style.top = '200px'
                      }
                      else{
                        fade_in.style.opacity = -0.05;
                        modal.style.top = '-120px'
                      }

                    }
                }
            };
            var newdom = new getdom;

            if(newdom.getElementsByClass('forum')[0]){
                fade.init('forum');
            }
            if(newdom.getElementsByClass('friends')[0]){
                fade.init('friends');
            }
            if(newdom.getElementsByClass('my_cart')[0]){
                fade.init('my_cart');
            }
            if(document.getElementById('teach')){
                fade.init('teach');
            }
</script>