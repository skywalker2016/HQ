<?php
/**
 * Created by PhpStorm.
 * User: hongqiang
 * Date: 2017/1/13
 * Time: 20:32
 */

session_start();
include ("connect_db.php");

if ($_SESSION['permission'] == null){
    header("Location::error.html");
    exit;
}

$username = $_GET['username'];
$password = $_GET['password'];
$permission = $_GET['permission'];


$conn = db_connect();
$sql = "update user 
        set username = \"$username\",
            password = \"$password\",
            permission = \"$permission\"
            WHERE id = {$_SESSION['id']}";
$result = $conn -> query($sql);

if ($result){
    echo "<script type=\"text/javascript\">";
    echo 'alert("用户信息更新成功！")';
    echo "</script>";
    echo '<script language="JavaScript">';
    echo 'window.location.href="alter.php"';
    echo "</script>";
}else{
    echo "<script type=\"text/javascript\">";
    echo 'alert("用户信息更新失败！")';
    echo "</script>";
    echo '<script language="JavaScript">';
    echo 'window.location.href="alter.php"';
    echo "</script>";
}

//删除单个已注册的session变量
uset($_SESSION['id']);
?>