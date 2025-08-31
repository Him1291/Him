<?php include '../connection.php'; 



if (isset($_POST['submit'])) {

  $user = $_POST['uname'];
  $pass = md5($_POST['contact']);
  $email = $_POST['ema'];
  $first = $_POST['fname'];
  $middle = $_POST['mname'];
  $last = $_POST['lname'];
  $suf = $_POST['suffs'];
  $gend = $_POST['gend'];
  $ag = $_POST['age'];
  $bdate = $_POST['bdate'];
  $add = $_POST['adds'];
  $cont = $_POST['contact'];
  $usertype = 'User';
  $stat = 'Available';
  $fullname = $_POST['fname'] . ' ' . $_POST['mname'] . ' ' . $_POST['lname'] . ' ' . $_POST['suffs'];

    $imagez = $_FILES['images']['name'];
  
      $upload = "courier/".$imagez;

      $sql = "SELECT * FROM users WHERE Username = '$user'";
      $stmt = $conn->prepare($sql);
      $stmt->execute();
      $result = $stmt->get_result();
      $row = $result->fetch_assoc();

      if (@$row['Username'] == $user) {
       
       echo '<script>alert("Username is already used")</script>';

      }else{


   $query = "INSERT INTO `users`(`Username`, `Password`,`Email`,`First_Name`, `Middle_Name`, `Last_Name`, `Suffix`, `Gender`, `Age`, `Birth_Date`, `Contact`, `Address`, `Photo`, `User_type`, `status` , `driver_name`) VALUES ('$user','$pass','$email','$first','$middle','$last','$suf','$gend','$ag','$bdate','$cont','$add','$imagez','$usertype','$stat', '$fullname')";
    $stmts = $conn->prepare($query);
    $stmts->execute();
    move_uploaded_file($_FILES['images']['tmp_name'], $upload);

       $_SESSION['response']="Account   Register Successfully";
    $_SESSION['type']="success";
   }
}


if (isset($_GET['remove'])) {
    $idz = $_GET['remove'];

    $sqlss = "DELETE FROM `users` WHERE u_id = '$idz'";
    $conn->query($sqlss);
       $_SESSION['response']="Account Register Removed";
    $_SESSION['type']="danger";
    // code...
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
  <link href="img/logo/logo.png" rel="icon">
  <title>Item Tracking System</title>
 <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="../css/ruang-admin.min.css" rel="stylesheet">
  <link href="../css/spinner.css" rel="stylesheet">
  <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
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

        <div class="col-lg-12">
      <?php if(isset($_SESSION['response'])){ ?>
<div class="alert alert-<?= $_SESSION['type']; ?> alert-dismissible">
  <button type="button" class="close" data-dismiss="alert">&times </button>
  <?= $_SESSION['response']; ?>
  </div>
<?php  unset($_SESSION['response']); 
} ?>
</div>


        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">List of Courier</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">My Products</a></li>
              <li class="breadcrumb-item active" aria-current="page">Products</li>
            </ol>
          </div>

          <div class="row mb-3">
           
          
             <div class="col-lg-12">
                <div class="card mb-4">
            
                     <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">COURIER</h6>
                      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  Add Courier       </button>
                    </div>
                      <div class="row">
                           



                          <div class="col">


               
           <div class="table-responsive p-3">

            <?php

            $sql = "SELECT * FROM users";
            $stmt= $conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
             ?>
               <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                <thead>
                  <tr>
                    <th style="display: none;"></th>
                    <th>#</th>
                    <th>Fullname</th>
                    <th>Gender</th>
                    <th>Address</th>
                    <th>Photo</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>

                    <?php
                    $i = 1;
                     while ($row = $result->fetch_assoc()) {
                        // code...
                     ?>
                  <tr>
                  
                    <td  style="display: none;"><?php echo $row['u_id'];?></td>
                    <td><?php echo $i++; ?></td>
                    <td><?php echo $row['First_Name']." ".$row['Middle_Name']." ".$row['Last_Name']." ".$row['Suffix'];?></td>
                    <td><?php echo $row['Gender'] ?></td>
                    <td><?php echo $row['Address'] ?></td>
                    <td><img src="courier/<?php echo $row['Photo']; ?>" width = "80"></td>
                    <td><?php echo $row['Status'] ?></td>
                    <td>
                        
                    <a href="account.php?remove=<?= $row['u_id'] ?>" class="badge badge-danger p-3" onclick="return confirm('Are you sure want to remove this item?');"><i class="fas fa-times-circle"></i> </a></td>
            
                    </td>

                  </tr>
              <?php } ?>
                </tbody>
               </table>
           </div>


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


<!-- ADD MODAL -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
       <div class="modal-header text-light bg-primary">
        <h5 class="modal-title" id="exampleModalLabel">ADD COURIER</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
       <form method="POST" enctype="multipart/form-data">   
      <div class="modal-body">
   
  <label style="font-size: 20px;" class="text-primary"><b>Driver's Information</b></label>
    <div class="row">
 <div class="col">

            <label><b>First Name:</b></label>
            <input type="text" class="form-control" name="fname" placeholder="First Name"  onkeypress="return /[a-z, ]/i.test(event.key)" required>
        </div> 
        <div class="col">

            <label><b>Middle Name:</b></label>
            <input type="text" class="form-control" name="mname" placeholder="Middle Name"  onkeypress="return /[a-z, ]/i.test(event.key)" >
        </div> 
        <div class="col">

            <label><b>Last Name:</b></label>
            <input type="text" class="form-control" name="lname" placeholder="Last Name"  onkeypress="return /[a-z, ]/i.test(event.key)" required>
        </div> 
      
    </div><br>
       <div class="row">
         <div class="col">

            <label><b>Suffix:</b></label>
                <select name="suffs" class="form-control">
                    <option value="">----</option>
                    <option value="Jr.">Jr.</option>
                    <option value="Sr.">Sr.</option>
                    <option value="I">I</option>
                    <option value="II">II</option>
                    <option value="III">III</option>
                    <option value="IV">IV</option>
                    <option value="V">V</option>
            </select>
        </div> 
        <div class="col">

            <label><b>Gender:</b></label>
               <select name="gend" class="form-control" required>
                    <option>----</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
            </select>
        </div> 
        <div class="col">

            <label><b>Age:</b></label>
            <input type="number" class="form-control" name="age" placeholder="Age" required>
        </div> 
    </div><br>
        <div class="row">
         <div class="col">

            <label><b>Birth Date:</b></label>
                 <input type="date" class="form-control" name="bdate" placeholder="Birth Date" required>   
        </div> 
        <div class="col">

            <label><b>Address:</b></label>
             <textarea class="form-control" name="adds"  cols="3" style="resize: none; height:1.1cm;" placeholder="Address" required> </textarea>
        </div> 
        <div class="col">

            <label><b>Contact Number:</b></label>
                  <input type="text" name="contact" class="form-control" maxlength="11" placeholder="Ex. 09xxxxxxx" onkeypress="return /[0-9]/i.test(event.key)" required> 
        </div> 
    </div><br>
        <div class="row">
      
              <div class="col">
                <center><label style="font-family: Courier New;">Photo</label>
                <img id="imagePreview" src="#" alt="Image Preview" style="display: none; max-width: 300px; max-height: 300px;"/><br>
                <input type="file" name="images" id="imageInput" accept="image/*" required></center>
              </div>
         
    </div>

      <hr style="border: solid;">
   <label style="font-size: 20px;" class="text-primary"><b>Driver's Account</b></label>
    <div class="row">
         <div class="col">

            <label><b>Username:</b></label>
            <input type="text" class="form-control" name="uname" placeholder="Username">
        </div>
    
       <div class="col">

            <label><b>Email:</b></label>
            <input type="email" class="form-control" name="ema" placeholder="Email" required>
        </div> 
    </div>


      

    </div>
      <div class="modal-footer">

        <button type="submit" class="btn btn-primary" name="submit">CREATE</button>
      </div>
     </form>
    </div>
  </div>
</div>


<!-- ADD MODAL END -->

<!--LOGOUT MODAL -->
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

  <!-- Scroll to top -->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="../js/ruang-admin.min.js"></script>
  <!-- Page level plugins -->
  <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>
  <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>

</body>

</html>
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
<script>

$(document).ready(function() {
       $('#dataTable').DataTable(); 
      $('#dataTableHover').DataTable();

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

