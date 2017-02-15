<?php
/**
 * Created by PhpStorm.
 * User: hongqiang
 * Date: 2016/12/11
 * Time: 21:12
 */
session_start();
include ("connect_db.php");

if ($_SESSION['permission'] == null){
    header("Location::error.html");
    exit;
}
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-type" content="text/html" charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="style.css" />
    <title></title>
</head>
<body>
<div align="center">
    <br />

    <div id='benvenuto'>
        <br />
        <font face="Georgia, Times New Roman, Times, serif" size="6" color="#800040">欢迎使用<a href="">BE-PS</a>数据库</font>
        <br /><br />
    </div>

    <br /><br />
    <hr width="50%" id="hr_home"/>
    <br />
    <form action="search.php" method="post" style='display:inline'>
    <table id="font3_B" cellpadding="5px" cellspacing="5px">
        <tr>
            <td colspan="3">基本检索</td>
        </tr>

        <tr>
            <td><input type="text" name='name1' size='30' id='form1' value=''/></td>&nbsp;&nbsp;
            <td>
                <select name="name2" id="form1">
                    <option value="author" selected>作者</option>
                    <option value="file_name">文件名</option>
                </select>
            </td>&nbsp;&nbsp;
            <td><input type="submit" value="检&nbsp;索" id="form1"></td>
        </tr>
        <tr>
            <td colspan="3">时间跨度</td>
        </tr>
        </table>
        <table id="font3_B" cellpadding="5px" cellspacing="5px">
        <tr>
            <td>
                <select name="year" id="form1">
                    <option value="2016" selected>2016</option>
                    <option value="2017">2017</option>
                    <option value="2018">2018</option>
                    <option value="2019">2019</option>
                    <option value="2020">2020</option>
                    <option value="2021">2021</option>
                    <option value="2022">2022</option>
                    <option value="2023">2023</option>
                    <option value="2024">2024</option>
                    <option value="2025">2025</option>
                    <option value="2026">2026</option>
                </select>
            </td>
            <td>
                <select name="month" id="form1">
                    <option value="January" selected>1月</option>
                    <option value="February">2月</option>
                    <option value="March">3月</option>
                    <option value="April">4月</option>
                    <option value="May">5月</option>
                    <option value="June">6月</option>
                    <option value="July">7月</option>
                    <option value="August">8月</option>
                    <option value="September">9月</option>
                    <option value="October">10月</option>
                    <option value="November">11月</option>
                    <option value="Dicember">12月</option>
                </select>
            </td>
            <td>
                <select name="day" id="form1">
                    <option value="1" selected>1日</option>
                    <option value="2">2日</option>
                    <option value="3">3日</option>
                    <option value="4">4日</option>
                    <option value="5">5日</option>
                    <option value="6">6日</option>
                    <option value="7">7日</option>
                    <option value="8">8日</option>
                    <option value="9">9日</option>
                    <option value="10">10日</option>
                    <option value="11">11日</option>
                    <option value="12">12日</option>
                    <option value="13">13日</option>
                    <option value="14">14日</option>
                    <option value="15">15日</option>
                    <option value="16">16日</option>
                    <option value="17">17日</option>
                    <option value="18">18日</option>
                    <option value="19">19日</option>
                    <option value="20">20日</option>
                    <option value="21">21日</option>
                    <option value="22">22日</option>
                    <option value="23">23日</option>
                    <option value="24">24日</option>
                    <option value="25">25日</option>
                    <option value="26">26日</option>
                    <option value="27">27日</option>
                    <option value="28">28日</option>
                    <option value="29">29日</option>
                    <option value="30">30日</option>
                    <option value="31">31日</option>
                </select>
            </td>
        </tr>
    </table>
        <br /><font face="Verdana, Arial, Helvetica, sans-serif" size="4" color="#FFFFCC">至</font><br /><br />
        <table id="font3_B" cellpadding="5px" cellspacing="5px">
            <tr>
                <td>
                    <select name="year1" id="form1">
                        <option value="2016" selected>2016</option>
                        <option value="2017">2017</option>
                        <option value="2018">2018</option>
                        <option value="2019">2019</option>
                        <option value="2020">2020</option>
                        <option value="2021">2021</option>
                        <option value="2022">2022</option>
                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                        <option value="2025">2025</option>
                        <option value="2026">2026</option>
                    </select>
                </td>
                <td>
                    <select name="month1" id="form1">
                        <option value="January" selected>1月</option>
                        <option value="February">2月</option>
                        <option value="March">3月</option>
                        <option value="April">4月</option>
                        <option value="May">5月</option>
                        <option value="June">6月</option>
                        <option value="July">7月</option>
                        <option value="August">8月</option>
                        <option value="September">9月</option>
                        <option value="October">10月</option>
                        <option value="November">11月</option>
                        <option value="Dicember">12月</option>
                    </select>
                </td>
                <td>
                    <select name="day1" id="form1">
                        <option value="1" selected>1日</option>
                        <option value="2">2日</option>
                        <option value="3">3日</option>
                        <option value="4">4日</option>
                        <option value="5">5日</option>
                        <option value="6">6日</option>
                        <option value="7">7日</option>
                        <option value="8">8日</option>
                        <option value="9">9日</option>
                        <option value="10">10日</option>
                        <option value="11">11日</option>
                        <option value="12">12日</option>
                        <option value="13">13日</option>
                        <option value="14">14日</option>
                        <option value="15">15日</option>
                        <option value="16">16日</option>
                        <option value="17">17日</option>
                        <option value="18">18日</option>
                        <option value="19">19日</option>
                        <option value="20">20日</option>
                        <option value="21">21日</option>
                        <option value="22">22日</option>
                        <option value="23">23日</option>
                        <option value="24">24日</option>
                        <option value="25">25日</option>
                        <option value="26">26日</option>
                        <option value="27">27日</option>
                        <option value="28">28日</option>
                        <option value="29">29日</option>
                        <option value="30">30日</option>
                        <option value="31">31日</option>
                    </select>
                </td>
            </tr>
        </table>
    </form>
    <br />
</div>
</body>
</html>

