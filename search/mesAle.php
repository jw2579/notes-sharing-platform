<?php
if (isset($_POST['jsonResUp']) ) {
    include_once('../db.php');
    $data=$_POST['jsonResUp'];
    $name_uploader = (json_decode($data)); 
    $conn->query("UPDATE user SET alert = alert + 1 WHERE user.name = '$name_uploader'");
}else if(isset($_POST['jsonResDown'])){
    include_once('../db.php');
    $data=$_POST['jsonResDown'];
    $name_uploader = (json_decode($data)); 
    $alert = $conn->query("SELECT alert from user WHERE user.name = '$name_uploader'");
    $num = mysqli_fetch_assoc($alert);
    $numOfUnclickedLike = $num["alert"];
    if($numOfUnclickedLike != 0){
        $conn->query("UPDATE user SET alert = alert - 1 WHERE user.name = '$name_uploader'");    
    }
    
}else if(isset($_POST['jsonResMes'])){
    include_once('../db.php');
    $data=$_POST['jsonResMes'];
    $name_user = (json_decode($data)); 
    $conn->query("UPDATE user SET message = 0 WHERE user.name = '$name_user'");    
}

?>