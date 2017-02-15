<?php
/**
 * Created by PhpStorm.
 * User: hongqiang
 * Date: 2017/1/13
 * Time: 19:58
 */

session_start();
include ("connect_db.php");

if ($_SESSION['permission'] == null){
    header("Location::error.html");
    exit;
}
$_SESSION['id'] = null;
$id = $_GET['id'];
$_SESSION['id'] = $id;

$conn = db_connect();
$sql = "select * from user WHERE id={$id}";
$result = $conn -> query($sql);
$row = mysqli_fetch_array($result);
?>

<html xmlns="http://www.w3.org/1999/xhtml" xmlns="http://www.w3.org/1999/html">
<head>
    <meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="style.css" />
    <title></title>
</head>
<body>
<div align="center">
    <br /><br />
    <div>
        <br />
        <font face="Georgia, Times New Roman, Times, serif" size="3" color="#A4B8F2"> You are here: Edit User's informations </font>
    </div>
    <br />
    <hr width="50%" id="hr_home"/>
    <br /><br />
    <form action="userinfo_edit.php" method="get">
        <div align="center">
            <table border="0" cellpadding="5px" cellspacing="5px" width="50%">
            <tr>
            <td width="40%" align="right">
            <p>
Username:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td width="60%" align="left">
                    <input value="<?php echo $row['username']; ?>"  type="text" name="username" id="form2" size="34" />
                </td>
            </p></tr>
                <tr>
                <td width="40%" align="right">
            <p>
Password:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td width="60%" align="left">
                    <input value="<?php echo $row['password']; ?>"  type="text" name="password" id="form2" size="34" />
                </td>
            </p></tr>
                <tr>
                    <td width="40%" align="right">
            <p>
Permission:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    </td>
                    <td width="60%" align="left">
                    <input value="<?php echo $row['permission']; ?>"  type="text" name="permission" id="form2" size="34" />
                    </td>
            </p></tr>
                </table>
            <br />
            <input type="submit" value="UPDATE" id="form2" />
        </div>
    </form>
</div>
</body>
</html>
