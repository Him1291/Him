<?php include '../connection.php'; 

require_once '../phpqrcode/qrlib.php';
$path = '../uploads/';

if (isset($_POST['submit'])) {

    $proqr   = $_POST['tnum'];
    $prod    = $_POST['prod'];
    $type    = $_POST['categ'];
    $prodes  = $_POST['proddes'];
    $subdes  = $_POST['subdes'];
    $pcr     = $_POST['pcrs'];
    $fda     = $_POST['fdas'];
    $ver = 'Unverified';
    $times = date('Y-m-d H:i:s');


      $imagez = $_FILES['images']['name'];

            $uploadz = "images/".$imagez;
    
    // Set the QR image filename with .png extension
    $proqr_with_ext = $proqr . ".png";
    
    // Full file path for the QR image
    $qr_file_path = $path . $proqr_with_ext;

    $sqls = "SELECT * FROM product WHERE `prod_QR` = ?";
    $stmts = $conn->prepare($sqls);
    $stmts->bind_param("s", $proqr);
    $stmts->execute();
    $results = $stmts->get_result();
    $rows = $results->fetch_assoc();

    if (isset($rows['prod_QR']) && $rows['prod_QR'] == $proqr) {
        $_SESSION['response'] = "Product Number Already Exists";
        $_SESSION['type'] = "danger";
    } else {
        $sqlsz = "INSERT INTO `product`(`prod_QR`, `prod_name`, `prod_type`, `prod_description`, `sub_description`, `PCR`, `FDA`, `qr_image`,`prod_image`,`prod_stat`,`timestat`)
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?,?,?,?)";
        $stmtsz = $conn->prepare($sqlsz);
      $stmtsz->bind_param("sssssssssss", $proqr, $prod, $type, $prodes, $subdes, $pcr, $fda, $proqr_with_ext,$imagez, $ver, $times);
        $stmtsz->execute();
          move_uploaded_file($_FILES['images']['tmp_name'], $uploadz);
        QRcode::png($proqr, $qr_file_path);


        $_SESSION['response'] = "Product Successfully Entered";
        $_SESSION['type'] = "success";
    }
}

if (isset($_POST['delete'])) {
  
  $ids = $_POST['myids'];

  $querys = "DELETE FROM `product` WHERE prod_id = '$ids'";
  $stmt = $conn->prepare($querys);
  $stmt->execute();

     $_SESSION['response'] = "Product Successfully Removed";
        $_SESSION['type'] = "danger";
}

if (isset($_POST['print'])) {
  


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
  <title>Product Scanner</title>
 <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="../css/ruang-admin.min.css" rel="stylesheet">
  <link href="../css/spinner.css" rel="stylesheet">
  <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>

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
            <h1 class="h3 mb-0 text-gray-800">List of Product</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Product</a></li>
              <li class="breadcrumb-item active" aria-current="page">Admin</li>
            </ol>
          </div>

          <div class="row mb-3">
           
          
             <div class="col-lg-12">
                <div class="card mb-4">
            
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
    <h6 class="m-0 font-weight-bold text-primary">PRODUCT</h6>
    <div class="btn-group" role="group" aria-label="Product Actions">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
            Add Product
        </button> &nbsp;
        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#generate">
            Generate
        </button>
    </div>
</div>
                      <div class="row">
                            

                          <div class="col">


                      <div class="table-responsive p-3">

            <?php

            $sql = "SELECT * FROM product WHERE status = 0";
            $stmt= $conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
             ?>

               <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                <thead>
                  <tr>
                    <th style="display: none;"></th>
                    <th>#</th>
                    <th>Product Number</th>
                    <th>Product Name</th>
                    <th>Product Type</th>
                  <th>Product Description</th>
                    <th>Sub Description</th>
                    <th>Phil. Co. Reg.</th>
                        <th>Food, Drug, Adm.</th>
                            <th>Product Image</th>
                         <th>Product Status</th>
                        <th>Time Added</th>
                        <th>QR CODE</th>



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
                    <td style="display: none;"><?php echo $row['prod_id']; ?></td>
                    <td><?php echo $i++; ?></td>
                    <td><?php echo $row['prod_QR']; ?></td>
                    <td><?php echo $row['prod_name']; ?></td>
                    <td><?php echo $row['prod_type']; ?></td>
                             <td><?php echo $row['prod_description']; ?></td>
                                <td><?php echo $row['sub_description']; ?></td>
                                   <td><?php echo $row['PCR']; ?></td>
                                      <td><?php echo $row['FDA']; ?></td>
                                        <td><img src="images/<?php echo urlencode($row['prod_image']); ?>" width="70"></td>
                                          <td><?php echo $row['prod_stat']; ?></td>
                                              <td><?php echo $row['timestat']; ?></td>
                    <td> 
        <img src="../uploads/<?php echo urlencode($row['qr_image']); ?>" width="70">
    </td>

                    <td>
                      <a href="#deleteModals" class="delete badge text-danger " >Remove</a>        
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

<script>
 function callme(s) {
  if (!s) {
    document.getElementById("mine").innerHTML = ''; // Clear content if no batch is selected
    return;
  }
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4) {
      if (this.status == 200) {
        document.getElementById("append").innerHTML = this.responseText;
      } else {
        console.error("Error fetching data:", this.statusText);
      }
    }
  };
  xmlhttp.open("GET", "fetch.php?in=" + encodeURIComponent(s), true);
  xmlhttp.send();
}
</script>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
       <div class="modal-header text-light bg-primary">
        <h5 class="modal-title" id="exampleModalLabel">ADD REQUEST</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
       <form method="POST" enctype="multipart/form-data">   
      <div class="modal-body">
   

    <div class="row">
                    <?php
       $numchars = 11;
$chars = explode(',', '0,1,2,3,4,5,6,7,8,9'); // Removed trailing comma
$random = '';

for ($i = 0; $i < $numchars; $i++) {
  $random .= $chars[rand(0, count($chars) - 1)];
}

                        ?>

         <div class="col">
      
            <label><b>Product Number:</b></label>
            <input type="text" class="form-control" name="tnum" value="<?php echo $random; ?>" readonly>
        </div>

         <div class="col">

            <label><b>Product Name:</b></label>
            <input type="text" class="form-control" name="prod" required>
        </div>
    
      
    </div>

   <br>
    <div class="row">
         <div class="col">
            <label><b>Category:</b></label>
            <select name="categ" class="form-control">
                    <option>----</option>
                    <option value="Technology">Technology</option>
                    <option value="Food">Food</option>
                    <option value="Skincare">Skincare</option>
        
            </select>
        </div>
        <div class="col">

            <label><b>Product Description:</b></label>
                      <textarea class="form-control" name="proddes" required> </textarea>
        </div>
    </div>
        
          <div class="row">
         <div class="col">
        <label><b>Sub-Description:</b></label>
            <textarea class="form-control" name="subdes" required> </textarea>
        </div>
   
    </div>
    <br> 
  <div class="row">
  <!-- PCR Group -->
  <div class="col">
    <label><b>PCR :</b></label>
    <input type="checkbox" name="pcrs" id="pcr-approved" value="approved" onclick="toggleGroupCheckboxes(this)"> Approved
    <input type="checkbox"  name="pcrs"  id="pcr-disapproved" value="disapproved" onclick="toggleGroupCheckboxes(this)"> Disapproved
  </div>

  <!-- FDA Group -->
  <div class="col">
    <label><b>FDA :</b></label>
    <input type="checkbox" id="fda-approved" name="fdas" value="approved" onclick="toggleGroupCheckboxes(this)"> Approved
    <input type="checkbox" id="fda-disapproved" name="fdas"  value="disapproved" onclick="toggleGroupCheckboxes(this)"> Disapproved
  </div>
</div>
<br>
<div class="row">
    <div class="col">
                       <center>  <label class="" >Product Photo</label>
        
                <img id="imagePreview" src="#" alt="Image Preview" style="display: none; max-width: 300px; max-height: 300px;"/><br>
                <input type="file" name="images" id="imageInput" accept="image/*">
              
        </center>
    </div>
</div>
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
  function toggleGroupCheckboxes(selectedCheckbox) {
    // Find the closest parent container (here, the column) for this group
    const container = selectedCheckbox.closest('.col');
    // Uncheck all checkboxes in this container except the one that was just clicked
    container.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
      if (checkbox !== selectedCheckbox) {
        checkbox.checked = false;
      }
    });
  }
</script>



 
    </div>
      <div class="modal-footer">

        <button type="submit" class="btn btn-success" name="submit">ADD</button>
      </div>
     </form>
    </div>
  </div>
</div>


<!-- ADD MODAL END -->
<div class="modal fade" id="generate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
       <div class="modal-header text-light bg-primary">
        <h5 class="modal-title" id="exampleModalLabel">ADD REQUEST</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
       <form method="POST" enctype="multipart/form-data">   
      <div class="modal-body">
   

    <div class="row">
    <div class="col">
        <?php
        // Query to get all products from the database
        $sql = "SELECT prod_name FROM product GROUP BY prod_name LIMIT 10";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        ?>
        <label><b>Product Name:</b></label>
        <select id="productSelect" name="prods" class="form-control">
            <option value="">-SELECT PRODUCT-</option>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <option value="<?php echo htmlspecialchars($row['prod_name']); ?>"><?php echo htmlspecialchars($row['prod_name']); ?></option>
            <?php } ?>
        </select>
    </div>

    <div class="col">
        <label><b>Product Type:</b></label>
        <select id="typeSelect" name="prod_types" class="form-control" onchange="return callme(this.value);"> 
            <option value="">-SELECT TYPE-</option>
        </select>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#productSelect').change(function() {
        var selectedProduct = $(this).val();
        if (selectedProduct) {
            $.ajax({
                url: 'get_product_types.php', 
                type: 'POST',
                data: { product: selectedProduct },
                success: function(data) {
                    $('#typeSelect').html(data);
                }
            });
        } else {
            $('#typeSelect').html('<option value="">-SELECT TYPE-</option>');
        }
    });
});
</script>
<script>
 function callme(s) {
  if (!s) {
    document.getElementById("mine").innerHTML = ''; // Clear content if no batch is selected
    return;
  }
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4) {
      if (this.status == 200) {
        document.getElementById("mine").innerHTML = this.responseText;
      } else {
        console.error("Error fetching data:", this.statusText);
      }
    }
  };
  xmlhttp.open("GET", "fetch.php?in=" + encodeURIComponent(s), true);
  xmlhttp.send();
}
</script>
   <br>
  
        
    <div id="mine"></div>

 
    </div>
      <div class="modal-footer">

        <button type="submit" class="btn btn-success" name="print" onclick="printModalContent(event)">Print</button>

      </div>
     </form>
    </div>
  </div>
</div>


<!-- ASSIGN MODAL -->
<script>
function printModalContent(event) {
    if (event) {
        event.preventDefault(); // Prevent form submission
    }

    const selectedProduct = document.getElementById("productSelect").value;
    const selectedType = document.getElementById("typeSelect").value;

    if (!selectedProduct || !selectedType) {
        alert("Please select both product and product type before printing.");
        return;
    }

    // AJAX call to update the database status
    $.ajax({
        url: 'update_status.php',
        type: 'POST',
        data: { product: selectedProduct, type: selectedType },
        success: function(response) {
            console.log("Status updated successfully:", response);
            
            // Now, proceed with the print operation
            const modalContent = document.querySelector("#mine");
            if (!modalContent) {
                console.error("Modal content not found.");
                return;
            }

            // Use html2canvas to capture the content
            html2canvas(modalContent, { useCORS: true, scale: 2 }).then((canvas) => {
                const imgData = canvas.toDataURL("image/png");

                const link = document.createElement("a");
                link.href = imgData;
                link.download = "qrcodes.png"; // Set filename

                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }).catch((error) => {
                console.error("Error capturing content:", error);
            });
        },
        error: function(xhr, status, error) {
            console.error("Error updating status:", error);
        }
    });
}

</script>


<!-- ASSIGN MODAL END -->


<div class="modal fade" id="deleteModals" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                  <h5 class="modal-title" id="exampleModalLabelLogout">Ohh No!</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                         <div id="overlay2" style="display: none;">
    <div class="spinner"></div>
    <br/>
    Loading...
</div>  

              <form action="" method="post">
    <input type="hidden" name="myids" id="myids">
    <center>
        <p>Are you sure you want to remove this data?</p>
        <h4><b>Product Number:</b></h4>
        <br>
        <h4 id="dataa" id = ""></h4>
    </center>
                       
                </div>

                <div class="modal-footer">
                  <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
                  <button type="submit" class="deleteb btn btn-danger" name="delete">Delete</button>
                </div>
      </form> 
              </div>
            </div>
</div>

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
$(document).ready(function() {
     $('#dataTable').DataTable(); 
      $('#dataTableHover').DataTable();


$(document).on('click', '.delete', function (e) {
    $('#deleteModals').modal('show');
    $tr = $(this).closest('tr');
    var data = $tr.children("td").map(function () {
        return $(this).text().trim(); // Remove any extra spaces.
    }).get();

    console.log(data); // Debugging: Check the data array in the console.

    $('#myids').val(data[0]); // Set the hidden input field.
    $('#dataa').text(data[2]); // Use .text() to set the text of the <h4> tag.
});



  $('.logout').click(function(){
    $('#overlay').fadeIn().delay(2000).fadeOut();
  });
});

$(document).on('click', '.editbtn', function (e) {
    $('#editModal').modal('show');

    const $tr = $(this).closest('tr'); // Get the closest row.
    const data = $tr.children("td").map(function () {
        return $(this).text().trim();
    }).get();

    console.log(data); // Debugging: Check row data in console.

    $('#hidd').val(data[0]); // Hidden field.
    $('#tnum').val(data[2]); // Tracking number.
    $('#prod').val(data[3]); // Product name.
    $('#categ').val(data[4]); // Category.
    $('#qual').val(data[6]); // Warning.
    $('#price').val(data[7]); // Price.
    $('#recz').val(data[8]); // Fullname.
     $('#sendz').val(data[9]); // 
    $('#contz').val(data[10]); // Contact number.
    $('#adds').val(data[11]); // Address.

    // Extract the image URL from the <img> tag in the table.
    const photoUrl = $tr.find('td:eq(5) img').attr('src');
    if (photoUrl) {
        $('#imagePreviewsd').attr('src', photoUrl).show();

        // Extract the file name from the image URL and display it in a readonly field
        const fileName = photoUrl.split('/').pop(); // Get the file name from the URL
        $('#imageFileName').val(fileName); // Set the file name in a readonly text field
    } else {
        $('#imagePreviewsd').hide();
        $('#imageFileName').val(''); // Clear the file name field
    }

    // Handle file input changes for uploading a new image.
    $('#imageInputsd').val(''); // Clear previous file input.
    $('#imageInputsd').on('change', function (event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                $('#imagePreviewsd').attr('src', e.target.result).show();

                // Update the readonly field with the selected file name
                $('#imageFileName').val(file.name);
            };
            reader.readAsDataURL(file);
        } else {
            $('#imagePreviewsd').hide();
            $('#imageFileName').val(''); // Clear the file name field
        }
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
/* Style for overlay (background when image is clicked) */


</style>

