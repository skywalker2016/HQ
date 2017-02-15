<?php
/**
 * Created by PhpStorm.
 * User: hongqiang
 * Date: 2016/11/2
 * Time: 18:24
 */

require_once('book_sc_fns.php');

$username = $_POST['username'];
$passwd = $_POST['passwd'];
$passwd2 = $_POST['passwd2'];

session_start();

try{
    if (!filled_out($_POST)){
        throw new Exception('You have not filled the form out - Please go back and try again.');
    }
    if ($passwd != $passwd2){
        throw new Exception('The password you entered do not match - Please go back and try again.');
    }
    if ((strlen($passwd)<6) && (strlen($passwd)>16)){
        throw new Exception('Your password must be between 6 and 16 characters Please go back and try again.');
    }

    register($username, $passwd);

    $_SESSION['admin_user'] = $username;

    do_html_header('Registration successful');
    echo 'Your registration was successful.  Go to the members page to start setting up your bookmarks!';
    do_html_url('admin.php', 'Go to admin page');

    // end page
    do_html_footer();
}
catch (Exception $e) {
    do_html_header('Problem:');
    echo $e->getMessage();
    do_html_footer();
    exit;
}
?>
