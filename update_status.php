<?php
require '../connection.php'; // Make sure this file contains your database connection code

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['product']) && isset($_POST['type'])) {
        $product = $_POST['product'];
        $type = $_POST['type'];
         $currentTimestamp = date('Y-m-d H:i:s');
         $prod = 'Verified';
        // Update status in the database
        $sql = "UPDATE product SET status = 1, timestat = '$currentTimestamp' , prod_stat = ' $prod' WHERE prod_name = ? AND prod_type = ? ";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $product, $type);

        if ($stmt->execute()) {
            echo "Success";
            header("Location:product.php");
        } else {
            echo "Error: " . $conn->error;
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "Invalid input data.";
    }
} else {
    echo "Invalid request method.";
}
?>
