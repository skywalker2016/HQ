<?php
/**
 * Created by PhpStorm.
 * User: hongqiang
 * Date: 2016/11/3
 * Time: 12:40
 */

function display_book_form1($book = ''){
    // if passed an existing book, proceed in "edit mode"
    $edit = is_array($book);
?>
    <form method="post"
          action="<?php echo $edit ? 'edit_book.php' : 'insert_book.php'; ?>">
    <table border="0">
        <tr>
            <td><strong>ISBN:</strong></td>
            <td><input type="text" name="isbn"
                 value="<?php echo $edit ? $book['isbn'] : ''; ?>" /></td>
        </tr>
        <tr>
            <td><strong>Book Title:</strong></td>
            <td><input type="text" name="title"
                 value="<?php echo $edit ? $book['title'] : ''; ?>" /></td>
        </tr>
        <tr>
            <td><strong>Book Author:</strong></td>
            <td><input type="text" name="author"
                 value="<?php echo $edit ? $book['author'] : ''; ?>"></td>
        </tr>
        <tr>
            <td><strong>Category:</strong></td>
            <td><select name="cat_id"
                <?php
                $cat_array = get_categories();
                foreach ($cat_array as $thiscat){
                    echo "<option value=\"".$thiscat['cat_id']."\"";
                    // if existing book, put in current category
                    if (($edit) && ($thiscat['cat_id'] == $book['cat_id'])){
                        echo " selected";
                    }
                    echo ">".$thiscat['cat_name']."</option>";
                }
                ?>
                </select>
            </td>
        </tr>
        <tr>
            <td><strong>Price:</strong></td>
            <td><input type="text" name="price"
                 value="<?php echo $edit ? $book['price'] : ''; ?>" /></td>
        </tr>
        <tr>
            <td><strong>Description:</strong></td>
            <td><textarea rows="3" cols="50"
                 name="description"><?php echo $edit ? $book['description'] : ''; ?>
                </textarea> </td>
        </tr>
        <tr>
            <td <?php if (!$edit){ echo "colspan=2"; }?> align="center">
                <?php
                if ($edit)
                    echo "<input type=\"hidden\" name=\"oldisbn\"
                          value=\"".$book['isbn']."\" />";
                ?>
                <input type="submit"
                       value="<?php echo $edit ? 'Update' : 'Add'; ?> Book" />
            </form></td>
    <?php
       if ($edit){
           echo "<td>
                 <form method=\"post\" action=\"delete_book.php\">
                 <input type=\"hidden\" name=\"isbn\"
                  value=\"".$book['isbn']."\" />
                 <input type=\"submit\" value=\"Delete book\" />
                 </form></td>";
       }
    ?>
      </td>
        </tr>
    </table>
    </form>
<?php
}