<?php
require "session.php";
require "../koneksi.php";

$queryCategory = mysqli_query($con, "SELECT * FROM category");
$Categorytotal = mysqli_num_rows($queryCategory);

$queryProduct = mysqli_query($con, "SELECT * FROM product");
$Producttotal = mysqli_num_rows($queryProduct);

$querySettings = mysqli_query($con, "SELECT * FROM users");
$Settingstotal = mysqli_num_rows($querySettings);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beras Nusantara</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/fontawesome.min.css">
</head>

<style>
    .box {
        border: solid;
    }

    .summary-category {
        background-color: #Ee9119;
        border-radius: 15px;
    }

    .summary-product {
        background-color: #d68317;
        border-radius: 15px;
    }

    .summary-settings {
        background-color: #a76612;
        border-radius: 15px;
    }

    .no-decoration {
        text-decoration: none;
    }
</style>

<body>
    <?php require "navbar.php"; ?>
    <div class="container mt-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                    <i class="fa-solid fa-house me-2"></i>Home
                </li>
            </ol>
        </nav>
        <h2>Welcome Septia!</h2>

        <div class="container mt-5">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-12 mb-4">
                    <a href="category.php" class="text-dark no-decoration">
                        <div class="summary-category p-3">
                            <div class="row">
                                <div class="col-6">
                                    <i class="fa-solid fa-bars fa-7x m-center text-black-50"></i>
                                </div>
                                <div class="col-6 text-black-70">
                                    <h3 class="fs-2">Category</h3>
                                    <p class="fs-4"><?php echo $Categorytotal; ?> Categories </p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6 col-12 mb-4">
                    <a href="product.php" class="text-dark no-decoration">
                        <div class="summary-product p-3">
                            <div class="row">
                                <div class="col-6">
                                    <i class="fa-solid fa-plate-wheat fa-7x m-center text-black-50"></i>
                                </div>
                                <div class="col-6 text-black-70">
                                    <h3 class="fs-2">Product</h3>
                                    <p class="fs-4"><?php echo $Producttotal; ?> Products</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-lg-4 col-md-6 col-12 mb-4">
                    <a href="account.php" class="text-dark no-decoration">
                        <div class="summary-settings p-3">
                            <div class="row">
                                <div class="col-6">
                                    <i class="fa-solid fa-users-gear fa-7x m-center text-black-50"></i>
                                </div>
                                <div class="col-6 text-black-70">
                                    <h3 class="fs-2">Settings</h3>
                                    <p class="fs-4"><?php echo $Settingstotal; ?> Account</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>
</body>

</html>