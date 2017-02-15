<?php

/**
 * @author hongqiang
 * @copyright 2016 10.22 book_sc
 */

  include('book_sc_fns.php');
  
  session_start();
  
  $isbn = $_GET['isbn'];
  
  $book = get_book_details($isbn);  
  do_html_header($book['title']);
  display_book_details($book);
  
  $target = "index.php";
  if ($book['cat_id'])
  {
    $target = "show_cat.php?cat_id=".$book['cat_id'];
  }
  
  if (check_admin_user())
  {
    display_button("edit_book_form.php?isbn=".$isbn, "edit-item", "Edit Item");
    display_button("admin.php", "admin-menu", "Admin Menu");
    display_button($target, "continue", "Cotinue");
  }
  else
  {
    display_button("show_cart.php?new=".$isbn, "add-to-cart", "Add ".$book['title']." To My Shopping Cart");
    display_button($target, "continue-shopping", "Continue Shopping");
  }


    do_html_footer();

?>