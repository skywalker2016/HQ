<?php

/**
 * @author hongqiang
 * @copyright 2016 book_sc 10.21
 */

  function db_connect()
  {
    $result = new mysqli('localhost', 'root', '322816', 'book_sc');
    if (!$result)
    {
        return false;  
    }
    $result -> autocommit(true);   //自动提交(真)
    return $result;
  }
  
  function db_result_to_array($result)
  {
    $res_array = array();
    
    for ($count = 0; $row = $result -> fetch_assoc(); $count++)
    {    
        $res_array[$count] = $row;
    }
    return $res_array;
  }

  function filled_out($form_vars) {
    // test that each variable has a value
    foreach ($form_vars as $key => $value) {
        if ((!isset($key)) || ($value == '')) {
            return false;
        }
    }
    return true;
}

?>