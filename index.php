<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
  <link rel="stylesheet" href="style.css">
  <title>Products List</title>
</head>

<body>
  <div class="container-lg">
    <h1 class="text-center mt-5">Add products</h1>
    <div class="container-fluid w-50 mt-5">
      <form method="post" action="" class="d-flex flex-column justify-content-center">
        <div class="mb-3">
          <label for="product_name" class="form-label">Name</label>
          <input type="text" class="form-control" id="product_name" name="product_name" required />
        </div>
        <div class="mb-3">
          <label for="price" class="form-label">Price</label>
          <input type="number" name="price" class="form-control" id="price" />
        </div>

        <button type="submit" name="submitBtn" class="btn btn-primary">Add Product</button>
      </form>
    </div>
    <?php
    require('dbConnect.php');
    if (isset($_POST['submitBtn'])) {

      $product_name = $_POST["product_name"];
      $price = $_POST["price"];
      //add to database
      $sql = "INSERT INTO products (product_name,price) VALUES ('$product_name', '$price')";
      //check save to database
      if ($connection->query($sql) === TRUE) {
        // Utiliser une session pour stocker le message du toast
        session_start();
        $_SESSION['toastMessage'] = "Product added successfully";
        // Rediriger vers la même page après l'ajout
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
      } else {
        $toastMessage = "Error adding product: " . $connection->error;
      }
    }

    // Afficher le toast si présent dans la session
    session_start();
    $toastMessage = isset($_SESSION['toastMessage']) ? $_SESSION['toastMessage'] : "";
    unset($_SESSION['toastMessage']); // Supprimer le message de la session après utilisation
    ?>
    <!-- List of all products -->
    <div class="container w-75">
      <table class="table table-striped table-hover mt-4">
        <thead>
          <tr>
            <th scope="col"></th>
            <th scope="col">Product Name</th>
            <th scope="col">Price</th>
            <th scope="col" class="text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          //get all products from database
          $sqlGET = "SELECT * from products";
          $result = mysqli_query($connection, $sqlGET);
          if ($result->num_rows > 0) {
            $key = 0;
            while ($row = $result->fetch_assoc()) {
              $key++;
              echo "<tr>
            <th scope='row'>" . $key . "</th>
            <td>{$row['product_name']}</td>
            <td>{$row['price']}</td>
            <td class='container d-flex'>
            <div class='row mx-auto'>
             <div class='col'>
                <a onclick=\"return confirm('Voulez-vous supprimer cet élève ?')\" href=\"delete_product.php?id_p={$row['product_id']}\">
                    <svg xmlns='http://www.w3.org/2000/svg' width='25' height='25' fill='red' class='bi bi-trash ' viewBox='0 0 16 16'>
                        <path d='M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z'/>
                        <path fill-rule='evenodd' d='M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z'/>
                    </svg>
                </a>
                <a  href=\"update_product.php?id_p={$row['product_id']}\">
                    <svg xmlns='http://www.w3.org/2000/svg' width='25' height='25' fill='green' color='success' class='bi bi-pencil-square ms-5' viewBox='0 0 16 16'>
                      <path d='M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z'/>
                      <path fill-rule='evenodd' d='M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z'/>
                    </svg>
                </a>
                </div>
              </div>
            </td>
        </tr>";
            }
          } else {
            echo "<tr>
            <td colspan='6' class='text-center'> No Products</td>
           </tr>";
          }
          ?>

        </tbody>
      </table>
    </div>
  </div>
  <div class="container mt-5">
    <?php
    // Afficher le toast uniquement si le message n'est pas vide
    if (!empty($toastMessage)) {
      echo '<div class="toast-container position-static">
      <div class="toast" role="alert" aria-live="assertive" aria-atomic="true"  data-delay="3000">
        <div class="toast-header">
          <strong class="me-auto">Notification</strong>
          <small class="text-body-secondary">just now</small>
          <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
        ' . $toastMessage . '
        </div>
      </div>';
    }
    ?>
  </div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
  <script>
    // Afficher le toast après le chargement de la page
    $(document).ready(function() {
      $('.toast').toast('show');
    });
  </script>
</body>


</html>