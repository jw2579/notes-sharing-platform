<?php
    setCookie("PHPSESSID","",time()-1,"/");
    $_SESSION=array();
    session_destroy();

    Header("Location:login.php");