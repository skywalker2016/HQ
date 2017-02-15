<?php
/**
 * Created by PhpStorm.
 * User: hongqiang
 * Date: 2017/1/3
 * Time: 10:56
 */

session_start();
include ("connect_db.php");

if ($_SESSION['permission'] == null){
    header("Location::error.html");
    exit;
}

$file_owner = $_POST['owner'];
$file_time = $_POST['time'];
$file_classification = $_POST['classification'];
$file_discription = $_POST['discription'];
$file_name = $_FILES['file']['name'];
$file_size = $_FILES['file']['size'];
if ($file_size < 1024){
    $file_size .= 'B';
}elseif ($file_size > 1024 && $file_size < 1024*1024){
    $file_size = round($file_size / 1024, 2);
    $file_size .= 'KB';
}elseif ($file_size > 1024*1024 && $file_size < 1024*1024*1024){
    $file_size = round($file_size / (1024*1024), 2);
    $file_size .= 'MB';
}
$path = "";    //定义存储路径

$file_dir = './upload/'.$file_classification.'/';    //最终保存目录
if (!is_dir($file_dir)){
    $mkdir_file_dir = mkdir('./upload/'.$file_classification, 0777);   //在upload下建立一个文件夹，并设定文件夹的权限
    $file_dir = './upload/'.$file_classification.'/';
}

if ($_FILES['file']['name'] != ''){
    if ($_FILES['file']['error'] > 0){
        switch ($_FILES['file']['error']){
            case 1:
                echo "文件大小超过PHP.ini中的文件限制！";
                break;
            case 2:
                echo "文件大小超过了浏览器限制！";
                break;
            case 3:
                echo "文件部分被上传！";
                break;
            case 4:
                echo "没有找到要上传的文件！";
                break;
            case 5:
                echo "服务器临时文件夹丢失，请重新上传！";
                break;
            case 6:
                echo "文件写入到临时文件夹出错！";
                break;
        }
    }else{
        date_default_timezone_set("Asia/Shanghai");
        //$currtime = date('YmdHis');
        $_FILES['file']['name'] = date('YmdHis').$_FILES['file']['name'];   //为文件重新命名，避免重复
        if (!file_exists($file_dir.$_FILES['file']['name'])){
            move_uploaded_file($_FILES['file']['tmp_name'], $file_dir.$_FILES['file']['name']);
            $path = $file_dir.$_FILES['file']['name'];
            //将文件地址保存到数据库中
            $conn = db_connect();
            //$conn -> query("set names utf8");
            $result = $conn -> query("insert into upfiles(file_name, file_path, file_owner, file_time, file_classification, file_discription, file_size)
                                      VALUES ('".$file_name."', '".$path."', '".$file_owner."', '".$file_time."', '".$file_classification."',
                                      '".$file_discription."', '".$file_size."')");
            if ($result){
                echo "<script>alert(\"上传成功！\");</script>";

            }

        }else{
            echo "<script>alert(\"您上传的文件已经存在！\");</script>";
        }
    }
}else{
    echo "<script>alert(\"请上传文件！\");</script>";
}
header("Location:add.php");
?>