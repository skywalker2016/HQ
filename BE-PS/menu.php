<?php
/**
 * Created by PhpStorm.
 * User: hongqiang
 * Date: 2016/12/11
 * Time: 11:00
 */


print ("<br /><br />");
$name_page = $_SESSION['name_page'];
$permission = $_SESSION['permission'];
$username = $_SESSION['username'];

if ($username == 'root'){
    /*---------home---------------------------------------------------------------------------------------------*/
    if ($name_page == 'home') {
        print ("<div id='menu'>");
        print ("<a href='home.php?start=2' style='text-decoration:none'><font color='#A6D1EC'> 首页 </font></a>");
        print ("<br /><hr id='hr_menu' size='3' />");
        print ("</div>");
        print ("<br />");

        print ("<div id='menu'>");
        print ("<a href='home.php?start=3' style='text-decoration:none'><font color='#A6D1EC'> 胎儿心电 </font></a>");
        print ("<br /><hr id='hr_menu' size='3' />");
        print ("</div>");
        print ("<br />");

        print ("<div id='menu'>");
        print ("<a href='home.php?start=4' style='text-decoration:none'><font color='#A6D1EC'> 房颤 </font></a>");
        print ("<br /><hr id='hr_menu' size='3' />");
        print ("</div>");
        print ("<br />");

        print ("<div id='menu'>");
        print ("<a href='home.php?start=5' style='text-decoration:none'><font color='#A6D1EC'> 跌倒 </font></a>");
        print ("<br /><hr id='hr_menu' size='3' />");
        print ("</div>");
        print ("<br />");

        if ($permission == 0) {
            print ("<div id='menu'>");
            print ("<a href='home.php?start=6' style='text-decoration:none'><font color='#A6D1EC'> 添加新数据 </font></a>");
            print ("<br /><hr id='hr_menu' size='3' />");
            print ("</div>");
            print ("<br />");
        } else {
            print ("<div id='menu_permission3'>");
            print ("<font color='#A6D1EC'>添加新数据</font>");
            print ("<br><hr id='hr_menu' size='3'>");
            print ("</div>");
            print ("<br>");
        }

        print ("<div id='menu'>");
        print ("<a href='home.php?start=7' style='text-decoration:none'><font color='#A6D1EC'> 修改权限 </font></a>");
        print ("<br /><hr id='hr_menu' size='3' />");
        print ("</div>");
        print ("<br />");

        print ("<div id='menu'>");
        print ("<a href='index.php'><font color='#A6D1EC'> 退出 </font> </a>");
        print ("<br><hr id='hr_menu' size='3'>");
        print ("</div>");

    }

    /*---------ECG---------------------------------------------------------------------------------------------*/
    if ($name_page == 'ECG') {
        print ("<div id='menu'>");
        print ("<a href='home.php?start=2' style='text-decoration:none'><font color='#A6D1EC'> 首页 </font></a>");
        print ("<br /><hr id='hr_menu' size='3' />");
        print ("</div>");
        print ("<br />");

        print ("<div id='menu'>");
        print ("<font color='#A6D1EC'> 胎儿心电 </font>");
        print ("<br /><hr id='hr_menu' size='3' />");
        print ("</div>");
        print ("<br />");

        print ("<div id='menu'>");
        print ("<a href='home.php?start=4' style='text-decoration:none'><font color='#A6D1EC'> 房颤 </font></a>");
        print ("<br /><hr id='hr_menu' size='3' />");
        print ("</div>");
        print ("<br />");

        print ("<div id='menu'>");
        print ("<a href='home.php?start=5' style='text-decoration:none'><font color='#A6D1EC'> 跌倒 </font></a>");
        print ("<br /><hr id='hr_menu' size='3' />");
        print ("</div>");
        print ("<br />");

        if ($permission == 0) {
            print ("<div id='menu'>");
            print ("<a href='home.php?start=6' style='text-decoration:none'><font color='#A6D1EC'> 添加新数据 </font></a>");
            print ("<br /><hr id='hr_menu' size='3' />");
            print ("</div>");
            print ("<br />");
        } else {
            print ("<div id='menu_permission3'>");
            print ("<font color='#A6D1EC'>添加新数据</font>");
            print ("<br><hr id='hr_menu' size='3'>");
            print ("</div>");
            print ("<br>");
        }

        print ("<div id='menu'>");
        print ("<a href='home.php?start=7' style='text-decoration:none'><font color='#A6D1EC'> 修改权限 </font></a>");
        print ("<br /><hr id='hr_menu' size='3' />");
        print ("</div>");
        print ("<br />");

        print ("<div id='menu'>");
        print ("<a href='index.php'><font color='#A6D1EC'> 退出 </font> </a>");
        print ("<br><hr id='hr_menu' size='3'>");
        print ("</div>");

    }

    /*---------Afib---------------------------------------------------------------------------------------------*/
    if ($name_page == 'Afib') {
        print ("<div id='menu'>");
        print ("<a href='home.php?start=2' style='text-decoration:none'><font color='#A6D1EC'> 首页 </font></a>");
        print ("<br /><hr id='hr_menu' size='3' />");
        print ("</div>");
        print ("<br />");

        print ("<div id='menu'>");
        print ("<a href='home.php?start=3' style='text-decoration:none'><font color='#A6D1EC'> 胎儿心电 </font></a>");
        print ("<br /><hr id='hr_menu' size='3' />");
        print ("</div>");
        print ("<br />");

        print ("<div id='menu'>");
        print ("<font color='#A6D1EC'> 房颤 </font>");
        print ("<br /><hr id='hr_menu' size='3' />");
        print ("</div>");
        print ("<br />");

        print ("<div id='menu'>");
        print ("<a href='home.php?start=5' style='text-decoration:none'><font color='#A6D1EC'> 跌倒 </font></a>");
        print ("<br /><hr id='hr_menu' size='3' />");
        print ("</div>");
        print ("<br />");

        if ($permission == 0) {
            print ("<div id='menu'>");
            print ("<a href='home.php?start=6' style='text-decoration:none'><font color='#A6D1EC'> 添加新数据 </font></a>");
            print ("<br /><hr id='hr_menu' size='3' />");
            print ("</div>");
            print ("<br />");
        } else {
            print ("<div id='menu_permission3'>");
            print ("<font color='#A6D1EC'>添加新数据</font>");
            print ("<br><hr id='hr_menu' size='3'>");
            print ("</div>");
            print ("<br>");
        }

        print ("<div id='menu'>");
        print ("<a href='home.php?start=7' style='text-decoration:none'><font color='#A6D1EC'> 修改权限 </font></a>");
        print ("<br /><hr id='hr_menu' size='3' />");
        print ("</div>");
        print ("<br />");

        print ("<div id='menu'>");
        print ("<a href='index.php'><font color='#A6D1EC'> 退出 </font> </a>");
        print ("<br><hr id='hr_menu' size='3'>");
        print ("</div>");

    }

    /*---------Tumble---------------------------------------------------------------------------------------------*/
    if ($name_page == 'Tumble') {
        print ("<div id='menu'>");
        print ("<a href='home.php?start=2' style='text-decoration:none'><font color='#A6D1EC'> 首页 </font></a>");
        print ("<br /><hr id='hr_menu' size='3' />");
        print ("</div>");
        print ("<br />");

        print ("<div id='menu'>");
        print ("<a href='home.php?start=3' style='text-decoration:none'><font color='#A6D1EC'> 胎儿心电 </font></a>");
        print ("<br /><hr id='hr_menu' size='3' />");
        print ("</div>");
        print ("<br />");

        print ("<div id='menu'>");
        print ("<a href='home.php?start=4' style='text-decoration:none'><font color='#A6D1EC'> 房颤 </font></a>");
        print ("<br /><hr id='hr_menu' size='3' />");
        print ("</div>");
        print ("<br />");

        print ("<div id='menu'>");
        print ("<font color='#A6D1EC'> 跌倒 </font>");
        print ("<br /><hr id='hr_menu' size='3' />");
        print ("</div>");
        print ("<br />");

        if ($permission == 0) {
            print ("<div id='menu'>");
            print ("<a href='home.php?start=6' style='text-decoration:none'><font color='#A6D1EC'> 添加新数据 </font></a>");
            print ("<br /><hr id='hr_menu' size='3' />");
            print ("</div>");
            print ("<br />");
        } else {
            print ("<div id='menu_permission3'>");
            print ("<font color='#A6D1EC'>添加新数据</font>");
            print ("<br><hr id='hr_menu' size='3'>");
            print ("</div>");
            print ("<br>");
        }

        print ("<div id='menu'>");
        print ("<a href='home.php?start=7' style='text-decoration:none'><font color='#A6D1EC'> 修改权限 </font></a>");
        print ("<br /><hr id='hr_menu' size='3' />");
        print ("</div>");
        print ("<br />");

        print ("<div id='menu'>");
        print ("<a href='index.php'><font color='#A6D1EC'> 退出 </font> </a>");
        print ("<br><hr id='hr_menu' size='3'>");
        print ("</div>");

    }

    /*---------Add---------------------------------------------------------------------------------------------*/
    if ($name_page == 'Add') {
        print ("<div id='menu'>");
        print ("<a href='home.php?start=2' style='text-decoration:none'><font color='#A6D1EC'> 首页 </font></a>");
        print ("<br /><hr id='hr_menu' size='3' />");
        print ("</div>");
        print ("<br />");

        print ("<div id='menu'>");
        print ("<a href='home.php?start=3' style='text-decoration:none'><font color='#A6D1EC'> 胎儿心电 </font></a>");
        print ("<br /><hr id='hr_menu' size='3' />");
        print ("</div>");
        print ("<br />");

        print ("<div id='menu'>");
        print ("<a href='home.php?start=4' style='text-decoration:none'><font color='#A6D1EC'> 房颤 </font></a>");
        print ("<br /><hr id='hr_menu' size='3' />");
        print ("</div>");
        print ("<br />");

        print ("<div id='menu'>");
        print ("<a href='home.php?start=5' style='text-decoration:none'><font color='#A6D1EC'> 跌倒 </font></a>");
        print ("<br /><hr id='hr_menu' size='3' />");
        print ("</div>");
        print ("<br />");


        print ("<div id='menu_permission3'>");
        print ("<font color='#A6D1EC'>添加新数据</font>");
        print ("<br><hr id='hr_menu' size='3'>");
        print ("</div>");
        print ("<br>");


        print ("<div id='menu'>");
        print ("<a href='home.php?start=7' style='text-decoration:none'><font color='#A6D1EC'> 修改权限 </font></a>");
        print ("<br /><hr id='hr_menu' size='3' />");
        print ("</div>");
        print ("<br />");

        print ("<div id='menu'>");
        print ("<a href='index.php'><font color='#A6D1EC'> 退出 </font> </a>");
        print ("<br><hr id='hr_menu' size='3'>");
        print ("</div>");

    }

    /*---------Alter---------------------------------------------------------------------------------------------*/
    if ($name_page == 'Alter') {
        print ("<div id='menu'>");
        print ("<a href='home.php?start=2' style='text-decoration:none'><font color='#A6D1EC'> 首页 </font></a>");
        print ("<br /><hr id='hr_menu' size='3' />");
        print ("</div>");
        print ("<br />");

        print ("<div id='menu'>");
        print ("<a href='home.php?start=3' style='text-decoration:none'><font color='#A6D1EC'> 胎儿心电 </font></a>");
        print ("<br /><hr id='hr_menu' size='3' />");
        print ("</div>");
        print ("<br />");

        print ("<div id='menu'>");
        print ("<a href='home.php?start=4' style='text-decoration:none'><font color='#A6D1EC'> 房颤 </font></a>");
        print ("<br /><hr id='hr_menu' size='3' />");
        print ("</div>");
        print ("<br />");

        print ("<div id='menu'>");
        print ("<a href='home.php?start=5' style='text-decoration:none'><font color='#A6D1EC'> 跌倒 </font></a>");
        print ("<br /><hr id='hr_menu' size='3' />");
        print ("</div>");
        print ("<br />");

        if ($permission == 0) {
            print ("<div id='menu'>");
            print ("<a href='home.php?start=6' style='text-decoration:none'><font color='#A6D1EC'> 添加新数据 </font></a>");
            print ("<br /><hr id='hr_menu' size='3' />");
            print ("</div>");
            print ("<br />");
        } else {
            print ("<div id='menu_permission3'>");
            print ("<font color='#A6D1EC'>添加新数据</font>");
            print ("<br><hr id='hr_menu' size='3'>");
            print ("</div>");
            print ("<br>");
        }

        print ("<div id='menu'>");
        print ("<font color='#A6D1EC'> 修改权限 </font>");
        print ("<br /><hr id='hr_menu' size='3' />");
        print ("</div>");
        print ("<br />");

        print ("<div id='menu'>");
        print ("<a href='index.php'><font color='#A6D1EC'> 退出 </font> </a>");
        print ("<br><hr id='hr_menu' size='3'>");
        print ("</div>");

    }
}else {
    /*---------home---------------------------------------------------------------------------------------------*/
    if ($name_page == 'home') {
        print ("<div id='menu'>");
        print ("<a href='home.php?start=2' style='text-decoration:none'><font color='#A6D1EC'> 首页 </font></a>");
        print ("<br /><hr id='hr_menu' size='3' />");
        print ("</div>");
        print ("<br />");

        print ("<div id='menu'>");
        print ("<a href='home.php?start=3' style='text-decoration:none'><font color='#A6D1EC'> 胎儿心电 </font></a>");
        print ("<br /><hr id='hr_menu' size='3' />");
        print ("</div>");
        print ("<br />");

        print ("<div id='menu'>");
        print ("<a href='home.php?start=4' style='text-decoration:none'><font color='#A6D1EC'> 房颤 </font></a>");
        print ("<br /><hr id='hr_menu' size='3' />");
        print ("</div>");
        print ("<br />");

        print ("<div id='menu'>");
        print ("<a href='home.php?start=5' style='text-decoration:none'><font color='#A6D1EC'> 跌倒 </font></a>");
        print ("<br /><hr id='hr_menu' size='3' />");
        print ("</div>");
        print ("<br />");

        if ($permission == 0) {
            print ("<div id='menu'>");
            print ("<a href='home.php?start=6' style='text-decoration:none'><font color='#A6D1EC'> 添加新数据 </font></a>");
            print ("<br /><hr id='hr_menu' size='3' />");
            print ("</div>");
            print ("<br />");
        } else {
            print ("<div id='menu_permission3'>");
            print ("<font color='#A6D1EC'>添加新数据</font>");
            print ("<br><hr id='hr_menu' size='3'>");
            print ("</div>");
            print ("<br>");
        }

        print ("<br /><br /><br />");
        print ("<div id='menu'>");
        print ("<a href='index.php'><font color='#A6D1EC'> 退出 </font> </a>");
        print ("<br><hr id='hr_menu' size='3'>");
        print ("</div>");

    }

    /*---------ECG---------------------------------------------------------------------------------------------*/
    if ($name_page == 'ECG') {
        print ("<div id='menu'>");
        print ("<a href='home.php?start=2' style='text-decoration:none'><font color='#A6D1EC'> 首页 </font></a>");
        print ("<br /><hr id='hr_menu' size='3' />");
        print ("</div>");
        print ("<br />");

        print ("<div id='menu'>");
        print ("<font color='#A6D1EC'> 胎儿心电 </font>");
        print ("<br /><hr id='hr_menu' size='3' />");
        print ("</div>");
        print ("<br />");

        print ("<div id='menu'>");
        print ("<a href='home.php?start=4' style='text-decoration:none'><font color='#A6D1EC'> 房颤 </font></a>");
        print ("<br /><hr id='hr_menu' size='3' />");
        print ("</div>");
        print ("<br />");

        print ("<div id='menu'>");
        print ("<a href='home.php?start=5' style='text-decoration:none'><font color='#A6D1EC'> 跌倒 </font></a>");
        print ("<br /><hr id='hr_menu' size='3' />");
        print ("</div>");
        print ("<br />");

        if ($permission == 0) {
            print ("<div id='menu'>");
            print ("<a href='home.php?start=6' style='text-decoration:none'><font color='#A6D1EC'> 添加新数据 </font></a>");
            print ("<br /><hr id='hr_menu' size='3' />");
            print ("</div>");
            print ("<br />");
        } else {
            print ("<div id='menu_permission3'>");
            print ("<font color='#A6D1EC'>添加新数据</font>");
            print ("<br><hr id='hr_menu' size='3'>");
            print ("</div>");
            print ("<br>");
        }

        print ("<br /><br /><br />");
        print ("<div id='menu'>");
        print ("<a href='index.php'><font color='#A6D1EC'> 退出 </font> </a>");
        print ("<br><hr id='hr_menu' size='3'>");
        print ("</div>");

    }

    /*---------Afib---------------------------------------------------------------------------------------------*/
    if ($name_page == 'Afib') {
        print ("<div id='menu'>");
        print ("<a href='home.php?start=2' style='text-decoration:none'><font color='#A6D1EC'> 首页 </font></a>");
        print ("<br /><hr id='hr_menu' size='3' />");
        print ("</div>");
        print ("<br />");

        print ("<div id='menu'>");
        print ("<a href='home.php?start=3' style='text-decoration:none'><font color='#A6D1EC'> 胎儿心电 </font></a>");
        print ("<br /><hr id='hr_menu' size='3' />");
        print ("</div>");
        print ("<br />");

        print ("<div id='menu'>");
        print ("<font color='#A6D1EC'> 房颤 </font>");
        print ("<br /><hr id='hr_menu' size='3' />");
        print ("</div>");
        print ("<br />");

        print ("<div id='menu'>");
        print ("<a href='home.php?start=5' style='text-decoration:none'><font color='#A6D1EC'> 跌倒 </font></a>");
        print ("<br /><hr id='hr_menu' size='3' />");
        print ("</div>");
        print ("<br />");

        if ($permission == 0) {
            print ("<div id='menu'>");
            print ("<a href='home.php?start=6' style='text-decoration:none'><font color='#A6D1EC'> 添加新数据 </font></a>");
            print ("<br /><hr id='hr_menu' size='3' />");
            print ("</div>");
            print ("<br />");
        } else {
            print ("<div id='menu_permission3'>");
            print ("<font color='#A6D1EC'>添加新数据</font>");
            print ("<br><hr id='hr_menu' size='3'>");
            print ("</div>");
            print ("<br>");
        }

        print ("<br /><br /><br />");
        print ("<div id='menu'>");
        print ("<a href='index.php'><font color='#A6D1EC'> 退出 </font> </a>");
        print ("<br><hr id='hr_menu' size='3'>");
        print ("</div>");

    }

    /*---------Tumble---------------------------------------------------------------------------------------------*/
    if ($name_page == 'Tumble') {
        print ("<div id='menu'>");
        print ("<a href='home.php?start=2' style='text-decoration:none'><font color='#A6D1EC'> 首页 </font></a>");
        print ("<br /><hr id='hr_menu' size='3' />");
        print ("</div>");
        print ("<br />");

        print ("<div id='menu'>");
        print ("<a href='home.php?start=3' style='text-decoration:none'><font color='#A6D1EC'> 胎儿心电 </font></a>");
        print ("<br /><hr id='hr_menu' size='3' />");
        print ("</div>");
        print ("<br />");

        print ("<div id='menu'>");
        print ("<a href='home.php?start=4' style='text-decoration:none'><font color='#A6D1EC'> 房颤 </font></a>");
        print ("<br /><hr id='hr_menu' size='3' />");
        print ("</div>");
        print ("<br />");

        print ("<div id='menu'>");
        print ("<font color='#A6D1EC'> 跌倒 </font>");
        print ("<br /><hr id='hr_menu' size='3' />");
        print ("</div>");
        print ("<br />");

        if ($permission == 0) {
            print ("<div id='menu'>");
            print ("<a href='home.php?start=6' style='text-decoration:none'><font color='#A6D1EC'> 添加新数据 </font></a>");
            print ("<br /><hr id='hr_menu' size='3' />");
            print ("</div>");
            print ("<br />");
        } else {
            print ("<div id='menu_permission3'>");
            print ("<font color='#A6D1EC'>添加新数据</font>");
            print ("<br><hr id='hr_menu' size='3'>");
            print ("</div>");
            print ("<br>");
        }

        print ("<br /><br /><br />");
        print ("<div id='menu'>");
        print ("<a href='index.php'><font color='#A6D1EC'> 退出 </font> </a>");
        print ("<br><hr id='hr_menu' size='3'>");
        print ("</div>");

    }

    /*---------Add---------------------------------------------------------------------------------------------*/
    if ($name_page == 'Add') {
        print ("<div id='menu'>");
        print ("<a href='home.php?start=2' style='text-decoration:none'><font color='#A6D1EC'> 首页 </font></a>");
        print ("<br /><hr id='hr_menu' size='3' />");
        print ("</div>");
        print ("<br />");

        print ("<div id='menu'>");
        print ("<a href='home.php?start=3' style='text-decoration:none'><font color='#A6D1EC'> 胎儿心电 </font></a>");
        print ("<br /><hr id='hr_menu' size='3' />");
        print ("</div>");
        print ("<br />");

        print ("<div id='menu'>");
        print ("<a href='home.php?start=4' style='text-decoration:none'><font color='#A6D1EC'> 房颤 </font></a>");
        print ("<br /><hr id='hr_menu' size='3' />");
        print ("</div>");
        print ("<br />");

        print ("<div id='menu'>");
        print ("<a href='home.php?start=5' style='text-decoration:none'><font color='#A6D1EC'> 跌倒 </font></a>");
        print ("<br /><hr id='hr_menu' size='3' />");
        print ("</div>");
        print ("<br />");


        print ("<div id='menu_permission3'>");
        print ("<font color='#A6D1EC'>添加新数据</font>");
        print ("<br><hr id='hr_menu' size='3'>");
        print ("</div>");
        print ("<br>");


        print ("<br /><br /><br />");
        print ("<div id='menu'>");
        print ("<a href='index.php'><font color='#A6D1EC'> 退出 </font> </a>");
        print ("<br><hr id='hr_menu' size='3'>");
        print ("</div>");

    }
}
?>