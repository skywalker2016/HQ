<?php
/**
 * Created by PhpStorm.
 * User: hongqiang
 * Date: 2016/12/15
 * Time: 20:52
 */
include ("connect_db.php");
header("Content-Type:text/html; charset=utf8");

$username = $_POST['username'];
$password = $_POST['password'];
$password1 = $_POST['password1'];

try{
    if ($password != $password1){
        throw new Exception("两次密码不匹配，请重新输入！");
    }
    if ((strlen($password) < 6) || (strlen($password) > 16)){
        throw new Exception("密码长度必须在6至16个字符之间，请重新输入！");
    }

    $conn = db_connect();

    // check if username is unique
    $result = $conn->query("select * from user where username='".$username."'");
    if (!$result) {
        throw new Exception('Could not execute query');
    }

    if ($result->num_rows>0) {
        throw new Exception('That username is taken - go back and choose another one.');
    }

    // if ok, put in db
    $result = $conn ->query("insert into user (username, password, permission) VALUES ('".$username."', '".$password."', '1')");
    if (!$result) {
        throw new Exception('Could not register you in database - please try again later.');
    }
    echo "<script type=\"text/javascript\">";
    echo 'alert("注册成功！")';
    echo "</script>";
    echo '<script language="JavaScript">';
    echo "window.location.href='index.php'";
    echo "</script>";

}
catch (Exception $e) {
    echo "注册失败！";
    echo $e->getMessage();
    exit;
}
?>