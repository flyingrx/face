<?php
//$_POST['image_file']
$info = array(
    'api_key'=>'MbHN0i8ATK1bYDnfWklmqW7A_q8BCylO',
    'api_secret'=>'g3GnCC1TB_yWo4MjjUFcAhDZVB31Mucu',
    'return_landmark'=>1,
    'return_attributes'=>null
);
$file = $_FILES['image_file']['tmp_name'];
$uploaddir = './uploads/';
$uploadfile = $uploaddir . basename($_FILES['image_file']['name']);
move_uploaded_file($file,$uploadfile);

$s = file_get_contents($uploadfile);
$type = pathinfo($uploadfile, PATHINFO_EXTENSION);
$base64 = base64_encode($s);
//echo $base64;exit;

$info['image_base64'] = $base64;
//$info['image_url'] = $base64;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,'https://api-cn.faceplusplus.com/facepp/v3/detect');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_POST,1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $info);
$result=curl_exec($ch);
if($result===false){
    echo curl_error($ch);
}else{
    print_r($result);
}
curl_close ($ch);
//echo $base64;
