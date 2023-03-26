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


    if ($_SESSION['admin']==2) {
        header("location: ./userPanel.php");
    }
    
    if (@$_GET['filename']=='manual.pdf') {
        ob_clean(); // readable
        $file1 = 'manual.pdf';
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
    $user_name = json_encode($user_name);
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Start Xuni-Share</title>

  <link rel="shortcut  icon" href="./img/logo.ico" type="image/x-icon" />
  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom fonts for this template -->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

  <!-- Custom styles for this template -->
  <link href="css/landing-page.min.css" rel="stylesheet">

  <link rel="stylesheet" href="https://cdn.staticfile.org/font-awesome/4.7.0/css/font-awesome.css">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    
    <!-- Bootstrap icon template -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">

</head>

<body>
<?php if(isset($_SESSION['admin'])) :?>
<script type="text/javascript">
    window.onload = function() {
        var dd = document.getElementById('dd');
        dd.onclick = function(){
            window.location = "./main.php?filename=manual.pdf";
        }
    }
</script>
  <div id="wrapper">
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">

        <!-- Topbar -->
          <nav class="navbar navbar-expand navbar-light bg-white topbar" >

              <div class="col-3">
                <!-- !!!!!!!!!!!!!!! -->
                <h5 class="m-0 font-weight-bold text-primary">Note-sharing Platform</h5>
              </div>
              <!-- Topbar Search -->
              <!--<div class="col-1">-->
              <!--</div>-->
              <form
                  class="d-none d-sm-inline-block form-inline col-6 mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
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
                          aria-labelledby="searchDropdown" style='position:fixed; z-index:999; top:0;'>
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

                  <!-- 提醒 -->
                  <li class="nav-item dropdown no-arrow mx-1">
                      <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                          data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="fas fa-bell fa-fw"></i>
                          <!-- Counter - Alerts -->
                          <span class="badge badge-danger badge-counter" id = "newAlerts"><?php echo $user_alert?></span>
                        </a>
                        <!-- Dropdown - Alerts -->
                        <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                        aria-labelledby="alertsDropdown" id = "dropDownAlerts" style='position:fixed; z-index:999; top:0;'>
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

                  <!-- 邮件 -->
                  <li class="nav-item dropdown no-arrow mx-1">
                      <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                          data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onclick = "toNone()">
                          <i class="fas fa-envelope fa-fw"></i>
                          <!-- Counter - Messages -->
                          <span class="badge badge-danger badge-counter" id = "newMessages"><?php echo $user_message?></span>
                      </a>
                      <!-- Dropdown - Messages -->
                      <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="messagesDropdown" style='position:fixed; z-index:999; top:0;'>
                                <h6 class="dropdown-header">
                                    Message Center
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#" id="dd">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="img/undraw_profile_1.svg"
                                            alt="">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div class="font-weight-bold">
                                        <div class="text-truncate">User Manual</div>
                                        <div class="small text-gray-500">Click here to download </div>
                                    </div>
                                    <!-- add download method by jiaxuan -->
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="background.php">
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

                  <!-- 用户信息 -->
                  <li class="nav-item dropdown no-arrow">
                      <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                          data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $_SESSION['name'];?></span>
                          <img class="img-profile rounded-circle"
                              src="img/undraw_profile.svg">
                      </a>
                      <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                          aria-labelledby="userDropdown" style='position:fixed; z-index:999; top:0;'>
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
                  </li>
              </ul>
          </nav>
        <!-- End of Topbar -->
      </div>
    </div>
  </div>

  <!-- Masthead -->
  

  <!-- Icons Grid -->
  <section class="features-icons bg-light text-center">
    <div class="container" style="opacity:0.8" >
        <h1>A Note-sharing platform</h1>
    </div>
    <div style="opacity:0.5">
        <h4>Embedded with NLP text summarization engine</h3>
    </div>
    <br><br><br>
    <div class="container">
      <div class="row">
        <div class="col-lg-4">
          <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3">
            <a href="./search/comp207.php">
            <div class="features-icons-icon d-flex">
              <i class="icon-screen-desktop m-auto text-primary" id="hhh"></i>
            </div>
            </a>
            
            
            <h3>Browse Articles</h3>
            <p class="lead mb-0">Use tags to get learning materials for computer science</p>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3">
            <a href = "./upload/summarize.php">
              <div class="features-icons-icon d-flex">
                <i class="icon-layers m-auto text-primary"></i>
              </div>
            </a>
            <h3>Summarize</h3>
            <p class="lead mb-0">Generate your text summarization from your file</p>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="features-icons-item mx-auto mb-0 mb-lg-3">
		        <a href = "./upload/upload.php">
              <div class="features-icons-icon d-flex">
                <i class="bi bi-upload m-auto text-primary"></i>
              </div>
			      </a>
            <h3>Upload</h3>
            <p class="lead mb-0">Ready to use with your own content, or customize the source files!</p>
          </div>
        </div>
      </div>
    </div>
  </section>


  
  <!-- Testimonials -->
  <section class="testimonials text-center bg-light">
    <div class="container">
      <h2 class="mb-5">What developers are saying...</h2><br>
      <div class="row">
        <div class="col-lg-4">
          <div class="testimonial-item mx-auto mb-5 mb-lg-0">
            <img class="img-fluid rounded-circle mb-3" src="img/jx.jpg" alt="">
            <h5>Jiaxuan Wu.</h5>
            <p class="font-weight-light mb-0">"Welcome to our online library and community of knowledge-seekers!"</p>
			      <br><br><br><br>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="testimonial-item mx-auto mb-5 mb-lg-0">
            <img class="img-fluid rounded-circle mb-3" src="img/kx.jpg" alt="">
            <h5>Kexin Zheng</h5>
            <p class="font-weight-light mb-0">"Sharing notes has never been easier. Join our community and start sharing today!"</p>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="testimonial-item mx-auto mb-5 mb-lg-0">
            <img class="img-fluid rounded-circle mb-3" src="img/lsc.jpg" alt="">
            <h5>Shuchang Li</h5>
            <p class="font-weight-light mb-0">"Connect with like-minded individuals and expand your knowledge through our social platform."</p>

          </div>
        </div>
        <div class="col-lg-4">
          <div class="testimonial-item mx-auto mb-5 mb-lg-0">
            <img class="img-fluid rounded-circle mb-3" src="img/hy.jpg" alt="">
            <h5>Haoyang Li</h5>
            <p class="font-weight-light mb-0">"Our mission is to make learning and knowledge-sharing accessible to everyone, everywhere."</p>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="testimonial-item mx-auto mb-5 mb-lg-0">
            <img class="img-fluid rounded-circle mb-3" src="img/zbx.jpg" alt="">
            <h5>Boxuan Zhu</h5>
            <p class="font-weight-light mb-0">"Experience the power of community-driven learning with our online platform."</p>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="testimonial-item mx-auto mb-5 mb-lg-0">
            <img class="img-fluid rounded-circle mb-3" src="img/zp.jpg" alt="">
            <h5>Peng Zheng</h5>
            <p class="font-weight-light mb-0">"Our user-friendly interface and diverse range of resources make learning engaging and enjoyable."</p>
          </div>
        </div>
      </div>
    </div>
  </section>
  
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

  <!-- Bootstrap core JavaScript -->
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
