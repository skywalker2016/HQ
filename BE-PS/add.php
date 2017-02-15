<?php
/**
 * Created by PhpStorm.
 * User: hongqiang
 * Date: 2017/1/2
 * Time: 19:36
 */

session_start();
if ($_SESSION['permission'] == null){
    header("Location::error.html");
    exit;
}

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
        <font face="Georgia, Times New Roman, Times, serif" size="3" color="#A4B8F2">You are here: Add new File</font>
    </div>
    <br />
    <hr width="50%" id="hr_home"/>
    <br /><br />
    <form action="upload.php" method="post" enctype="multipart/form-data">
        <div align="center">
            <table border="0" cellpadding="5px" cellspacing="5px" width="50%">
            <tr>
            <td width="40%" align="right">
            <p>
                    File Location:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td width="60%" align="left">
                    <input type="file" name="file" id="form2" />
                </td>
            </p></tr>
                <tr>
                <td width="40%" align="right">
            <p>
                    File Owner:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td width="60%" align="left">
                    <input type="text" name="owner" id="form2" size="34" />
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
                    File Classification:&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td width="60%" align="left">
                    <select name="classification" id="form2">
                        <option value="ecg" selected> 心&nbsp;&nbsp;电 </option>
                        <option value="afib"> 房&nbsp;&nbsp;颤 </option>
                        <option value="tumble"> 跌&nbsp;&nbsp;倒 </option>
                    </select></td>
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
            <input type="submit" value="INSERT" id="form2" />
        </div>
    </form>
</div>
</body>
</html>
