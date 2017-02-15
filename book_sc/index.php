<?php

/**
 * @author hongqiang
 * @copyright 2016 book_sc 10.21 列出了数据库中所有的目录
 */

  include('book_sc_fns.php');
  
  //涉及到右上角有一个购物车的链接，所以需要开启一个会话
  session_start();
  
  do_html_header("Welcome to Book-O-Rama");
  
  echo "<p>Please choose a category:</p>";
  
  //从数据库中获取所有的目录
  $cat_array = get_categories();
  
  //显示目录列表
  display_categories($cat_array);
  
  //如果是管理员身份登录，则提供一些不同的导航选项
  if (isset($_SESSION['admin_user']))
  {
    display_button("admin.php", "admin-menu", "Admin Menu");
  }
  
  do_html_footer();


?>