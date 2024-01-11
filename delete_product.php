<?php
require('dbConnect.php');
if (isset($_GET['id_p'])) {
    $product_id = $_GET['id_p'];

    //get product from database with ID
    $deleteQuery = "DELETE from products where product_id = $product_id";
    if ($connection->query($deleteQuery) === TRUE) {
        // Utiliser une session pour stocker le message du toast
        session_start();
        $_SESSION['toastMessage'] = "Product deleted successfully";
        // Rediriger vers la même page après l'ajout
        header("Location: index.php");
        exit();
    } else {
        $toastMessage = "Error adding product: " . $connection->error;
    }
}
