<?php


function _postCurlRegister($data){
    $url = 'http://www.kon_aijianmei.com/shop/user.php';
    $post_data = array(
    'password' => $data['password'],
    'username' => $data['uname'],
    'email' => $data['email'],
    'confirm_password' =>$data['password'],
    'act' =>'act_register',
    'back_act' =>'',
    'agreement'=>1,
    );
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    $output = curl_exec($ch);
    curl_close($ch);
}

function _postCurlLogin($data){
    $url = 'http://www.kon_aijianmei.com/shop/user.php';
    $post_data = array(
    'password' => $data['password'],
    'username' => $data['username'],
    'remember' => 1,
    'act' =>'act_login',
    );
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    $output = curl_exec($ch);
    curl_close($ch);
}

function _postCurlLogin($data){
    $url = 'http://www.kon_aijianmei.com/shop/user.php';
    $post_data = array(
    'password' => $data['password'],
    'username' => $data['username'],
    'remember' => 1,
    'act' =>'act_login',
    );
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    $output = curl_exec($ch);
    curl_close($ch);
}