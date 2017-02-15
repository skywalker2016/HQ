<?php
/**
 * Created by PhpStorm.
 * User: hongqiang
 * Date: 2016/11/1
 * Time: 11:02
 */

  require_once('book_sc_fns.php');

  do_html_header("Adminstration");

  display_login_form();

  do_html_url("register_form.php", "Register a new");

  do_html_footer();

?>