<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>

<body>
    <?php
    require('dbConnect.php');
    if (isset($_GET['id_p'])) {
        $product_id = $_GET['id_p'];

        //get product from database with ID
        $query = "SELECT * from products where product_id = $product_id";
        $result = mysqli_query($connection, $query);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // Recuperer les données du produit
            $product_name = $row['product_name'];
            $price = $row['price'];
        } else {
            echo "error";
        }
    }
    ?>
    <div class="container-lg">
        <h1 class="text-center mt-5">Add products</h1>
        <div class="container-fluid w-50 mt-5">
            <form method="post" action="" class="d-flex flex-column justify-content-center">
                <div class="mb-3">
                    <label for="product_name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="product_name" name="product_name" value="<?php echo $product_name; ?>" required />
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="number" name="price" class="form-control" id="price" value="<?php echo $price; ?>" required />
                </div>

                <button type="submit" name="submitBtn" class="btn btn-primary">Update Product</button>
            </form>
        </div>
        <?php
        if (isset($_POST['submitBtn'])) {

            $product_name = $_POST["product_name"];
            $price = $_POST["price"];
            //update product in database
            $updateQuery = "UPDATE products SET product_name='$product_name', price='$price' WHERE product_id=$product_id";
            //check save to database
            if ($connection->query($updateQuery) === TRUE) {
                // Utiliser une session pour stocker le message du toast
                session_start();
                $_SESSION['toastMessage'] = "Product updated successfully";
                // Rediriger vers la même page après l'ajout
                header("Location: index.php");
                exit();
            } else {
                $toastMessage = "Error adding product: " . $connection->error;
            }
        }
        ?>
</body>

</html>