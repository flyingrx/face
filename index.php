<?php
//$_POST['image_file']
//HTTP上传文件的开关，默认为ON即是开
ini_set('file_uploads','ON');
//通过POST、GET以及PUT方式接收数据时间进行限制为90秒 默认值：60
ini_set('max_input_time','90');
//脚本执行时间就由默认的30秒变为180秒
ini_set('max_execution_time', '180');
//Post变量由2M修改为8M，此值改为比upload_max_filesize要大
ini_set('post_max_size', '12M');
//上传文件修改也为8M，和上面这个有点关系，大小不等的关系。
ini_set('upload_max_filesize','10M');
//正在运行的脚本大量使用系统可用内存,上传图片给多点，最好比post_max_size大1.5倍
ini_set('memory_limit','200M');
// include ImgCompressor.php
include_once('imageCompress.php');




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
$setting = array(
    'directory' => 'compressed', // directory file compressed output
    'file_type' => array( // file format allowed
        'image/jpeg',
        'image/png',
        'image/gif'
    )
);
$ImgCompressor = new ImgCompressor($setting);
$result = $ImgCompressor->run($uploadfile, 'jpg', 5);


$s = file_get_contents($result['data']['compressed']['image']);
$type = pathinfo($result['data']['compressed']['type'],PATHINFO_EXTENSION);
$base64 = base64_encode($s);

$info['image_base64'] = $base64;
//$info['image_url'] = $base64;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,'https://api-cn.faceplusplus.com/facepp/v3/detect');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_POST,1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $info);
$result=curl_exec($ch);
/*if($result===false){
    echo curl_error($ch);
}else{
//    echo $result;
    echo 2;
}*/
curl_close ($ch);

