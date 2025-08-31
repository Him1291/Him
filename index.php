<?php include '../connection.php';



if (isset($_POST['login'])) {


  $users = $_POST['usernames'];
  $passs = $_POST['passwords'];


      $sqls = "SELECT * FROM users WHERE username = '$users'";
      $stmts = $conn->prepare($sqls);
      $stmts->execute();
      $results = $stmts->get_result();
      $rows = $results->fetch_assoc();  

      session_regenerate_id();
      $_SESSION['username'] = @$rows['username'];
      $_SESSION['fullname'] = @$rows['fullname'];

      session_write_close();

      if (empty($users) || empty($passs)) {
  
        echo '<script>alert("Type Username and Password!")</script>';
    
     }else{
        if (@$rows['password'] == $passs || @$rows['position'] == 'Admin') {
       
          header("Location: dashboard.php");
          $_SESSION['response']="Welcome Admin Successfully";
          $_SESSION['type']="success";

      }else{

          $_SESSION['response']="Incorrect Credentials";
    $_SESSION['type']="danger";
      }
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
  <link href="../img/logo/logo.png" rel="icon">
   <title>Product Scanner</title>
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="../css/ruang-admin.min.css" rel="stylesheet">
  <link href="../css/style.css" rel="stylesheet">

</head>

<body class="bg-gradient-login">

  <div id="loader-wrapper">
      <div id="loader"></div>        
      <div class="loader-section section-left"></div>
      <div class="loader-section section-right"></div>
  </div>
  <!-- Login Content -->
  <div class="container-login mt-5">
    <div class="row justify-content-center">
      <div class="col-xl-4 col-lg-5 col-md-5">
        <div class="card shadow-sm my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
               
      <?php if(isset($_SESSION['response'])){ ?>
<div class="alert alert-<?= $_SESSION['type']; ?> alert-dismissible">
  <button type="button" class="close" data-dismiss="alert">&times </button>
  <?= $_SESSION['response']; ?>
  </div>
<?php  unset($_SESSION['response']); 
} ?>

                <div class="login-form">

                  <div class="text-center"> 
                     <img class="img-profile rounded-circle mb-3" src="../img/logo/logo.png" style="max-width: 200px">
                    <h1 class="h4 text-gray-900 mb-4" style="font-size: 25px; font-weight: bold;">Admin Login</h1>
                  </div>
                  <form action="" method="post" class="user">
                    <div class="form-group">
                      <input type="text" class="form-control" id="exampleInputEmail" aria-describedby="emailHelp"
                        placeholder="Enter Username" name="usernames">
                    </div>
                    <div class="form-group">
                      <input type="password" name="passwords" class="form-control" id="exampleInputPassword" placeholder="Password">
                    </div>
                    <div class="form-group">
                      <div class="custom-control custom-checkbox small" style="line-height: 1.5rem;">
                        <input type="checkbox" class="custom-control-input" id="customCheck">
                     
                      </div>
                    </div>
                    <div class="form-group">
                      <button type="submit" class="btn btn-primary btn-block" name="login">Login</a>
                    </div>
            
                    
                  </form>
                        
                  <hr>
                  
                  <div class="text-center">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  <!-- Login Content -->
  <script src="../js/jquery-1.11.2.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="../js/ruang-admin.min.js"></script>
  <script src="../js/plugins.min.js"></script>
</body>

</html>
<script type="text/javascript">
  $(document).ready(function() {
  $('button').click(function(){
    $('#overlay').fadeIn().delay(2000).fadeOut();
  });
});



</script>

    <script>
            const imageInput = document.getElementById("imageInput");
            const imagePreview = document.getElementById("imagePreview");

            imageInput.addEventListener("change", function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imagePreview.src = e.target.result;
                        imagePreview.style.display = "block";
                    };
                    reader.readAsDataURL(file);
                } else {
                    imagePreview.src = "#";
                    imagePreview.style.display = "none";
                }
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