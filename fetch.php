<?php include '../connection.php'; ?>

<?php
$input = $_GET['in'];
$query = "SELECT * FROM product WHERE prod_type = ? AND `status` = 0";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $input);
$stmt->execute();
$result = $stmt->get_result();

echo '<div class="row">'; // Start row

foreach ($result as $row) {
    echo '
    <div class="col-md-6 text-center"> <!-- Each product takes half the row -->
        <img src="../uploads/' . $row["qr_image"] . '" class="img-fluid mb-2" width="100">
        <input type="text" name="types" class="form-control" value="' . $row["prod_QR"] . '" style="text-align: center; border: none; outline: none; background: transparent; margin-top:-.5cm; font-weight:bold; color:black;" >
    </div>';
}

echo '</div>'; // End row
?>
