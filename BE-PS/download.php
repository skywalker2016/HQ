<?php
/**
 * Created by PhpStorm.
 * User: hongqiang
 * Date: 2017/1/10
 * Time: 13:45
 */

session_start();
include ("connect_db.php");
include ("download.class.php");

if ($_SESSION['permission'] == null){
    header("Location::error.html");
    exit;
}

$id = $_GET['id'];

$conn = db_connect();

//执行sql语句
$sql = "select file_name, file_path from upfiles WHERE file_id={$id}";
$result = $conn -> query($sql);
$row = mysqli_fetch_array($result);

$file_name = $row['file_name'];    //下载文件名
$file_path = $row['file_path'];    //下载文件存放路径
/*
//检查文件是否存在
if (!file_exists($file_path)){
    echo "<script type=text/javascript>";
    echo 'alert("文件找不到")';
    echo "</script>";
    exit();
}else{
    //打开文件
    $file = fopen($file_path, "r");
    //输入文件标签
    header("Content-type:application/octet-stream");
    header("Accept-Ranges:bytes");
    header("Accept-Length:".filesize($file_path));
    header("Content-Disposition:attachment; filename=".$file_name);

    //输出文件内容
    //读取文件内容并直接输出到浏览器
    $buffer = 1024;
    $file_count = 0;
    while(!feof($file) && $file_count < filesize($file_path)){
        $file_con = fread($file, $buffer);
        $file_count += $buffer;
        echo $file_con;
    }
    //echo fread($file, filesize($file_path));
    fclose($file);
    exit();
}*/

$obj = new FileDownload();
$flag = $obj->download($file_path,$file_name);
if (!$flag){
    echo "<script type=text/javascript>";
    echo 'alert("文件不存在！")';
    echo "</script>";
    echo "<meta http-equiv=\"refresh\" content=\"0;url=paging.php\" />";
}
?>


