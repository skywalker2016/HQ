<?php
/**
 * Created by PhpStorm.
 * User: hongqiang
 * Date: 2016/11/1
 * Time: 14:43
 */

require_once ('book_sc_fns.php');

session_start();

do_html_header("Add a category");
if (check_admin_user()){
    display_category_form();
    do_html_url("admin.php", "Back to administration menu");
}else{
    echo "<p>You are not authorized to enter the administration area.</p>";
}

do_html_footer();
?>