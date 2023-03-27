<?php
session_start();
if (!isset($_SESSION['name'])) {
    $_SESSION['name']="Please login first";
}
            // $user_name =  $_SESSION['name'];
            // include_once("../db.php");
            // $re_message = $conn->query("SELECT message FROM user WHERE `name` = '$user_name' ");
            // $user_message = mysqli_fetch_assoc($re_message)["message"];
            // $re_alert = $conn->query("SELECT alert FROM user WHERE `name` = '$user_name' ");
            // $user_alert = mysqli_fetch_assoc($re_alert)["alert"];
            
            // $re_unclick_alert = $conn->query("SELECT alert from user where name = '$user_name'");
            // $num = mysqli_fetch_assoc($re_unclick_alert);
            // $numOfUnclickedLike = $num["alert"];
            // $re_Alerts = $conn->query("SELECT ID, uname, dname from (select * from updown )ud left JOIN (select name, upload_user from document)d on ud.dname = d.name where upload_user = '$user_name' ORDER BY ID DESC LIMIT $numOfUnclickedLike");   


// 允许上传的文件后缀
if (isset($_FILES["file"]["name"])){
    $allowedExts = array("txt", "docx", "pdf");
    $temp = explode(".", $_FILES["file"]["name"]);
    $extension = end($temp);     // 获取文件后缀
    $trueName = $_FILES["file"]["name"];
    if (($_FILES["file"]["size"] < 20480000)   // 小于 200 mb
    && in_array($extension, $allowedExts))
    {
        if ($_FILES["file"]["error"] > 0)
        {
            // echo "error：: " . $_FILES["file"]["error"] . "<br>";
        }
        else
        {
            // echo "name: " . $_FILES["file"]["name"] . "<br>";
            // echo "type: " . $_FILES["file"]["type"] . "<br>";
            // echo "size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
            // echo "location: " . $_FILES["file"]["tmp_name"] . "<br>";
            
            // 判断当前目录下的 upload 目录是否存在该文件
            // 如果没有 upload 目录，你需要创建它，并且修改权限为所有人可以读和写
            if (file_exists("../cloud/" . $_FILES["file"]["name"]))
            {
                echo $_FILES["file"]["name"] . " already exists ";
            }
            else
            {
                // 如果 upload 目录不存在该文件则将文件上传到 upload 目录下
                // move_uploaded_file($_FILES["file"]["tmp_name"], "../cloud/" . $_FILES["file"]["name"]);
                
                $reN = 'readyForSum';
                move_uploaded_file($_FILES["file"]["tmp_name"], "" . $reN . '.' . $extension);
                copy($reN . '.' . $extension, "../cloud/" . $_FILES["file"]["name"]);
                include_once('../db.php');
                
                $sql = "INSERT INTO `document` (`id`, `name`, `abstract`, `type`, `time`) VALUES (NULL, '$trueName', '', '', CURRENT_TIMESTAMP)";
                //$result = mysql_query($sql,$conn);
                $result = $conn -> query($sql);
                // chmod("./readyForSum.{$extension}", 777)
                // 2>&1
            }
        }
    }
    else
    {
        // echo "Please in specified format";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Summarize</title>

    <!-- Custom fonts for this template-->
    <link rel="stylesheet" href="https://cdn.staticfile.org/font-awesome/4.7.0/css/font-awesome.css">
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">
    <script type="text/javascript">
        window.onload = function(){
            var k=document.getElementById('kk');
            var f=document.getElementById('ff');
            k.onclick=function() {
                f.submit();
            }
        }
    </script>

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="../main.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fa fa-file-text"></i>
                </div>
                <div class="sidebar-brand-text mx-3">X-uni <sup>v3</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="../background.php">
                    <i class="fa fa-chain"></i>
                    <span>Background</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Start
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true"
                    aria-controls="collapseTwo">
                    <i class="fa fa-globe"></i>
                    <span>Search</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Select field</h6>
                        <a class="collapse-item" href="../search/comp207.php">COMP 207</a>
                        <a class="collapse-item" href="../search/comp219.php">COMP 219</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Tables -->
            <li class="nav-item active">
                <a class="nav-link" href="summarize.php">
                    <i class="fa fa-file-word-o"></i>
                    <span>Summarize</span></a>
            </li>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- Counter - Alerts -->
                                <span class="badge badge-danger badge-counter" id = "newAlerts">3+</span>
                            </a>
                            <!-- Dropdown - Alerts -->
                            <!--<div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"-->
                            <!--aria-labelledby="alertsDropdown" id = "dropDownAlerts">-->
                            <!--    <h6 class="dropdown-header">-->
                            <!--        Alerts Center-->
                            <!--    </h6>-->
                            <!--    <a class="dropdown-item d-flex align-items-center" href="uncheckedAlert.php">-->
                            <!--        <div class="mr-3">-->
                            <!--            <div class="icon-circle bg-primary">-->
                            <!--                <i class="fas fa-file-alt text-white"></i>-->
                            <!--            </div>-->
                            <!--        </div>-->
                            <!--        <div>-->
                            <!--            <div class="small text-gray-500">Click to check</div>-->
                            <!--            <span class="font-weight-bold">You got new like!</span>-->
                            <!--        </div>-->
                            <!--    </a>-->
                            <!--</div>-->

                            <!--<script>-->
                            <!--    if(== 0){-->
                            <!--        document.getElementById("newAlerts").style.display = "none"; -->
                            <!--        document.getElementById("dropDownAlerts").style.display = "none"; -->
                            <!--    }-->
                            <!--</script>                            -->
                        </li>

                        <!-- Nav Item - Messages -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-envelope fa-fw"></i>
                                <!-- Counter - Messages -->
                                <span class="badge badge-danger badge-counter">4</span>
                            </a>
                            <!-- Dropdown - Messages -->
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $_SESSION['name'];?></span>
                                <img class="img-profile rounded-circle"
                                    src="img/undraw_profile.svg">
                            </a>
                            <?php if(isset($_SESSION['admin'])) :?>
                                <!-- Dropdown - User Information -->
                                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                    aria-labelledby="userDropdown">
                                    <a class="dropdown-item" href="../profile.php">
                                        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Profile
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Logout
                                    </a>
                                </div>
                            <?php endif;?>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Please upload your file here</h1>
                    </div>
                    <p class="mb-4">Bootstrap's default utility classes can be found on the official</p>
                    <form class="col-6 mb-4" method="post" enctype="multipart/form-data" id="ff">
                        <div class="input-group">
                            <!-- 上传文件 -->
                            <input class="form-control mb-2" placeholder="Format：.docx or .txt"
                                aria-label="Search" aria-describedby="basic-addon2" id='location' onclick="$('#i-file').click();">
                            <div class="input-group-append">
                                <!-- 按钮上传 -->
                                <button class="btn btn-primary mb-2 rounded-right" type="button" onclick="$('#i-file').click();" id="ll">
                                    <i class="fas fa-upload fa-sm"></i>
                                </button>
                            </div>
                            <input type="file" name="file" id='i-file'  accept=".txt, .docx, .pdf" onchange="$('#location').val($('#i-file').val());" style="display: none">
                        </div>
                        <!-- checkbox复选框 -->
                        <div class="form-group">
                            <div class="custom-control custom-checkbox small">
                                <div></div>
                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                <label class="custom-control-label" >Agree to share</label>
                            </div>
                        </div>
                        <!-- 上传 -->
                        <a href="#" class="btn btn-primary btn-icon-split" id="kk">
                            <span class="icon text-white-50">
                                <i class="fas fa-flag"></i>
                            </span>
                            <span class="text">Upload</span>
                        </a>
                    </form>
                    
                    <!-- 摘要结果textarea -->
                    <div class="col-xl-9 col-md-9 mb-4">
                        <?php if(isset($_FILES["file"]["name"])) :?>
                            <textarea class="form-control" id="deblock_udid" name="deblock_udid" rows="16" style="min-width: 90%"><?php system("/home/stustudy/anaconda3/bin/python capturenew.py"); ?></textarea>
                        <?php else :?>
                            <textarea class="form-control" id="deblock_udid" name="deblock_udid" rows="16" style="min-width: 90%"></textarea>
                        <?php endif;?>
                    </div>
                </div>

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Xuni 2021</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="../out.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>
</body>

</html>