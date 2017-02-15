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
      <td><input type="text" name="card_name" value="hongqiang" maxlength="40" size="40" /></td>
    </tr>
    <br />
    <br />
    <tr>
      <td colspan="2" align="center">
        <p><strong>Please press Purchase to confirm your purchase, or Continue Shopping to add or remove items</strong></p>
       </td>
    </tr>
    </form>
    </table>
    <hr bgcolor="#cccccc" />