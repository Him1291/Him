<?php 
include 'connection.php';

$input = $_GET['in'] ?? ''; // Ensure a default empty string
if (!$input) {
    echo '<h1 class = "text-danger">PRODUCT UNVERIFIED</h1>';
    exit;
}

$query = "SELECT * FROM product WHERE prod_QR = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $input);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo '<div class="row">';

    while ($row = $result->fetch_assoc()) {
        echo '
     <div class="row">
    <div class="col text-left">
        <b><p style="font-size: 16px; color:black;">Product Name:</p></b>
    </div>
    <div class="col text-left">
        <input type="text" name="types" class="form-control" 
            value="' . htmlspecialchars($row["prod_name"]) . '" 
            readonly style="border: none; outline: none; background: transparent; font-weight:bold; color:black; margin-left:1.1cm;">
    </div>
</div>

<div class="row">
    <div class="col text-left">
        <b><p style="font-size: 16px; color:black;">Product Type:</p></b>
    </div>
    <div class="col text-left">
        <input type="text" name="types" class="form-control" 
            value="' . htmlspecialchars($row["prod_type"]) . '" 
            readonly style="border: none; outline: none; background: transparent; font-weight:bold; color:black; margin-left:1.2cm;">
    </div>
</div>





<div class="row">
    <div class="col text-left">
       <b><p style="font-size: 16px; color:black;">Philippine Cosmetics Regulation:</p></b>
    </div>
    <div class="col text-left">
        <input type="text" name="types" class="form-control" 
            value="' . htmlspecialchars($row["PCR"]) . '" 
            readonly style="border: none; outline: none; background: transparent; font-weight:bold; color:black;">
    </div>
</div>

<div class="row">
    <div class="col text-left">
       <b><p style="font-size: 16px; color:black;">Food and Drugs Administration:</p></b>
    </div>
    <div class="col text-left">
        <input type="text" name="types" class="form-control" 
            value="' . htmlspecialchars($row["FDA"]) . '" 
            readonly style="border: none; outline: none; background: transparent; font-weight:bold; color:black;">
    </div>
</div>

<div class="row">
    <div class="col text-left">
      <b><p style="font-size: 16px; color:black;">Product Photo:</p></b>
        <br>
        <img src="admin/images/' . htmlspecialchars($row["prod_image"]) . '" 
            width="150" height="150" style="border-radius: 10px;">
    </div>
     <div class="col text-left">
      <b><p style="font-size: 16px; color:black;"></p></b>
        <br>
        <h1 class = "text-success">PRODUCT VERIFIED</h1>
    </div>
</div>
';
    }

    echo '</div>';
} else {
    echo '<h1 class = "text-danger">PRODUCT UNVERIFIED</h1>';
}
?>