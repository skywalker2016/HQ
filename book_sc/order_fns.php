<?php

/**
 * @author hongqiang
 * @copyright 2016 10.25 book_sc
 */

  function process_card($card_details)
  {
    // connect to payment gateway or
    // use gpg to encrypt and mail or
    // store in DB if you really want to
    return true;
  }
  
  function insert_order($order_details)
  {
    // extract order_details out as variable
    extract($order_details);
    
    if ((!$ship_name) && (!$ship_address) && (!$ship_city) && (!$ship_state) && (!$ship_zip) && (!$ship_country))
    {
        $ship_name = $name;
        $ship_address = $address;
        $ship_city = $city;
        $ship_state = $state;
        $ship_zip = $zip;
        $ship_country = $country;
    }
    
    $conn = db_connect();
    
    // we want to insert the order as a transaction
    // start one by turning off autocommit
    $conn -> autocommit(false);
    
    // insert customer address
    $query = "select customer_id from customers where
              name = '".$name."' and address = '".$address."'
              and city = '".$city."' and states = '".$state."'
              and zip = '".$zip."' and country = '".$country."'";
              
    $result = $conn -> query($query);
    
    if ($result -> num_rows > 0)
    {
        $customer = $result -> fetch_object();
        $customer_id = $customer -> customer_id;
    }
    else
    {
        $query = "insert into customers values
                  ('', '".$name."', '".$address."', '".$city."', '".$state."', '".$zip."', '".$country."')";
        $result = $conn -> query($query);
        
        if (!$result)
        {
            return false;
        }
    }
    
    $customer_id = $conn -> insert_id;
    
    $date = date("Y-m-d");
    
    $query = "insert into orders values
              ('', '".$customer_id."', '".$_SESSION['total_price']."',
               '".$date."', '".PARTIAL."', 
               '".$ship_name."', '".$ship_address."', '".$ship_city."',
               '".$ship_state."', '".$ship_zip."', '".$ship_country."')";
    
    $result = $conn -> query($query);
    if (!$result)
    {
        return false;
    }
    
    $query = "select order_id from orders where
                 customer_id = '".$customer_id."' and
                 amount > (".$_SESSION['total_price']."-.001) and
                 amount < (".$_SESSION['total_price']."+.001) and
                 date = '".$date."' and
                 order_status = 'PARTIAT' and
                 ship_name = '".$ship_name."' and
                 ship_address = '".$ship_address."' and
                 ship_city = '".$ship_city."' and
                 ship_state = '".$ship_state."' and
                 ship_zip = '".$ship_zip."' and
                 ship_country = '".$ship_country."'";
                 
    $result = $conn -> query($query);
    
    if ($result -> num_rows > 0)
    {
        $order = $result -> fetch_object();
        $order_id = $order -> order_id;
    }
    else
    {
        return false;
    }
    
    // insert each book
    foreach ($_SESSION['cart'] as $isbn => $quantity)
    {
        $detail = get_book_details($isbn);
        $query = "delete from order_items where
                  order_id = '".$order_id."' and isbn = '".$isbn."'";
        $result = $conn -> query($query);
        $query = "insert into order_items values
                  ('".$order_id."', '".$isbn."', ".$detail['price'].", $quantity)";
        $result = $conn -> query($query);
        if (!$result)
        {
            return false;
        }
    }
    
    // end transaction
    $conn -> commit();
    $conn -> autocommit(true);
    
    return $order_id;
  }

?>