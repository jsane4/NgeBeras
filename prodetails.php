<?php
require "session.php";
require "../koneksi.php";

$id = $_GET['erka'];
$queryid = mysqli_query($con, "SELECT a.*, b.cgory AS cgoryname FROM product a JOIN category b ON a.cgoryid=b.id WHERE a.id=$id");

$data = mysqli_fetch_array($queryid);
$queryCategory = mysqli_query($con, "SELECT * FROM category WHERE id!='$data[cgoryid]'");

function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/fontawesome.min.css">

</head>

<style>
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
                    <a href="../adminpanel" class="text-muted no-decoration">
                        <i class="fa-solid fa-house me-2"></i>Home
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <a href="product.php" class="text-muted no-decoration">
                        Product
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Product Details
                    </a>
                </li>
            </ol>
        </nav>
        <div class="mt-5 col-12 col-md-5">
            <h3>Detail Product</h3>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="mt-4">
                    <label for="namepro">Name of Product</label>
                    <input type="text" id="namepro" name="namepro" value="<?php echo $data['namepro'] ?>" class="form-control" autocomplete="off">
                </div>
                <div class="mt-3">
                    <label for="category">Category</label>
                    <select name="cgoryid" id="cgoryid" class="form-control">
                        <option value="<?php echo $data['cgoryid']; ?>"><?php echo $data['cgoryname']; ?></option>
                        <?php
                        while ($datacgory = mysqli_fetch_array($queryCategory)) {
                        ?>
                            <option value="<?php echo $datacgory['id']; ?>">
                                <?php echo $datacgory['cgory']; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="mt-2">
                    <label for="price">Price</label>
                    <input type="number" name="price" class="form-control" value="<?php echo $data['price']; ?>">
                </div>
                <div>
                    <label for="currentphoto">Image</label>
                    <img src="../images/<?php echo $data['pict'] ?>" alt="" width="500px">
                </div>
                <div class="mt-2">
                    <label for="pict">Image</label>
                    <input type="file" name="pict" id="pict" class="form-control">
                </div>
                <div class="mt-3">
                    <label for="detail" class="form-label">Detail</label>
                    <textarea class="form-control" id="detail" name="detail" rows="3">
                    <?php echo $data['detail'] ?>
                    </textarea>
                </div>
                <div class="mt-2">
                    <label for="qty">Quantity</label>
                    <select name="qty" id="qty" class="form-control">
                        <option value="<?php echo $data['qty'] ?>"><?php echo $data['qty'] ?></option>
                        <?php
                        if ($data['qty'] == 'available') {
                        ?>
                            <option value="out of stock">Out of Stock</option>
                        <?php
                        } else {
                        ?>
                            <option value="available">available</option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-5 mt-3 d-grid gap-2 d-md-flex justify-content-md-end">
                    <button class="btn btn-warning me-md-1" type="submit" name="update">Save</button>
                    <button class="btn btn-danger" type="submit" name="delbtn"><i class="fa-regular fa-trash-can"></i></button>
                </div>
            </form>
            <?php
            if (isset($_POST['update'])) {
                $product = htmlspecialchars($_POST['product']);
                $namepro = htmlspecialchars($_POST['namepro']);
                $cgoryid = htmlspecialchars($_POST['cgoryid']);
                $price = htmlspecialchars($_POST['price']);
                $detail = htmlspecialchars($_POST['detail']);
                $qty = htmlspecialchars($_POST['qty']);

                $target_dir = "../images/";
                $img_name = basename($_FILES["pict"]["name"]);
                $target_file = $target_dir . $img_name;
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                $img_size = $_FILES["pict"]["size"];
                $random_name = generateRandomString(25);
                $new_name = $random_name . "." . $imageFileType;

            ?>
                <div class="alert alert-danger mt-3" role="alert">
                    Fill all table
                </div>
                <?php

                if ($data['namepro'] == $product) {
                ?>
                    <meta http-equiv="refresh" content="0 ; url=product.php" />
                    <?php
                } else {
                    $query = mysqli_query($con, "SELECT * FROM product WHERE namepro='$product'");
                    $totaldata = mysqli_num_rows($query);

                    if ($totaldata > 0) {
                    ?>
                        <div class="alert alert-danger mt-3" role="alert">
                            Can't input same Categories
                        </div>
                        <?php
                    } else {
                        $queryUpdate = mysqli_query($con, "UPDATE product SET namepro='$namepro', cgoryid='$cgoryid', price='$price', detail='$detail', qty='$qty' WHERE id='$id' ");

                        if ($img_name !== '') {
                            if ($img_size > 500000) {
                        ?>
                                <div class="alert alert-info mt-3" role="alert">
                                    File upload max 500kb
                                </div>
                                <?php
                            } else {
                                if ($imageFileType != 'jpg' && $imageFileType != 'png' && $imageFileType != 'jpeg') {
                                ?>
                                    <div class="alert alert-info mt-3" role="alert">
                                        File must be .jpg or .png
                                    </div>
                                    <?php
                                } else {
                                    move_uploaded_file($_FILES["pict"]["tmp_name"], $target_dir . $new_name);

                                    $queryUpdate = mysqli_query($con, "UPDATE product SET pict='$new_name' WHERE id='$id'");

                                    if ($queryUpdate) {
                                    ?>
                                        <div class="alert alert-primary mt-3" role="alert">
                                            Your product was successfully update
                                        </div>
                                        <meta http-equiv="refresh" content="1 ;url=product.php" />
                        <?php
                                    } else {
                                        echo mysqli_error($con);
                                    }
                                }
                            }
                        }
                    }
                }
                if (isset($_POST['delbtn'])) {
                    $delquery = mysqli_query($con, "DELETE FROM product WHERE id='$id'");

                    if ($delquery) {
                        ?>
                        <div class="alert alert-primary mt-3" role="alert">
                            Category was delete
                        </div>
                        <meta http-equiv="refresh" content="1 ;url=product.php" />
            <?php
                    }
                }
            }
            ?>
        </div>
    </div>
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>
</body>

</html>