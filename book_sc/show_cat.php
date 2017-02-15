<?php

/**
 * @author hongqiang
 * @copyright 2016 10.22 book_sc
 */

  include('book_sc_fns.php');
  
  session_start();
  
  $cat_id = $_GET['cat_id'];
  $name = get_category_name($cat_id); 
  
  do_html_header($name);
  
  $book_array = get_books($cat_id);
  
  display_books($book_array);
  
  if (isset($_SESSION['admin_user']))
  {
    display_button("index.php", "continue", "Continue Shopping");
    display_button("admin.php", "admin-menu", "Admin Menu");
    display_button("edit_category_form.php?catid = ".$cat_id, "edit-category", "Edit Category");
  }
  else
  {
    display_button("index.php", "continue-shopping", "Cotinue Shopping");
  }
  
  do_html_footer();

?>