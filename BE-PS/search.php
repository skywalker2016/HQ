<?php
/**
 * Created by PhpStorm.
 * User: hongqiang
 * Date: 2017/1/14
 * Time: 18:19
 */
header("content-type:text/html; charset=utf-8");

session_start();
include ("connect_db.php");
include ("page.class.php");

if ($_SESSION['permission'] == null){
    header("Location::error.html");
    exit;
}

$name1 = $_POST['name1'];
$name2 = $_POST['name2'];
//$result = null;

$conn = db_connect();

//if ($name2 == 'author'){
    $sql = 'select count(*) as total from upfiles WHERE file_owner="'.$name1.'"';
    $result = $conn -> query($sql);
    $data = mysqli_fetch_array($result);

    //创建分页对象
    $page = new Page($data['total'], 10);
    $start = $page->start()-1;

    $sql = 'select file_id, file_name, file_path, file_owner, file_time, file_classification, file_discription, file_size from upfiles
            WHERE file_owner="'.$name1.'"
            order by file_id
            limit "'.$start.'",10';
    $result = $conn -> query($sql);
/*}elseif($name2 == 'file_name'){
    $sql = "select count(*) as total from upfiles WHERE file_name={$name1}";
    $result = $conn->query($sql);
    $data = mysqli_fetch_array($result);

    //创建分页对象
    $page = new Page($data['total'], 10);
    $start = $page->start()-1;

    $sql = "select * from upfiles WHERE file_name={$name1} ORDER BY file_id limit {$start},10";
    $result = $conn->query($sql);
}*/


?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="style.css" />
    <title></title>
</head>
<body>
<div align="center">
    <br />
    <div>
        <br />
        <font face="Georgia, Times New Roman, Times, serif" size="4" color="#A4B8F2"> You are here: Fetal ECG Data </font>
    </div>
    <br />
    <hr width="50%" id="hr_home"/>
    <br /><br />
    <table border="2" width="80%" align="center" cellspacing="2px" cellpadding="2px">

        <tr>
            <th id="form1_D">ID</th>
            <th id="form1_D">NAME</th>
            <th id="form1_D">PATH</th>
            <th id="form1_D">OWNER</th>
            <th id="form1_D">TIME</th>
            <th id="form1_D">CATEGORY</th>
            <th id="form1_D">DISCRIPTION</th>
            <th id="form1_D">SIZE</th>
        </tr>
        <?php
        while($row = mysqli_fetch_array($result)){
            ?>
            <tr>
                <td id="form2_1"><?php echo $row['file_id']; ?></td>
                <td id="form2_1"><a href='detail.php'><?php echo $row['file_name']; ?></a></td>
                <td id="form2_1"><?php echo $row['file_path']; ?></td>
                <td id="form2_1"><?php echo $row['file_owner']; ?></td>
                <td id="form2_1"><?php echo $row['file_time']; ?></td>
                <td id="form2_1"><?php echo $row['file_classification']; ?></td>
                <td id="form2_1"><?php echo $row['file_discription']; ?></td>
                <td id="form2_1"><?php echo $row['file_size']; ?></td>
            </tr>
            <?php
        }
        ?>

        <tr><td colspan="8" align="right" id="form2_1"><?php echo $page->fpage(); ?></td></tr>
    </table>
</div>
</body>
</html>
