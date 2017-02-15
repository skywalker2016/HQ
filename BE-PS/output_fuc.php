<?php
/**
 * Created by PhpStorm.
 * User: hongqiang
 * Date: 2016/12/15
 * Time: 16:15
 */
require_once ("connect_db.php");

/*function display_register_form(){
    ?>
    <font id="font3">
        <form action="register_new.php" style="display: inline">
            <table border="0" width="35%" cellpadding="0" cellspacing="2px">
                <tr>
                    <td width="40%" align="center"> 用户名 &nbsp;</td>
                    <td width="60%" align="left"><input type='text' name='username' size='35' id="form1"/></td>
                </tr>
                <tr>
                    <td width="40%" align="center"> 密&nbsp;&nbsp;&nbsp;码 &nbsp;</td>
                    <td width="60%" align="left"><input type='password' name='password' size='35' id="form1"/></td>
                </tr>
                <tr>
                    <td width="40%" align="center"> 确认密码 &nbsp;</td>
                    <td width="60%" align="left"><input type='password' name='password1' size='35' id="form1"/></td>
                </tr>
                <tr>
                    <td width="40%" align="center"> 邮&nbsp;&nbsp;&nbsp;箱 </td>
                    <td width="60%" align="left"><input type="text" name="email" size="35" id="form1" /></td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><input type="submit" value="注&nbsp;&nbsp;册"></td>
                </tr>
            </table>
        </form>
    </font>
<?php
}*/

function register($username, $password) {
// register new person with db
// return true or error message

    // connect to db
    $conn = db_connect();

    // check if username is unique
    $result = $conn->query("select * from user where username='".$username."'");
    if (!$result) {
        throw new Exception('Could not execute query');
    }

    if ($result->num_rows>0) {
        throw new Exception('That username is taken - go back and choose another one.');
    }

    // if ok, put in db
    $result = $conn->query("insert into user values
                         ('".$username."', '".$password."', '1')");
    if (!$result) {
        throw new Exception('Could not register you in database - please try again later.');
    }

    return true;
}
?>