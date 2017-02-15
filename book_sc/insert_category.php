<?php

// include function files for this application
require_once('book_sc_fns.php');
session_start();

do_html_header("Adding a category");
if (check_admin_user()) {
  if (filled_out($_POST))   {
    $cat_name = $_POST['cat_name'];
    if(insert_category($cat_name)) {
      echo "<p>Category \"".$cat_name."\" was added to the database.</p>";
    } else {
      echo "<p>Category \"".$cat_name."\" could not be added to the database.</p>";
    }
  } else {
    echo "<p>You have not filled out the form.  Please try again.</p>";
  }
  do_html_url('admin.php', 'Back to administration menu');
} else {
  echo "<p>You are not authorised to view this page.</p>";
}

do_html_footer();

?>
