<?php
    session_start();
    if (!isset($_SESSION['name'])) {
        $_SESSION['name']="Please login first";
    }
    $user_name =  $_SESSION['name'];
    include_once("./db.php");
    $re_message = $conn->query("SELECT message FROM user WHERE `name` = '$user_name' ");
    $user_message = mysqli_fetch_assoc($re_message)["message"];
    $re_alert = $conn->query("SELECT alert FROM user WHERE `name` = '$user_name' ");
    $user_alert = mysqli_fetch_assoc($re_alert)["alert"];
    
    $numOfFiles = $conn->query("SELECT COUNT(id) FROM document");      
    $numOfnum = mysqli_fetch_assoc($numOfFiles)["COUNT(id)"];
    $numOfRatings = $conn->query("SELECT SUM(weight) FROM document");      
    $numOfnumR = mysqli_fetch_assoc($numOfRatings)["SUM(weight)"];
    $timeOfLastA = $conn->query("SELECT MAX(time) FROM document");      
    $timeOftimeL = mysqli_fetch_assoc($timeOfLastA)["MAX(time)"];
    if ($_SESSION['admin']==2) {
        header("location: ./userPanel.php");
    }
    $user_name = json_encode($user_name);
    
    if (@$_GET['center']=='manual.pdf') {
        ob_clean(); // readable
        $file1 = './manual.pdf';
        header('Pragma: public');   // required
        header('Expires: 0');       // no cache
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Cache-Control: private',false);
        header('Content-Type:application/force-download');
        header('Content-Disposition: attachment; filename="'.basename($file1).'"');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: '.filesize($file1));    // provide file size
        header('Connection: close');
        readfile($file1); 
        exit();
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

    <title>Project Profile</title>
    <link rel="shortcut  icon" href="./img/logo.ico" type="image/x-icon" />

    <!-- Custom fonts for this template-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.staticfile.org/font-awesome/4.7.0/css/font-awesome.css">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">
<?php if(isset($_SESSION['admin'])) :?>
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
            <li class="nav-item active">
                <a class="nav-link" href="background.php">
                    <i class="	fa fa-chain"></i>
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
                        <a class="collapse-item" href="../search/comp207.php">Database</a>
                        <a class="collapse-item" href="../search/comp219.php">Machine Learning</a>
                        <a class="collapse-item" href="../search/comp222.php">Game Theory</a>
                        <a class="collapse-item" href="../search/comp202.php">Algorithms</a>
                        <a class="collapse-item" href="../search/comp284.php">Networks</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="./upload/summarize.php">
                    <i class="fa fa-file-word-o"></i>
                    <span>Summarize</span></a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link" href="./upload/upload.php">
                    <i class="bi bi-upload"></i>
                    <span>Upload</span></a>
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
                                aria-label="Search" aria-describedby="basic-addon2" id = search_for>
                      <div class="input-group-append">
                          <button class="btn btn-primary" type="button" onclick="searchFor()">
                              <i class="fas fa-search fa-sm"></i>
                          </button>
                      </div>
                  </div>

                  <script>
                    function searchFor(){
                      var sf = document.getElementById("search_for");
                      switch(sf.value){
                        case "Machine Learning":
                          window.location.href="./search/comp219.php";
                          break;
                        case "Database":
                          window.location.href="./search/comp207.php";
                          break;
                        case "Game Theory":
                          window.location.href="./search/comp222.php";
                          break;
                        case "Algorithms":
                          window.location.href="./search/comp202.php";
                          break;
                        case "Networks":
                          window.location.href="./search/comp284.php";
                          break;
                      }
                    }
                  </script>
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
                                            aria-describedby="basic-addon2" id = search_for_xs>
                                  <div class="input-group-append">
                                      <button class="btn btn-primary" type="button" onclick = "searchFor_xs()">
                                          <i class="fas fa-search fa-sm"></i>
                                      </button>
                                  </div>
                              </div>
                              <script>
                                function searchFor_xs(){
                                  var sf = document.getElementById("search_for_xs");
                                  switch(sf.value){
                                    case "Machine Learning":
                                      window.location.href="./search/comp219.php";
                                      break;
                                    case "Database":
                                      window.location.href="./search/comp207.php";
                                      break;
                                    case "Game Theory":
                                      window.location.href="./search/comp222.php";
                                      break;
                                    case "Algorithms":
                                      window.location.href="./search/comp202.php";
                                      break;
                                    case "Networks":
                                      window.location.href="./search/comp284.php";
                                      break;
                                  }
                                }
                              </script>                              
                          </form>
                      </div>
                  </li>

                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- Counter - Alerts -->
                                <span class="badge badge-danger badge-counter" id = "newAlerts"><?php echo $user_alert?></span>
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                            aria-labelledby="alertsDropdown" id = "dropDownAlerts">
                                <h6 class="dropdown-header">
                                    Alerts Center
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="./search/uncheckedAlert.php">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-primary">
                                            <i class="fas fa-file-alt text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">Click Here</div>
                                        <span class="font-weight-bold">Check your new like!</span>
                                    </div>
                                </a>
                            </div>

                            <script>
                                if(<?php echo $user_alert?> == 0){
                                    document.getElementById("newAlerts").style.display = "none"; 
                                }
                            </script>                            
                        </li>

                        <!-- Nav Item - Messages -->
                        <!-- Nav Item - Messages -->
                      <li class="nav-item dropdown no-arrow mx-1">
                          <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                              data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onclick = "toNone()">
                              <i class="fas fa-envelope fa-fw"></i>
                              <!-- Counter - Messages -->
                              <span class="badge badge-danger badge-counter" id = "newMessages"><?php echo $user_message?></span>
                          </a>
                          <!-- Dropdown - Messages -->
                          <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                    aria-labelledby="messagesDropdown">
                                    <h6 class="dropdown-header">
                                        Message Center
                                    </h6>
                                    <a class="dropdown-item d-flex align-items-center" href="./background.php?center=manual.pdf">
                                        <div class="dropdown-list-image mr-3">
                                            <img class="rounded-circle" src="img/undraw_profile_1.svg"
                                                alt="">
                                            <div class="status-indicator bg-success"></div>
                                        </div>
                                        <div class="font-weight-bold">
                                            <div class="text-truncate">User Manual</div>
                                            <div class="small text-gray-500">Click here to download </div>
                                        </div>

                                    </a>
                                    <a class="dropdown-item d-flex align-items-center" href="../background.php">
                                        <div class="dropdown-list-image mr-3">
                                            <img class="rounded-circle" src="img/undraw_profile_2.svg"
                                                alt="">
                                            <div class="status-indicator"></div>
                                        </div>
                                        <div>
                                            <div class="text-truncate">See what we have done</div>
                                            <div class="small text-gray-500">Click here to check</div>
                                        </div>
                                    </a>
                              </div>
                            <script>
                                if(<?php echo $user_message?> == 0){
                                    document.getElementById("newMessages").style.display = "none"; 
                                }
                                function toNone(){
                                    var user_name = <?php echo $user_name; ?>;
                                    var jsonUsername = JSON.stringify(user_name);
                                    $.ajax({
                                    type:"POST",
                                    url:"./search/mesAle.php",
                                    dataType:"json",
                                    async:false,
                                    data:{'jsonResMes': jsonUsername},
                                    success:function(json){}
                                    });
                                    document.getElementById("newMessages").style.display = "none"; 
                                }
                            </script>                              
                           
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
                                    <a class="dropdown-item" href="profile.php">
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

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Project Profile</h1>
                    </div>

                    <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Overall Articles</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $numOfnum; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa fa-bar-chart fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Annual) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Overall Likes</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $numOfnumR; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa fa-thumbs-up fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tasks Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Like Rate
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo round($numOfnum/$numOfnumR*100, 2); ?>%</div>
                                                </div>
                                                <div class="col">
                                                    <div class="progress progress-sm mr-2">
                                                        <div class="progress-bar bg-info" role="progressbar"
                                                            style="width: <?php echo round($numOfnum/$numOfnumR*100, 2); ?>%" aria-valuenow="50" aria-valuemin="0"
                                                            aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa fa-heart fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pending Requests Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Last active time</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $timeOftimeL; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa fa-sign-language fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">

                            <!-- Basic Card Example -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Features</h6>
                                </div>
                                <div class="card-body">
                                    Xuni aims to provide users with reliable knowledge management services:
                                    <br />
                                    <br />
                                    Users can get a summary of a document in the summary area, and through the upload function, it will save your document
                                    to the cloud. You can also read or save documents shared by others in the browse area. Similarly, with your permissio
                                    , you can also share your documents with others.
                                    <br />
                                    <br />
                                    Let us build a bridge of knowledge.
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-6">

                            <!-- Basic Card Example -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Philosophy</h6>
                                </div>
                                <div class="card-body">
                                    In the Internet world, people need a quiet, efficient, and sincere communication platform, and this is exactly the
                                    philosophy of Xuni: to provide users with pure knowledge.
                                    <br />
                                    <br />
                                    In Xuni, users do not need to worry about their social image, so they can devote their energy to reading and sharing.
                                    Through Xuni's technical support, users can concentrate on learning knowledge.
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-6">

                            <!-- Default Card Example -->
                            <!--<div class="card mb-4">-->
                            <!--    <div class="card-header">-->
                            <!--        The origin of Xuni-->
                            <!--    </div>-->
                            <!--    <div class="card-body">-->
                            <!--        In 2021, when online office and online learning are becoming more and more important, six students from the University-->
                            <!--        of Liverpool decided to design a platform that can provide quick sharing and access to knowledge.-->
                            <!--        Thus, Xuni was born.-->
                            <!--    </div>-->
                            <!--</div>-->

                            <!-- Basic Card Example -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">The Origin of Xuni</h6>
                                </div>
                                <div class="card-body">
                                    In 2021, when online office and online learning are becoming more and more important, six students from the University
                                    of Liverpool decided to design a platform that can provide quick sharing and access to knowledge.
                                    Thus, Xuni was born.
                                </div>
                            </div>

                        </div>
                        

                        <div class="col-lg-6">

                            <!-- Basic Card Example -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Xuni Team</h6>
                                </div>
                                <div class="card-body">
                                    The development and design team of this platform comes from the University of Liverpool. All members are students, a
                                    group of young people who are looking forward to learning more knowledge and skills. Maintaining and
                                    promoting this platform is now the focus of the team's work.
                                </div>
                            </div>

                        </div>

                        <!--<div class="col-lg-6">-->

                            <!-- Dropdown Card Example -->
                        <!--    <div class="card shadow mb-4">-->
                                <!-- Card Header - Dropdown -->
                        <!--        <div-->
                        <!--            class="card-header py-3 d-flex flex-row align-items-center justify-content-between">-->
                        <!--            <h6 class="m-0 font-weight-bold text-primary">Dropdown Card Example</h6>-->
                        <!--            <div class="dropdown no-arrow">-->
                        <!--                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"-->
                        <!--                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
                        <!--                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>-->
                        <!--                </a>-->
                        <!--                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"-->
                        <!--                    aria-labelledby="dropdownMenuLink">-->
                        <!--                    <div class="dropdown-header">Dropdown Header:</div>-->
                        <!--                    <a class="dropdown-item" href="#">Action</a>-->
                        <!--                    <a class="dropdown-item" href="#">Another action</a>-->
                        <!--                    <div class="dropdown-divider"></div>-->
                        <!--                    <a class="dropdown-item" href="#">Something else here</a>-->
                        <!--                </div>-->
                        <!--            </div>-->
                        <!--        </div>-->
                                <!-- Card Body -->
                        <!--        <div class="card-body">-->
                        <!--            Dropdown menus can be placed in the card header in order to extend the functionality-->
                        <!--            of a basic card. In this dropdown card example, the Font Awesome vertical ellipsis-->
                        <!--            icon in the card header can be clicked on in order to toggle a dropdown menu.-->
                        <!--        </div>-->
                        <!--    </div>-->

                            <!-- Collapsable Card Example -->
                        <!--    <div class="card shadow mb-4">-->
                                <!-- Card Header - Accordion -->
                        <!--        <a href="#collapseCardExample" class="d-block card-header py-3" data-toggle="collapse"-->
                        <!--            role="button" aria-expanded="true" aria-controls="collapseCardExample">-->
                        <!--            <h6 class="m-0 font-weight-bold text-primary">Collapsable Card Example</h6>-->
                        <!--        </a>-->
                                <!-- Card Content - Collapse -->
                        <!--        <div class="collapse show" id="collapseCardExample">-->
                        <!--            <div class="card-body">-->
                        <!--                This is a collapsable card example using Bootstrap's built in collapse-->
                        <!--                functionality. <strong>Click on the card header</strong> to see the card body-->
                        <!--                collapse and expand!-->
                        <!--            </div>-->
                        <!--        </div>-->
                        <!--    </div>-->

                        <!--</div>-->

                    </div>

                </div>
                <!-- /.container-fluid -->

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
<?php else :?>
      <?php header('location: login.php'); ?>
<?php endif;?>
</body>

</html>