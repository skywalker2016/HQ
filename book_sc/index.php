<?php

/**
 * @author hongqiang
 * @copyright 2016 book_sc 10.21 �г������ݿ������е�Ŀ¼
 */

  include('book_sc_fns.php');
  
  //�漰�����Ͻ���һ�����ﳵ�����ӣ�������Ҫ����һ���Ự
  session_start();
  
  do_html_header("Welcome to Book-O-Rama");
  
  echo "<p>Please choose a category:</p>";
  
  //�����ݿ��л�ȡ���е�Ŀ¼
  $cat_array = get_categories();
  
  //��ʾĿ¼�б�
  display_categories($cat_array);
  
  //����ǹ���Ա��ݵ�¼�����ṩһЩ��ͬ�ĵ���ѡ��
  if (isset($_SESSION['admin_user']))
  {
    display_button("admin.php", "admin-menu", "Admin Menu");
  }
  
  do_html_footer();


?>