<?php
/**
 * Created by PhpStorm.
 * User: hongqiang
 * Date: 2017/1/9
 * Time: 10:25
 */
session_start();
include ("connect_db.php");

if ($_SESSION['permission'] == null){
    header("Location::error.html");
    exit;
}


$id = $_GET['id'];

$conn = db_connect();

//获取文件所在路径
$sql = "select file_path from upfiles WHERE file_id = {$id}";
$result = $conn -> query($sql);
$row = mysqli_fetch_array($result);

//删除数据库中的记录
$sql = "delete from upfiles WHERE file_id = {$id}";
$result = $conn -> query($sql);
if ($result){
    //数据库中记录删除成功后，下一步删除服务器中的文件
    //如果文件存在，使用unlink删除
    if (file_exists($row['file_path'])){
        if (unlink($row['file_path'])){
            echo "<script type=\"text/javascript\">";
            echo 'alert("文件删除成功！")';
            echo "</script>";
            echo '<script language="JavaScript">';
            echo 'window.location.href="paging.php"';
            echo "</script>";
        }else{
            echo "<script type=\"text/javascript\">";
            echo 'alert("文件删除失败！可以尝试修改文件权限删除。。。")';
            echo "</script>";
        }
    }else{
        echo "<script type=\"text/javascript\">";
        echo 'alert("文件不存在！")';
        echo "</script>";
        echo "<meta http-equiv=\"refresh\" content=\"0;url=paging.php\" />";
    }
}else{
    echo "<script type=\"text/javascript\">";
    echo 'alert("数据库记录删除失败！")';
    echo "</script>";
}



?>