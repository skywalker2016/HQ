<?php
/**
 * Created by PhpStorm.
 * User: hongqiang
 * Date: 2016/12/9
 * Time: 14:30
 */



function db_connect()
{

    $result = new mysqli('localhost', 'root', '322816', 'be_ps');
    if (!$result)
    {
        return false;
    }
    return $result;
}

?>

