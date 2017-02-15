<?php
/**
 * Created by PhpStorm.
 * User: hongqiang
 * Date: 2016/11/1
 * Time: 13:09
 */

require_once ('db_fns.php');

function login($username, $password){
    // 检测用户名和密码是否正确
    // 如果正确，则返回true
    // 否则，返回false

    // 连接数据库
    $conn = db_connect();
    if (!$conn){
        return 0;
    }

    $result = $conn->query("select * from admin
                           where username = '".$username."'
                           and password = sha1('".$password."')");
    if (!$result){
        return 0;
    }

    if ($result->num_rows > 0){
        return 1;
    }else{
        return 0;
    }
}

function check_admin_user(){
    if (isset($_SESSION['admin_user'])){
        return true;
    }else{
        return false;
    }
}

function register($username, $password) {
// register new person with db
// return true or error message

    // connect to db
    $conn = db_connect();

    // check if username is unique
    $result = $conn->query("select * from admin where username='".$username."'");
    if (!$result) {
        throw new Exception('Could not execute query');
    }

    if ($result->num_rows>0) {
        throw new Exception('That username is taken - go back and choose another one.');
    }

    // if ok, put in db
    $result = $conn->query("insert into admin values
                         ('".$username."', sha1('".$password."'))");
    if (!$result) {
        throw new Exception('Could not register you in database - please try again later.');
    }

    return true;
}

function insert_book($isbn, $title, $author, $cat_id, $price, $description){
    $conn = db_connect();

    $query = "select * 
              from books
              where isbn = '".$isbn."'";
    $result = $conn -> query($query);
    if ((!$result) || ($result->num_rows != 0)){
        return false;
    }

    // insert new book
    $query = "insert into books values 
              ('".$isbn."', '".$author."', '".$title."',
               '".$cat_id."', '".$price."', '".$description."')";

    $result = $conn -> query($query);
    if (!$result){
        return false;
    }else{
        return true;
    }
}
?>