<?php
/**
 * Created by PhpStorm.
 * User: hongqiang
 * Date: 2016/11/1
 * Time: 14:59
 */

require_once ('book_sc_fns.php');

session_start();

do_html_header("Add a book");

if (check_admin_user()){
    display_book_form();
    do_html_url("admin.php", "Back to adminstration menu");
}else{
    echo "<p>You are not authorized to enter the adminstration area.</p>";
}

do_html_footer();
?>