<?php
require "session.php";
require "../koneksi.php";

$queryproduct = mysqli_query($con, "SELECT a.*, b.cgory AS cgoryname FROM product a JOIN category b ON a.cgoryid=b.id");
$producttotal = mysqli_num_rows($queryproduct);

$queryCategory = mysqli_query($con, "SELECT * FROM category");
$Categorytotal = mysqli_num_rows($queryCategory);

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
    <title>Product</title>
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
                    Product
                </li>
            </ol>
        </nav>
        <div class="container mt-3">
            <div class="row">
                <div class="mt-4 my-3 col-6 col-md-3">
                    <h5>Add Products Here</h5>
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="mt-4">
                            <label for="namepro">Name of Product</label>
                            <input type="text" id="namepro" name="namepro" class="form-control" autocomplete="off">
                        </div>
                        <div class="mt-3">
                            <label for="category">Category</label>
                            <select name="cgoryid" id="cgoryid" class="form-control">
                                <option value=""></option>
                                <?php
                                while ($data = mysqli_fetch_array($queryCategory)) {
                                ?>
                                    <option value="<?php echo $data['id']; ?>">
                                        <?php echo $data['cgory']; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mt-2">
                            <label for="price">Price</label>
                            <input type="number" name="price" class="form-control">
                        </div>
                        <div class="mt-2">
                            <label for="pict">Image</label>
                            <input type="file" name="pict" id="pict" class="form-control">
                        </div>
                        <div class="mt-3">
                            <label for="detail" class="form-label">Detail</label>
                            <textarea class="form-control" id="detail" name="detail" rows="3"></textarea>
                        </div>
                        <div class="mt-2">
                            <label for="qty">Quantity</label>
                            <select name="qty" id="qty" class="form-control">
                                <option value="available">Available</option>
                                <option value="out of stock">Out of Stock</option>
                                <?php
                                while ($data = mysqli_fetch_array($queryCategory)) {
                                ?>
                                    <option value="<?php echo $data['id']; ?>">
                                        <?php echo $data['cgory']; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-warning form-control" name="save">Save</button>
                        </div>
                    </form>
                    <?php
                    if (isset($_POST['save'])) {
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

                        if ($namepro == '' || $cgoryid == '' || $price == '') {
                    ?>
                            <div class="alert alert-danger mt-3" role="alert">
                                Fill all table
                            </div>
                            <?php
                        } else {
                            if ($img_name != '') {
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
                                    }
                                }
                            }

                            $queryadd = mysqli_query($con, "INSERT INTO product (namepro, cgoryid, price, pict, detail, qty) VALUES ('$namepro', '$cgoryid', '$price', '$new_name', '$detail', '$qty')");

                            if ($queryadd) {
                                ?>
                                <div class="alert alert-primary mt-3" role="alert">
                                    Product was saved
                                </div>
                                <meta http-equiv="refresh" content="0; url=product.php" />
                    <?php
                            } else {
                                echo mysqli_error($con);
                            }
                        }
                    }
                    ?>
                </div>
                <div class="mx-3 mt-3 my-3 col-sm-8 col-md-end">
                    <h2><i class="fa-solid fa-plate-wheat me-2"></i> List Products</h2>
                    <div class="table-responsive mt-3">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">Qty</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($producttotal == 0) {
                                ?>
                                    <tr>
                                        <td colspan=7 class="text-center"> Unavailable </td>
                                    </tr>
                                    <?php
                                } else {
                                    $total = 1;
                                    while ($data = mysqli_fetch_array($queryproduct)) {
                                    ?>
                                        <tr>
                                            <td><?php echo $total; ?></td>
                                            <td><?php echo $data['namepro']; ?></td>
                                            <td><?php echo $data['cgoryname']; ?></td>
                                            <td><?php echo $data['price']; ?></td>
                                            <td><?php echo $data['pict']; ?></td>
                                            <td><?php echo $data['qty']; ?></td>
                                            <td>
                                                <a href="prodetails.php?erka=<?php echo $data['id']; ?>" class="btn btn-success"><i class="fa-solid fa-magnifying-glass"></i>
                                                </a>
                                            </td>
                                        </tr>
                                <?php
                                        $total++;
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>
</body>

</html>