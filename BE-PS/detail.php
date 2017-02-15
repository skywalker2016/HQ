<?php
/**
 * Created by PhpStorm.
 * User: hongqiang
 * Date: 2017/1/6
 * Time: 10:42
 */
//header("content-type:text/html; charset=utf-8");

session_start();
include ("connect_db.php");

if ($_SESSION['permission'] == null){
    header("Location::error.html");
    exit;
}

$id = $_GET['id'];

$conn = db_connect();

//执行sql语句
$sql = "select * from upfiles WHERE file_id={$id}";
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
        <font face="Georgia, Times New Roman, Times, serif" size="4" color="#A4B8F2"> You are here: File Details </font>
    </div>
    <br />
    <hr width="50%" id="hr_home"/>
    <br /><br />
    <?php
    while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
    ?>
        <table border="0" cellpadding="5px" cellspacing="5px" width="50%">

            <tr>
                <td width="50%" align="right">
                     <P><strong>
                        File Name:&nbsp;&nbsp;&nbsp;</strong></P></td>
                <td width="50%" align="left">
                    <p><?php echo $row[1]; ?></p>
                </td>
                </tr>
            <tr>
                <td width="50%" align="right">
                    <p><strong>
                        Category:&nbsp;&nbsp;&nbsp;</strong></p></td>
                <td width="50%" align="left">
                    <P><?php echo $row[5]; ?></P>
                </td>
                </tr>
            <tr>
                <td width="50%" align="right">
                    <p><strong>
                        Upload Time:&nbsp;&nbsp;&nbsp;</strong>
                </p></td>
                <td width="50%" align="left">
                    <p><?php echo $row[4]; ?></p>
                </td>
                </tr>
            <tr>
                <td width="50%" align="right">
                    <p><strong>
                        File Size:&nbsp;&nbsp;&nbsp;</strong>
                    </p></td>
                <td width="50%" align="left">
                    <p><?php echo $row[7]; ?></p>
                </td>
                </tr>
            <tr>
                <td width="50%" align="right">
                    <p><strong>
                        File Owner:&nbsp;&nbsp;&nbsp;</strong>
                </p></td>
                <td width="50%" align="left">
                    <P><?php echo $row['3']; ?></P>
                </td>
            </tr>
            <tr>
                <td width="50%" align="right">
                    <p><strong>
                        Permission:&nbsp;&nbsp;&nbsp;</strong>
                </p></td>
                <td width="50%" align="left">
                    <p><?php echo $_SESSION['permission']; ?></p>
                </td>
            </tr>
            <tr>
                <td width="50%" align="right">
                    <p><strong>
                        File Discription:&nbsp;&nbsp;&nbsp;</strong>
                </p></td>
                <td width="50%" align="left"><P>
                    <?php echo $row['6']; ?></P>
                </td>
            </tr>
        </table>
        <br />
        <?php if ($_SESSION['username'] == 'root' || $_SESSION['username'] == $row['3']){  ?>
    <table border="0" cellpadding="5px" cellspacing="5px" width="50%">
        <tr>
            <td align="right" width="45%">
                <p><img src="./images/back.png" />&nbsp;<a href="paging.php" id="a1"> Back </a></p>
            </td>
            <td align="right" width="15%">
                <p><img src="./images/edit.png" />&nbsp;<a href="edit_form.php?id=<?php echo $row['0']; ?>" id="a1"> Edit </a></p>
            </td>
            <td align="center" width="20%">
                <p><img src="./images/delete.png" />&nbsp;<a href="delete.php?id=<?php echo $row['0']; ?>" id="a1"> Delete </a></p>
            </td>
            <td align="left" width="20%">
                <p><img src="./images/history.png" />&nbsp;<a href="download.php?id=<?php echo $row['0']; ?>" id="a1"> Download </a></p>
            </td>
        </tr>
        </table>
        <?php }else{  ?>
            <table border="0" cellpadding="5px" cellspacing="5px" width="50%">
                <tr>
                    <td align="right" width="45%">
                        <p><img src="./images/back.png" />&nbsp;<a href="paging.php" id="a1"> Back </a></p>
                    </td>
                    <td align="right" width="15%">
                        <p><img src="./images/edit.png" />&nbsp;<font id="a1"> Edit </font></p>
                    </td>
                    <td align="center" width="20%">
                        <p><img src="./images/delete.png" />&nbsp;<font id="a1"> Delete </font></p>
                    </td>
                    <td align="left" width="20%">
                        <p><img src="./images/history.png" />&nbsp;<a href="download.php?id=<?php echo $row['0']; ?>" id="a1"> Download </a></p>
                    </td>
                </tr>
            </table>
            <?php } ?>
    <?php } ?>
</div>
</body>
</html>

