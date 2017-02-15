<?php
/**
 * Created by PhpStorm.
 * User: hongqiang
 * Date: 2016/11/2
 * Time: 20:11
 */

require_once ('book_sc_fns.php');

session_start();

$old_user = $_SESSION['admin_user'];
unset($_SESSION['admin_user']);
session_destroy();

do_html_header("Logging out");

if (!empty($old_user)){
    echo "<p>Logged out.</p>";
    do_html_url("login.php", "Login");
}else{
    echo "<P>You were not logged in, and so have not  logged out.</P>";
    do_html_url("login.php", "Login");
}

do_html_footer();

?>