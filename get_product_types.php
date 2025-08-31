<?php
include '../connection.php'; // Include your database connection

if (isset($_POST['product'])) {
    $product = $_POST['product'];

    // Query to get product types based on the selected product
    $sql = "SELECT prod_type FROM product WHERE prod_name = ? GROUP BY prod_type";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $product);
    $stmt->execute();
    $result = $stmt->get_result();

    // Generate options for the product type dropdown
    $options = '<option value="">-SELECT TYPE-</option>';
    while ($row = $result->fetch_assoc()) {
        $options .= '<option value="' . htmlspecialchars($row['prod_type']) . '">' . htmlspecialchars($row['prod_type']) . '</option>';
    }

    echo $options; // Return the options
}
?>