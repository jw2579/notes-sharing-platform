<?php
if (isset($_POST['jsonResFile']) && isset($_POST['jsonResUser']) ) {
    include_once('../db.php');
    $data=$_POST['jsonResFile'];
    $name_file = (json_decode($data));   
    $conn->query("UPDATE document SET weight = weight+1 WHERE document.name = '$name_file'");
    $data=$_POST['jsonResUser'];
    $name_user = (json_decode($data));   
    $conn->query("INSERT INTO `updown` (`uname`, `dname`) VALUES ('$name_user', '$name_file')");
}else if (isset($_POST['jsonResFileCan']) && isset($_POST['jsonResUserCan']) ) {
    include_once('../db.php');
    $data=$_POST['jsonResFileCan'];
    $name_file = (json_decode($data));   
    $conn->query("UPDATE document SET weight = weight-1 WHERE document.name = '$name_file'");
    $data=$_POST['jsonResUserCan'];
    $name_user = (json_decode($data));   
    $conn->query("DELETE FROM `updown` WHERE `updown`.`uname` = '$name_user' AND `updown`.`dname` = '$name_file'");
}

?>