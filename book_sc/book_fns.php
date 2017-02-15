<?php

/**
 * @author hongqiang
 * @copyright 2016 book_sr 10.21
 */
 
  function get_categories()
  {
    $conn = db_connect();
    $query = "select cat_id, cat_name from categories";
    $result = @$conn -> query($query);
    if (!result)
    {
        return false;
    }
    $num_cats = @$result ->num_rows;
    if ($num_cats == 0)
    {
        return false;
    }
    $result = db_result_to_array($result);
    return $result;
  }

  function get_category_name($cat_id)
  {
    $conn = db_connect();
    $query = "select cat_name from categories where cat_id = '".$cat_id."'";
    $result = @$conn -> query($query);
    
    if (!$result)
    {
        return false;
    }
    $num_cats = @$result -> num_rows;
    if ($num_cats == 0)
    {
        return false;
    }
    $row = $result -> fetch_object();
    return $row -> cat_name;
  }
  
  function get_books($cat_id)
  {
    if ((!$cat_id) || ($cat_id == ''))
    {
        return false;
    }
    
    $conn = db_connect();
    $query = "select * from books where cat_id = '".$cat_id."'";
    $result = @$conn -> query($query);
    if (!$result)
    {
        return false;
    }
    $num_books = @$result -> num_rows;
    if ($num_books == 0)
    {
        return false;
    }
    $result = db_result_to_array($result);
    return $result;
  }
  
  function get_book_details($isbn)
  {
    if ((!$isbn) || ($isbn == ''))
    {
        return false;
    }
    
    $conn = db_connect();
    $query = "select * from books where isbn = '".$isbn."'";
    $result = @$conn -> query($query);
    if (!$result)
    {
        return false;
    }
    $result = @$result -> fetch_assoc();
    return $result;
  }
  
  function calculate_price($cart)
  {
    $price = 0.0;
    if (is_array($cart))
    {
        $conn = db_connect();
        foreach($cart as $isbn => $qty)
        {
            $query = "select price from books where isbn='".$isbn."'";
            $result = $conn -> query($query);
            if ($result)
            {
                $item = $result -> fetch_object();
                $item_price = $item -> price;
                $price += $item_price*$qty;
            }
        }
    }
    return $price;
  }
  
  function calculate_items($cart)
  {
    $items = 0;
    if (is_array($cart))
    {
        foreach($cart as $isbn => $qty)
        {
            $items += $qty;
        }
    }
    return $items;
  }
  
  function calculate_shipping_cost()
  {
    return 20.00;
  }
?>