<?php
/**
 * Created by PhpStorm.
 * User: hongqiang
 * Date: 2016/12/15
 * Time: 16:39
 *
if ($_REQUEST['register'])
{
    // In this case, the USER will has to insert the ER password in order to have access at the database:
    header("Location:register_new.php");

}

if ($_REQUEST['back'])
{
    // In this case, the USER will has to insert the ER password in order to have access at the database:
    header("Location:index.php");

}
*/
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
    <title>生理信号数据库注册页面</title>
</head>
<body>
<br/><br/>
<div align='center'>
    <?php include("header.php"); ?>
    <!--<font id='font1'> 生理信号数据库 </font>-->

    <hr id='hr1' size='5px'/>
    <br /><br /><br />
    <font id='font2'> Welcome to register BE-PS Database </font>
    <br /><br />
    <br />
    <font id="font3">
        <form action="register_new.php" method="post">
            <table border="0" width="35%" cellpadding="4px" cellspacing="4px">
                <tr>
                    <td width="40%" align="center"> 用户名 &nbsp;</td>
                    <td width="60%" align="left"><input type='text' name='username' size='35' id="form1"/></td>
                </tr>
                <tr>
                    <td width="40%" align="center"> 密&nbsp;&nbsp;&nbsp;码 &nbsp;</td>
                    <td width="60%" align="left"><input type='password' name='password' size='35' id="form1"/></td>
                </tr>
                <tr>
                    <td width="40%" align="center"> 确认密码 &nbsp;</td>
                    <td width="60%" align="left"><input type='password' name='password1' size='35' id="form1"/></td>
                </tr>

            </table>
            <br /><br />
            <table border="0" width="25%" cellpadding="0" cellspacing="2px">
                <tr>
                    <td width="50%" align="center" colspan="2"><input type='submit' value=' 注 册 ' id='form2' /></td>

                </tr>
            </table>
        </form>
    </font>
    <br /><br /><br /><br /><br /><br /><br />
    <?php include ("footer.html"); ?>
    </div>
</body>
</html>
