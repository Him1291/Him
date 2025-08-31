<?php include '../connection.php'; 


if (!isset($_SESSION['username'])) {
 header("Location: index.php");
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
  <link href="../img/logo/logo.png" rel="icon">
  <title>Product Scanner</title>
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="../css/ruang-admin.min.css" rel="stylesheet">
   <link href="../css/style.css" rel="stylesheet">
</head>

<body id="page-top">

  <div id="wrapper" >
    <!-- Sidebar -->
<?php include 'includes/sidebar.php'; ?>
    <!-- Sidebar -->
    <div id="content-wrapper" class="d-flex flex-column" >
      <div id="content" >
        <!-- TopBar -->
   <?php include 'includes/navbar.php'; ?>

        <!-- Topbar -->





        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
          </div>

          <div class="row mb-3">

              <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                    
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Product</div>
                         
                      <div class="h1 mb-0 mr-3 font-weight-bold text-gray-800">
          
                          </div>
                      <div class="mt-2 mb-0 text-muted text-xs">
                
                      </div>
                    </div>
                    <div class="col-auto">
                      <a href="#"><i class="fa fa-shopping-bag fa-2x text-primary"></i></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          
              <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                    
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Verified</div>
                         
                      <div class="h1 mb-0 mr-3 font-weight-bold text-gray-800">
          
                          </div>
                      <div class="mt-2 mb-0 text-muted text-xs">
                
                      </div>
                    </div>
                    <div class="col-auto">
                      <a href="#"><i class="fa fa-check-circle fa-2x text-success"></i></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          
              <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                    
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Unverified</div>
                         
                      <div class="h1 mb-0 mr-3 font-weight-bold text-gray-800">
          
                          </div>
                      <div class="mt-2 mb-0 text-muted text-xs">
                
                      </div>
                    </div>
                    <div class="col-auto">
                      <a href="#"><i class="fa fa-times-circle fa-2x text-danger"></i></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          
            <!-- Earnings (Annual) Card Example -->
              <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                    
                      <div class="text-xs font-weight-bold text-uppercase mb-1">History</div>
                         
                      <div class="h1 mb-0 mr-3 font-weight-bold text-gray-800">
          
                          </div>
                      <div class="mt-2 mb-0 text-muted text-xs">
                
                      </div>
                    </div>
                    <div class="col-auto">
                      <a href="#"><i class="fa fa-list fa-2x text-secondary"></i></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- New User Card Example -->
         
            <!-- Pending Requests Card Example -->
        


            <!-- Donut Chart -->
          
         


          <!-- Modal Logout -->
          <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabelLogout">Ohh No!</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div id="overlay" style="display:none;">
    <div class="spinner"></div>
    <br/>
    Loading...
</div>
                  <p>Are you sure you want to logout?</p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
                  <a href="logout.php" class="logout btn btn-primary">Logout</a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!---Container Fluid-->
      </div>
    </div>
      <!-- Footer -->
    <?php include 'includes/footer.php'; ?>
      <!-- Footer -->
    </div>
  </div>



  <!-- Scroll to top -->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

 <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
 <script src="../morris/morris.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="../js/ruang-admin.min.js"></script>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script src="../js/jquery-1.11.2.min.js"></script>
  <script src="../js/plugins.min.js"></script>

</body>

</html>
<script>
  $('#cars').change(function(){
    window.location.href = 'home.php?year='+$(this).val();
  });


Morris.Bar({
 element : 'chart',
 data:[<?php echo $chart_data; ?>],
 xkey:'time',
 ykeys:['Blotter'],
 labels:['Blotter'],
 hideHover:'auto',
 stacked:true
});
$(document).ready(function() {
  $('.logout').click(function(){
    $('#overlay').fadeIn().delay(2000).fadeOut();
  });
});
</script>
<style type="text/css">
  #overlay {
  background: #ffffff;
  color: #666666;
  position: fixed;
  height: 100%;
  width: 100%;
  z-index: 5000;
  top: 0;
  left: 0;
  float: left;
  text-align: center;
  padding-top: 25%;
  opacity: .80;
}
.spinner {
    margin: 0 auto;
    height: 64px;
    width: 64px;
    animation: rotate 0.8s infinite linear;
    border: 5px solid firebrick;
    border-right-color: transparent;
    border-radius: 50%;
}
@keyframes rotate {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}
</style>

