<?php
/**
 * Created by PhpStorm.
 * User: hongqiang
 * Date: 2017/1/13
 * Time: 18:30
 */
header("content-type:text/html; charset=utf-8");

session_start();
include ("connect_db.php");
include ("page.class.php");

if ($_SESSION['permission'] == null){
    header("Location::error.html");
    exit;
}


//链接数据库
$conn = db_connect();

$sql = "select count(*) as total from user";
$result = $conn -> query($sql);
$data = mysqli_fetch_array($result);

//创建分页对象
$page = new Page($data['total'], 10);
$start = $page->start()-1;


//执行sql
$sql = "select id, username, password, permission
        from user ORDER BY id limit {$start},10";

$result = $conn -> query($sql);
?>


<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="style.css" />
    <title></title>
</head>
<body>
<div align="center">
    <br />
    <div>
        <br />
        <font face="Georgia, Times New Roman, Times, serif" size="4" color="#A4B8F2"> You are here: Alter UserInfo </font>
    </div>
    <br />
    <hr width="50%" id="hr_home"/>
    <br /><br />
    <table border="2" width="80%" align="center" cellspacing="2px" cellpadding="2px">

        <tr>
            <th id="form1_D">ID</th>
            <th id="form1_D">USERNAME</th>
            <th id="form1_D">PASSWORD</th>
            <th id="form1_D">PERMISSION</th>
            <th id="form1_D">EDIT</th>
            <th id="form1_D">DELETE</th>
        </tr>
        <?php
        while($row = mysqli_fetch_array($result, MYSQLI_NUM)){
            ?>
            <tr>
                <td id="form2_1"><?php echo $row[0]; ?></td>
                <td id="form2_1"><?php echo $row[1]; ?></td>
                <td id="form2_1"><?php echo $row[2]; ?></td>
                <td id="form2_1"><?php echo $row[3]; ?></td>
                <td id="form2_1" align="center"><img src="./images/edit.png" /><a href="userinfo_edit_form.php?id=<?php echo $row['0']; ?>"> 编&nbsp;辑 </a> </td>
                <td id="form2_1" align="center"><img src="./images/delete.png" /><a href="userinfo_delete.php?id=<?php echo $row['0']; ?>"> 删&nbsp;除 </a> </td>
            </tr>
            <?php
        }
        ?>

        <tr><td colspan="8" align="right" id="form2_1"><?php echo $page->fpage(); ?></td></tr>
    </table>
</div>
</body>
</html>