<?php
?>
<html>
<title></title>
<body>
<div style="float:left;width:300px;heigth:300px; background-color:red;">
<h2>登陆</h2>
<form action="/wapapi/ios.php?aucode=aijianmei&auact=au_login" method="post">
<input name="email" type="text">
<input name="userpassword" type="text">
<input name="usertype" type="text">
<input type="submit">
</form>
</div>
<div style="float:left;width:300px;heigth:300px; background-color:red;">
<h2>注册</h2>
<form action="/wapapi/ios.php?aucode=aijianmei&auact=au_register" method="post">
username<input name="username" type="text"></br>
email<input name="email" type="text"></br>
userpassword<input name="userpassword" type="text"></br>
usertype<input name="usertype" type="text"></br>
profileImageUrl<input name="profileImageUrl" type="text"></br>
sex<input name="sex" type="text"></br>
age<input name="age" type="text"></br>
body_weight<input name="body_weight" type="text"></br>
height<input name="height" type="text"></br>
keyword<input name="keyword" type="text"></br>
province<input name="province" type="text"></br>
city<input name="city" type="text"></br>
<input type="submit">
</form>
</div>
<div style="float:left;width:300px;heigth:300px; background-color:red;">
<h2>文章列表</h2>
<form action="/wapapi/ios.php?aucode=aijianmei&auact=au_getinformationlist" method="post">
listtype<input name="listtype" type="text"></br>
category<input name="category" type="text"></br>
id<input name="id" type="text"></br>
type<input name="type" type="text"></br>
page<input name="page" type="text"></br>
pnums<input name="pnums" type="text"></br>
uid<input name="uid" type="text"></br>
<input type="submit">
</form>
</div>
<div style="float:left;width:300px;heigth:300px; background-color:red;">
<h2>文章详情</h2>
<form action="/wapapi/ios.php?aucode=aijianmei&auact=au_getinformationdetail" method="post">
id<input name="id" type="text"></br>
channel<input name="channel" type="text"></br>
channeltype<input name="channeltype" type="text"></br>
uid<input name="uid" type="text"></br>

<input type="submit">
</form>
</div>
<div style="float:left;width:300px;heigth:300px; background-color:red;">
<h2>评论</h2>
<form action="/wapapi/ios.php?aucode=aijianmei&auact=au_sendcomment" method="post">
id<input name="id" type="text"></br>
channel<input name="channel" type="text"></br>
channeltype<input name="channeltype" type="text"></br>
uid<input name="uid" type="text"></br>
commentcontent<input name="commentcontent" type="text"></br>
<input type="submit">
</form>
</div>
<div style="float:left;width:300px;heigth:300px; background-color:red;">
<h2> 删除评论</h2>
<form action="/wapapi/ios.php?aucode=aijianmei&auact=au_delcomment" method="post">
id<input name="id" type="text"></br>
channel<input name="channel" type="text"></br>
channeltype<input name="channeltype" type="text"></br>
uid<input name="uid" type="text"></br>
<input type="submit">
</form>
</div>
<div style="float:left;width:300px;heigth:300px; background-color:red;">
<h2>like</h2>
<form action="/wapapi/ios.php?aucode=aijianmei&auact=au_sendlike" method="post">
id<input name="id" type="text"></br>
channel<input name="channel" type="text"></br>
channeltype<input name="channeltype" type="text"></br>
uid<input name="uid" type="text"></br>
<input type="submit">
</form>
</div>
</body>
</html>