<?php
/**
 * Created by PhpStorm.
 * User: hongqiang
 * Date: 2017/1/13
 * Time: 21:23
 */

session_start();
include ("connect_db.php");

if ($_SESSION['permission'] == null){
    header("Location::error.html");
    exit;
}
$_SESSION['file_id'] = null;
$id = $_GET['id'];
$_SESSION['file_id'] = $id;

$conn = db_connect();
$sql = "select * from upfiles WHERE file_id={$id}";
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
        <font face="Georgia, Times New Roman, Times, serif" size="3" color="#A4B8F2"> You are here: Edit File's informations </font>
    </div>
    <br />
    <hr width="50%" id="hr_home"/>
    <br /><br />
    <form action="edit.php" method="post">
        <div align="center">
            <table border="0" cellpadding="5px" cellspacing="5px" width="50%">
                <tr>
                    <td width="40%" align="right">
                        <p>
                            File Name:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td width="60%" align="left">
                        <input value="<?php echo $row['file_name']; ?>"  type="text" name="name" id="form2" size="34" />
                    </td>
                    </p></tr>
                <tr>
                    <td width="40%" align="right">
                        <p>
                            Upload Time:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;
                    </td>
                    <td width="60%" align="left">
                        <input type="date" name="time" id="form2" />
                    </td>
                    </p></tr>
                <tr>
                    <td width="40%" align="right">
                        <p>
                            File Discription:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </td>
                    <td width="60%" align="left">
                        <textarea cols="30" rows="5" name="discription" id="form2"></textarea>
                    </td>
                    </p>
                </tr>
            </table>
            <br />
            <input type="submit" value="UPDATE" id="form2" />
        </div>
    </form>
</div>
</body>
</html>
