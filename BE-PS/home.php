<?php
/**
 * Created by PhpStorm.
 * User: hongqiang
 * Date: 2016/12/10
 * Time: 16:06
 */
session_start();
include ("connect_db.php");

if ($_SESSION['permission'] == null){
    header("Location::error.html");
    exit;
}
$start = $_REQUEST['start'];

if ($start == 1){
    $_SESSION['name_page'] = 'home';
    if ($_SESSION['username'] == 'root'){
        print ("<script type=\"text/javascript\">");
        print ("alert(\"请小心！您现在是管理员身份使用数据库。\")");
        print ("</script>");
    }
}

if ($start == 2){
    $_SESSION['name_page'] = 'home';
}

if ($start == 3){
    $_SESSION['name_page'] = 'ECG';
}

if ($start == 4){
    $_SESSION['name_page'] = 'Afib';
}

if ($start == 5){
    $_SESSION['name_page'] = 'Tumble';
}

if ($start == 6){
    $_SESSION['name_page'] = 'Add';
}

if ($start == 7){
    $_SESSION['name_page'] = 'Alter';
}


?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-type" content="text/html" charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="style.css" />
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
    <title>Physiological Signal Database</title>
    <?php include ("js_file/date.js"); ?>
</head>
<body>
<div align="center">
    <?php include("header.php"); ?>
    <hr id="hr1" size="5px" />

    <table border="0" cellspacing="0" cellpadding="0" width="80%">
        <tr>
            <td width="100%" align="right">
                <font id="font3">
                    <script language="JavaScript">
                        document.write(""+year+"年"+month+""+date+"日"+"   "+day+"");
                    </script>
                </font>
            </td>
        </tr>
    </table>
    <table width="95%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <!--menu-->
            <td width="25%" align="center" valign="top">
                <?php include ("menu.php"); ?>
            </td>
            <!--body-->
            <td width="75%" align="center" valign="top">
                <?php
                if (($start == 1) || ($start == 2))
                    print ("<iframe src='home2.php' width='100%' height='650' frameborder='0' scrolling='auto' name='corpo'></iframe>");
                if ($start == 3)
                    print ("<iframe src='paging.php' width='100%' height='650' frameborder='0' scrolling='auto' name='corpo'></iframe>");
                if ($start == 4)
                    print ("<iframe src='afib.php' width='100%' height='650' frameborder='0' scrolling='auto' name='corpo'></iframe>");
                if ($start == 5)
                    print ("<iframe src='tumble.php' width='100%' height='720' frameborder='0' scrolling='auto' name='corpo'></iframe>");
                if ($start == 6)
                    print ("<iframe src='add.php' width='100%' height='720' frameborder='0' scrolling='auto' name='corpo'></iframe>");
                if ($start == 7)
                    print ("<iframe src='alter.php' width='100%' height='720' frameborder='0' scrolling='auto' name='corpo'></iframe>");
                ?>
            </td>
        </tr>
    </table>
    <?php include ("footer.html"); ?>
</div>
</body>
</html>
