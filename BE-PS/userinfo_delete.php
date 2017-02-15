<?php
/**
 * Created by PhpStorm.
 * User: hongqiang
 * Date: 2017/1/13
 * Time: 19:13
 */

session_start();
include ("connect_db.php");

if ($_SESSION['permission'] == null){
    header("Location::error.html");
    exit;
}

$id = $_GET['id'];

$conn = db_connect();

$sql = "delete from user WHERE id={$id}";
$result = $conn -> query($sql);
if ($result){
    echo "<script type=\"text/javascript\">";
    echo 'alert("用户删除成功！")';
    echo "</script>";
    echo '<script language="JavaScript">';
    echo 'window.location.href="alter.php"';
    echo "</script>";
}else{
    echo "<script type=\"text/javascript\">";
    echo 'alert("用户删除失败！")';
    echo "</script>";
    echo '<script language="JavaScript">';
    echo 'window.location.href="alter.php"';
    echo "</script>";
}
?>