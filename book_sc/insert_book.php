<?php
/**
 * Created by PhpStorm.
 * User: hongqiang
 * Date: 2016/11/2
 * Time: 20:25
 */

require_once ('book_sc_fns.php');

session_start();

do_html_header("Add a book");
if (check_admin_user()){
    if (filled_out($_POST)){
        $isbn = $_POST['isbn'];
        $title = $_POST['title'];
        $author = $_POST['author'];
        $cat_id = $_POST['cat_id'];
        $price = $_POST['price'];
        $description = $_POST['description'];

        if(insert_book($isbn, $title, $author, $cat_id, $price, $description)) {
            echo "<p>Book <em>".stripslashes($title)."</em> was added to the database.</p>";
        } else {
            echo "<p>Book <em>".stripslashes($title)."</em> could not be added to the database.</p>";
        }
    } else {
        echo "<p>You have not filled out the form.  Please try again.</p>";
    }

    do_html_url("admin.php", "Back to administration menu");
    }else {
    echo "<p>You are not authorised to view this page.</p>";
}

do_html_footer();

?>

