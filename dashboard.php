<?php 
include '../connection.php'; 
session_start();

if (!isset($_SESSION['username'])) {
   header("Location: index.php");
   exit();
}

// ===== FETCH COUNTS =====
$product_count   = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) AS total FROM rpos_products"))['total'];
$verified_count  = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) AS total FROM rpos_products WHERE status='Verified'"))['total'];
$unverified_count= mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) AS total FROM rpos_products WHERE status='Unverified'"))['total'];
$history_count   = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) AS total FROM rpos_orders"))['total'];

// ===== BUILD CHART DATA =====
$chart_data = '';
$query = mysqli_query($conn, "SELECT DATE_FORMAT(order_date, '%M') AS time, COUNT(*) AS Blotter FROM rpos_orders GROUP BY MONTH(order_date)");
while ($row = mysqli_fetch_assoc($query)) {
   $chart_data .= "{ time:'".$row['time']."', Blotter:".$row['Blotter']."}, ";
}
$chart_data = rtrim($chart_data, ", ");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="../img/logo/logo.png" rel="icon">
  <title>Product Scanner</title>
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="../css/ruang-admin.min.css" rel="stylesheet">
  <link href="../css/style.css" rel="stylesheet">
</head>

<body id="page-top">
  <div id="wrapper">
    <!-- Sidebar -->
    <?php include 'includes/sidebar.php'; ?>
    <!-- Sidebar -->

    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
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
            <!-- Product -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Product</div>
                      <div class="h1 mb-0 mr-3 font-weight-bold text-gray-800" id="product_count">
                        <?php echo $product_count; ?>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fa fa-shopping-bag fa-2x text-primary"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Verified -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Verified</div>
                      <div class="h1 mb-0 mr-3 font-weight-bold text-gray-800" id="verified_count">
                        <?php echo $verified_count; ?>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fa fa-check-circle fa-2x text-success"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Unverified -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Unverified</div>
                      <div class="h1 mb-0 mr-3 font-weight-bold text-gray-800" id="unverified_count">
                        <?php echo $unverified_count; ?>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fa fa-times-circle fa-2x text-danger"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- History -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">History</div>
                      <div class="h1 mb-0 mr-3 font-weight-bold text-gray-800" id="history_count">
                        <?php echo $history_count; ?>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fa fa-list fa-2x text-secondary"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Orders Chart -->
          <div class="row">
            <div class="col-lg-12">
              <div class="card shadow mb-4">
                <div class="card-header">
                  <h6 class="m-0 font-weight-bold text-primary">Orders Chart</h6>
                </div>
                <div class="card-body">
                  <div id="chart" style="height: 250px;"></div>
                </div>
              </div>
            </div>
          </div>

          <!-- Modal Logout -->
          <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Ohh No!</h5>
                  <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                  <div id="overlay" style="display:none;">
                    <div class="spinner"></div>
                    <br/>Loading...
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

<!-- Scripts -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="../morris/morris.min.js"></script>
<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="../js/ruang-admin.min.js"></script>

<script>
Morris.Bar({
  element : 'chart',
  data:[<?php echo $chart_data; ?>],
  xkey:'time',
  ykeys:['Blotter'],
  labels:['Orders'],
  hideHover:'auto',
  stacked:true
});

$(document).ready(function() {
  $('.logout').click(function(){
    $('#overlay').fadeIn().delay(2000).fadeOut();
  });
});
</script>

<style>
#overlay {
  background: #ffffff;
  color: #666666;
  position: fixed;
  height: 100%;
  width: 100%;
  z-index: 5000;
  top: 0;
  left: 0;
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
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>
</body>
</html>


