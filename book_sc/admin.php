<?php
/**
 * Created by PhpStorm.
 * User: hongqiang
 * Date: 2016/11/1
 * Time: 12:32
 */

require_once('book_sc_fns.php');
session_start();

if (($_POST['username']) && ($_POST['passwd']))
{
    $username = $_POST['username'];
    $passwd = $_POST['passwd'];

    if (login($username, $passwd))
    {
        $_SESSION['admin_user'] = $username;
    }
    else
    {
        do_html_header('Problem:');
        echo "<p>You could not be logged in.<br/>
              You must be logged in to view this page.</p>";
        do_html_url('login.php', 'Login');
        do_html_footer();
        exit;
    }
}

do_html_header("Adminstration");

if (check_admin_user())
{
    display_admin_menu();
}
else
{
    echo "<p>You are not authorized to enter the adminstration area.</p>";
}

do_html_footer();
?>