<?php
/**
 * Created by PhpStorm.
 * User: hongqiang
 * Date: 2017/1/14
 * Time: 12:32
 */

session_start();
include ("connect_db.php");

if ($_SESSION['permission'] == null){
    header("Location::error.html");
    exit;
}

$id = $_SESSION['file_id'];

if ($_POST['name'] != null && $_POST['time'] != null && $_POST['discription'] != null) {
    $file_name = $_POST['name'];
    $upload_time = $_POST['time'];
    $file_discription = $_POST['discription'];


    $conn = db_connect();
    $sql = "update upfiles 
        set file_name = \"$file_name\",
            file_time = \"$upload_time\",
            file_discription = \"$file_discription\"
            WHERE file_id = {$_SESSION['file_id']}";
    $result = $conn->query($sql);

    if ($result) {
        echo "<script type=\"text/javascript\">";
        echo 'alert("用户信息更新成功！")';
        echo "</script>";
        echo '<script language="JavaScript">';
        echo "window.location.href='detail.php?id=$id'";
        echo "</script>";
    } else {
        echo "<script type=\"text/javascript\">";
        echo 'alert("用户信息更新失败！")';
        echo "</script>";
        echo '<script language="JavaScript">';
        echo "window.location.href='detail.php?id=$id'";
        echo "</script>";
    }


}else{
    echo "<script type=\"text/javascript\">";
    echo 'alert("表单填写不完整！")';
    echo "</script>";
    echo '<script language="JavaScript">';
    echo "window.location.href='detail.php?id=$id'";
    echo "</script>";
}
//删除单个已注册的session变量
uset($_SESSION['file_id']);
?>