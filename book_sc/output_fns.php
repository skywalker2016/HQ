<?php

/**
 * @author hongqiang
 * @copyright 2016 book_sc 10.21
 */

  function do_html_header($title = '')
  {
    if (!$_SESSION['items'])
    {
        $_SESSION['items'] = '0';
    }
    if (!$_SESSION['total_price'])
    {
        $_SESSION['total_price'] = '0.00';
    }
?>
  <html>
  <head>
    <title><?php echo $title; ?></title>
    <style>
      h2 { font-family: Arial, Helvetica, sans-serif;
           font-size: 22px;
           color: red;
           margin: 6px}
      body { font-family: Arial, Helvetica, sans-serif;
             font-size: 13px}
      li, td { font-family: Arial, Helvetica, sans-serif;
               font-size: 13px}
      hr { color: #FF0000;
           width = 100%;
           text-align = center}   
      a { color: #000000}
    </style>
  </head>
  <body>
    <table width="100%" border="0" cellspacing="0" bgcolor="#cccccc">
      <tr>
        <td rowspan="2">
          <a href="index.php"><img src="images/Book-O-Rama.gif" alt="Bookorama"
             border="0" align="left" valign="bottom" height="55" width="325" /></a>
        </td>
        <td align="right" valign="bottom">
        <?php
          if (isset($_SESSION['admin_user']))
          {
            echo "$nbsp";
          }
          else
          {
            echo "Total Items = ".$_SESSION['items'];
          }
        ?>
        </td>  
        <td align="right" rowspan="2" width="135">
        <?php
          if (isset($_SESSION['admin_user']))
          {
            display_button('logout.php', 'log-out', 'Log Out');
          }
          else
          {
            display_button('show_cart.php', 'view-cart', 'View Your Shopping Cart');
          }
        ?>
        </td>
      </tr>
      <tr>
        <td align="right" valign="top">
        <?php
          if (isset($_SESSION['admin_user']))
          {
            echo "$nbsp";
          }
          else
          {
            echo "Total Price = $".number_format($_SESSION['total_price'], 2);
          }
        ?>
        </td>
      </tr>
    </table>
    <?php
      if ($title)
      {
        do_html_heading($title);
      }
  }
  
  function do_html_footer()
  {
    ?>
     </body>
     </html>
    <?php
  }

  function do_html_heading($heading)
  {
    ?>
      <h2><?php echo $heading; ?></h2>
    <?php
  }
  
  function display_categories($cat_array)  
  {
    if (!is_array($cat_array))
    {
        echo "<p>No categories currently available</p>";
        return;
    }
    echo "<ul>"; 
    foreach ($cat_array as $row)
    {
        $url = "show_cat.php?cat_id=".$row['cat_id'];
        $title = $row['cat_name'];
        echo "<li>";
        do_html_url($url, $title);
        echo "</li>";
    }
    echo "</ul>";
    echo "<hr />";
  }
    
  function do_html_url($url, $name)
  {
    ?>
    <a href="<?php echo $url; ?>"><?php echo $name; ?></a><br />
    <?php
  }
  
  function display_books($book_array)
  {
    if (!is_array($book_array))
    {
        echo "<p>No books currently available in this category</p>";
    }
    else
    {
        echo "<table width=\"100%\" border=\"0\">";
        
        foreach ($book_array as $row)
        {
            $url = "show_book.php?isbn=".$row['isbn'];
            echo "<tr><td>";
            if (@file_exists("images/".$row['isbn'].".jpg"))
            {
                $title = "<img src=\"images/".$row['isbn'].".jpg\" style=\"border:1px solid black\" />";
                do_html_url($url, $title);
            }
            else
            {
                echo "$nbsp";
            }
            echo "</td><td>";
            $title = $row['title']." by ".$row['author'];
            do_html_url($url, $title);
            echo "</td></tr>";
        }
        
        echo "</table>";
    }
    
    echo "<hr />";
  }
  
  function display_book_details($book)
  {
    if (is_array($book))
    {
        echo "<table><tr>"; 
        
        // չʾ��Ŀ��ͼƬ
        if (@file_exists("images/".$book['isbn'].".jpg"))
        {
            $size = getimagesize("images/".$book['isbn'].".jpg");
            if ($size[0] > 0 && $size[1] > 0)
            {
                echo "<td><img src=\"images/".$book['isbn'].".jpg\" style=\"border:1px solid balck\" /></td>";
            }
        }
        echo "<td><ul>";
        echo "<li><strong>Author:</strong>";
        echo $book['author'];
        echo "</li><li><strong>ISBN:</strong>";
        echo $book['isbn'];
        echo "</li><li><strong>Our Price:</strong>";
        echo number_format($book['price'], 2);
        echo "</li><li><strong>Description:</strong>";
        echo $book['description'];
        echo "</li></ul></td></tr></table>";
    }
    else
    {
        echo "<p>The details of this book cannot be displayed at this time.</p>";
    }
    echo "<hr />";
  }
  
  function display_button($target, $image, $alt)
   {
     echo "<div align=\"center\"><a href=\"".$target."\">
          <img src=\"images/".$image.".gif\"
           alt=\"".$alt."\" border=\"0\" height=\"50\"
           width=\"135\"/></a></div>";
   }
   
   function display_cart($cart, $change = true, $images = 1)
   {
    // display items in shopping cart
    // optionally allow changes (true or false)
    // optionally include images (1 - yes, 0 - no)
    
    echo "<table border=\"0\" width=\"100%\" cellspacing=\"0\">
          <form action=\"show_cart.php\" method=\"post\">
          <tr><th colspan=\"".(1+$images)."\" bgcolor=\"#cccccc\">Item</th>
          <th bgcolor=\"#cccccc\">Price</th>
          <th bgcolor=\"#cccccc\">Quantity</th>
          <th bgcolor=\"#cccccc\">Total</th>
          </tr>";
    
    // display each item as a table row
    foreach ($cart as $isbn => $qty)
    {
        $book = get_book_details($isbn);
        echo "<tr>";
        if ($images == true)
        {
            echo "<td align=\"left\">";
            if (file_exists("images/".$isbn.".jpg"))
            {
                $size = getimagesize("images/".$isbn.".jpg");
                if (($size[0] > 0) && ($size[1] > 0))
                {
                    echo "<img src=\"images/".$isbn.".jpg\"
                           style=\"border:2px solid black\"
                           width=\"".($size[0]/2)."\"
                           height=\"".($size[1]/2)."\" />";
                }
            }
                else
                {
                    echo "&nbsp";
                }
             echo "</td>";
            }
            echo "<td align=\"left\">
                  <a href=\"show_book.php?isbn=".$isbn."\">".$book['title']."</a>
                  by ".$book['author']."</td>
                  <td align=\"center\">\$".number_format($book['price'], 2)."</td>
                  <td align=\"center\">";
            
            // if we allow changes, quantities are in text boxs
            if ($change == true)
            {
                echo "<input type=\"text\" name=\"".$isbn."\" value=\"".$qty."\" size=\"3\" />";
            }
            else
            {
                echo $qty;
            }
            echo "</td><td align=\"center\">\$".number_format($book['price']*$qty, 2)."</td></tr>\n";
        }
        // display total row
        echo "<tr>
              <th colspan=\"".(2+$images)."\" bgcolor=\"#cccccc\">&nbsp;</td>
              <th align=\"center\"
              bgcolor=\"#cccccc\">".$_SESSION['items']."</th>
              <th align=\"center\" bgcolor=\"#cccccc\">\$".number_format($_SESSION['total_price'], 2)."
              </th>
              </tr>";
              
        // display save change button
        if ($change == true)
        {
            echo "<tr>
                  <td colspan=\"".(2+$images)."\">&nbsp;</td>
                  <td align=\"center\">
                     <input type=\"hidden\" name=\"save\" value=\"true\" />
                     <input type=\"image\" src=\"images/save-changes.gif\" border=\"0\" alt=\"Save Changes\" />
                     </td>
                     <td>&nbsp;</td>
                     </tr>";
        }
        echo "</form></table>";
    }
   
   function display_checkout_form()
   {
     ?>
     <br />
     <table border="0" width="100%" cellspacing="0">
     <form action="purchase.php" method="post">
     <tr><th colspan="2" bgcolor=#cccccc><strong>Your Details</strong></th></tr>
     <tr>
       <td>Name</td>
       <td><input type="text" name="name" value="" maxlength="40" size="40" /></td>
     </tr>
     <tr>
       <td>Address</td>
       <td><input type="text" name="address" value="" maxlength="40" size="40" /></td>
     </tr>
     <tr>
       <td>City/Suburb</td>
       <td><input type="text" name="city" value="" maxlength="20" size="40" /></td>
     </tr>
     <tr>
       <td>State/Province</td>
       <td><input type="text" name="state" value="" maxlength="20" size="40" /></td>
     </tr>
     <tr>
       <td>Postal Code or Zip Code</td>
       <td><input type="text" name="zip" value="" maxlength="10" size="40" /></td>
     </tr>
     <tr>
       <td>Country</td>
       <td><input type="text" name="country" value="" maxlength="20" size="40" /></td>
     </tr>
     <tr><th colspan="2" bgcolor=#cccccc><strong>Shipping Address (leave blank as above)</strong></th></tr>
     <tr>
       <td>Name</td>
       <td><input type="text" name="ship_name" value="" maxlength="40" size="40" /></td>
     </tr>
     <tr>
       <td>Address</td>
       <td><input type="text" name="ship_address" value="" maxlength="40" size="40" /></td>
     </tr>
     <tr>
       <td>City/Suburb</td>
       <td><input type="text" name="ship_city" value="" maxlength="20" size="40" /></td>
     </tr>
     <tr>
       <td>State/Province</td>
       <td><input type="text" name="ship_state" value="" maxlength="20" size="40" /></td>
     </tr>
     <tr>
       <td>Postal Code or Zip Code</td>
       <td><input type="text" name="ship_zip" value="" maxlength="10" size="40" /></td>
     </tr>
     <tr>
       <td>Country</td>
       <td><input type="text" name="ship_country" value="" maxlength="20" size="40" /></td>
     </tr>
     <tr>
       <td colspan="2" align="center"><p><strong>Please press Purchase to confirm
       your purchase,or Continue Shopping to add or remove items.</strong></p>
       <?php display_form_button("purchase", "Purchase These Items"); ?>
       </td>
     </tr>
     </form>
     </table>
     <hr />
     <?php
   }
   
   function display_form_button($image, $alt)
   {
    echo "<div align=\"center\"><input type=\"image\" src=\"images/".$image.".gif\"
          alt=\"".$alt."\" border=\"0\" height=\"50\" width=\"135\" /></div>";
   }
   
   function display_shipping($shipping)
   {
    ?>
    <table border="0" width="100%" cellspacing="0">
    <tr>
      <td align="left">Shipping</td>
      <td align="right"><?php echo number_format($shipping, 2); ?></td>
    </tr>
    <tr>
      <th align="left" bgcolor="#cccccc">TOTAL INCLUDING SHIPPING</th>
      <th align="right" bgcolor="#cccccc">$ <?php echo number_format($shipping+$_SESSION['total_price'], 2); ?></th>
    </tr>
    </table>
    <br />
    <?php
   }
   
  function display_card_form($name)
  {
    ?>
    <table border="0" width="100%" cellspacing="0">
    <form action="process.php" method="post">
    <tr>
      <th align="center" colspan="2" bgcolor="#cccccc">Credit Card Details</th>
    </tr>
    <tr>
      <td>Type</td>
      <td>
        <select name="card_type">
          <option value="VISA">VISA</option>
          <option value="MaterCard">MasterCard</option>
          <option value="American Express">American Express</option>
        </select>
      </td>
    </tr>
    <tr>
      <td>Number</td>
      <td><input type="text" name="card_number" value="" maxlength="16" size="40" /></td>
    </tr>
    <tr>
      <td>AMEX code (if required)</td>
      <td><input type="text" name="amex_code" value="" maxlength="4" size="4" /></td>
    </tr>
    <tr>
      <td>Expiry Date</td>
      <td>
      Month
      <select name="card_month">
        <option value="01">01</option>
        <option value="02">02</option>
        <option value="03">03</option>
        <option value="04">04</option>
        <option value="05">05</option>
        <option value="06">06</option>
        <option value="07">07</option>
        <option value="08">08</option>
        <option value="09">09</option>
        <option value="10">10</option>
        <option value="11">11</option>
        <option value="12">12</option>
      </select>
      Year
      <select name="card_year">
        <?php
        for ($y = date("Y"); $y < date("Y") + 10; $y++)
        {
            echo "<option value=\"".$y."\">".$y."</option>";
        }
        ?>
      </select>
      </td>
    </tr>
    <tr>
      <td>Name on Card</td>
      <td><input type="text" name="card_name" value="<?php echo $name; ?>" maxlength="40" size="40" /></td>
    </tr>
    <tr>
      <td colspan="2" align="center">
        <p><strong>Please press Purchase to confirm your purchase, or Continue Shopping to add or remove items</strong></p>
        <?php display_form_button('purchase', 'Purchase', 'Purchase These Items'); ?>
      </td>
    </tr>
    </form>
    </table>
    <?php
  }

  function display_login_form()
  {
      ?>
    <form method="post" action="admin.php">
        <table bgcolor="#48d1cc">
            <tr>
                <td>Username:</td>
                <td><input type="text" name="username" /></td>
            </tr>
            <tr>
                <td>Password:</td>
                <td><input type="password" name="passwd" /></td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <input type="submit" value="Log in" />
                </td>
            </tr>
        </table>
    </form>
    <?php
  }

  function display_admin_menu(){
      ?>
      <br />
      <a href="index.php">Go to main site</a><br />
      <a href="insert_category_form.php">Add a new category</a><br />
      <a href="insert_book_form.php">Add a new book</a><br />
      <a href="change_password_form.php">Change admin password</a>
    <?php
  }

function display_category_form($category = '') {
// This displays the category form.
// This form can be used for inserting or editing categories.
// To insert, don't pass any parameters.  This will set $edit
// to false, and the form will go to insert_category.php.
// To update, pass an array containing a category.  The
// form will contain the old data and point to update_category.php.
// It will also add a "Delete category" button.

    // if passed an existing category, proceed in "edit mode"
    $edit = is_array($category);

    // most of the form is in plain HTML with some
    // optional PHP bits throughout
    ?>
    <form method="post"
          action="<?php echo $edit ? 'edit_category.php' : 'insert_category.php'; ?>">
        <table border="0">
            <tr>
                <td>Category Name:</td>
                <td><input type="text" name="cat_name" size="40" maxlength="40"
                           value="<?php echo $edit ? $category['cat_name'] : ''; ?>" /></td>
            </tr>
            <tr>
                <td <?php if (!$edit) { echo "colspan=2";} ?> align="center">
                    <?php
                    if ($edit) {
                        echo "<input type=\"hidden\" name=\"cat_id\" value=\"".$category['cat_id']."\" />";
                    }
                    ?>
                    <input type="submit"
                           value="<?php echo $edit ? 'Update' : 'Add'; ?> Category" /></form>
    </td>
    <?php
    if ($edit) {
        //allow deletion of existing categories
        echo "<td>
                <form method=\"post\" action=\"delete_category.php\">
                <input type=\"hidden\" name=\"cat_id\" value=\"".$category['cat_id']."\" />
                <input type=\"submit\" value=\"Delete category\" />
                </form></td>";
    }
    ?>
    </tr>
    </table>
    <?php
}

function display_book_form($book = '') {
// This displays the book form.
// It is very similar to the category form.
// This form can be used for inserting or editing books.
// To insert, don't pass any parameters.  This will set $edit
// to false, and the form will go to insert_book.php.
// To update, pass an array containing a book.  The
// form will be displayed with the old data and point to update_book.php.
// It will also add a "Delete book" button.


    // if passed an existing book, proceed in "edit mode"
    $edit = is_array($book);

    // most of the form is in plain HTML with some
    // optional PHP bits throughout
    ?>
    <form method="post"
          action="<?php echo $edit ? 'edit_book.php' : 'insert_book.php';?>">
        <table border="0">
            <tr>
                <td>ISBN:</td>
                <td><input type="text" name="isbn"
                           value="<?php echo $edit ? $book['isbn'] : ''; ?>" /></td>
            </tr>
            <tr>
                <td>Book Title:</td>
                <td><input type="text" name="title"
                           value="<?php echo $edit ? $book['title'] : ''; ?>" /></td>
            </tr>
            <tr>
                <td>Book Author:</td>
                <td><input type="text" name="author"
                           value="<?php echo $edit ? $book['author'] : ''; ?>" /></td>
            </tr>
            <tr>
                <td>Category:</td>
                <td><select name="cat_id">
                        <?php
                        // list of possible categories comes from database
                        $cat_array=get_categories();
                        foreach ($cat_array as $this_cat) {
                            echo "<option value=\"".$this_cat['cat_id']."\"";
                            // if existing book, put in current catgory
                            if (($edit) && ($this_cat['cat_id'] == $book['cat_id'])) {
                                echo " selected";
                            }
                            echo ">".$this_cat['cat_name']."</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Price:</td>
                <td><input type="text" name="price"
                           value="<?php echo $edit ? $book['price'] : ''; ?>" /></td>
            </tr>
            <tr>
                <td>Description:</td>
                <td><textarea rows="3" cols="50"
                              name="description"><?php echo $edit ? $book['description'] : ''; ?></textarea></td>
            </tr>
            <tr>
                <td <?php if (!$edit) { echo "colspan=2"; }?> align="center">
                    <?php
                    if ($edit)
                        // we need the old isbn to find book in database
                        // if the isbn is being updated
                        echo "<input type=\"hidden\" name=\"oldisbn\"
                    value=\"".$book['isbn']."\" />";
                    ?>
                    <input type="submit"
                           value="<?php echo $edit ? 'Update' : 'Add'; ?> Book" />
    </form></td>
    <?php
    if ($edit) {
        echo "<td>
                   <form method=\"post\" action=\"delete_book.php\">
                   <input type=\"hidden\" name=\"isbn\"
                    value=\"".$book['isbn']."\" />
                   <input type=\"submit\" value=\"Delete book\"/>
                   </form></td>";
    }
    ?>
    </td>
    </tr>
    </table>
    </form>
    <?php
}

  function display_register_form(){
      ?>
      <form method="post" action="register_new.php">
          <table bgcolor="#cccccc">
                  <td>Preferred username <br />(max 16 chars):</td>
                  <td valign="top"><input type="text" name="username"
                                          size="16" maxlength="16"/></td></tr>
              <tr>
                  <td>Password <br />(between 6 and 16 chars):</td>
                  <td valign="top"><input type="password" name="passwd"
                                          size="16" maxlength="16"/></td></tr>
              <tr>
                  <td>Confirm password:</td>
                  <td><input type="password" name="passwd2" size="16" maxlength="16"/></td></tr>
              <tr>
                  <td colspan=2 align="center">
                      <input type="submit" value="Register"></td></tr>
          </table></form>
    <?php
  }

function update_book($oldisbn, $isbn, $title, $author, $cat_id,
                     $price, $description) {
// change details of book stored under $oldisbn in
// the database to new details in arguments

    $conn = db_connect();

    $query = "update books
             set isbn= '".$isbn."',
             title = '".$title."',
             author = '".$author."',
             catid = '".$cat_id."',
             price = '".$price."',
             description = '".$description."'
             where isbn = '".$oldisbn."'";

    $result = @$conn->query($query);
    if (!$result) {
        return false;
    } else {
        return true;
    }
}

function display_password_form() {
// displays html change password form
    ?>
    <br />
    <form action="change_password.php" method="post">
        <table width="250" cellpadding="2" cellspacing="0" bgcolor="#cccccc">
            <tr><td>Old password:</td>
                <td><input type="password" name="old_passwd" size="16" maxlength="16" /></td>
            </tr>
            <tr><td>New password:</td>
                <td><input type="password" name="new_passwd" size="16" maxlength="16" /></td>
            </tr>
            <tr><td>Repeat new password:</td>
                <td><input type="password" name="new_passwd2" size="16" maxlength="16" /></td>
            </tr>
            <tr><td colspan=2 align="center"><input type="submit" value="Change password">
                </td></tr>
        </table>
        <br />
    <?php
}
    ?>