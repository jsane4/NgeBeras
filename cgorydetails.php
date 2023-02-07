<?php
require "session.php";
require "../koneksi.php";

$id = $_GET['erka'];
$queryid = mysqli_query($con, "SELECT * FROM category WHERE id='$id'");
$data = mysqli_fetch_array($queryid);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Details</title>
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
                    <a href="category.php" class="text-muted no-decoration">
                        Category
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Category Details
                    </a>
                </li>
            </ol>
        </nav>
        <div class="mt-5 col-12 col-md-5">
            <h3>Detail Category</h3>
            <form action="" method="post">
                <div>
                    <label for="category"></label>
                    <input type="text" id="category" name="category" class="form-control" value="<?php echo $data['cgory'] ?>">
                </div>
                <div class="mt-3 d-grid gap-2 d-md-flex justify-content-md-end">
                    <button class="btn btn-warning me-md-1" type="submit" name="blabla">Save</button>
                    <button class="btn btn-danger" type="submit" name="delbtn"><i class="fa-regular fa-trash-can"></i></button>

                </div>
            </form>
            <?php
            if (isset($_POST['blabla'])) {
                $category = htmlspecialchars($_POST['category']);

                if ($data['cgory'] == $category) {
            ?>
                    <meta http-equiv="refresh" content="0 ; url=category.php" />
                    <?php
                } else {
                    $query = mysqli_query($con, "SELECT * FROM category WHERE cgory='$category'");
                    $totaldata = mysqli_num_rows($query);

                    if ($totaldata > 0) {
                    ?>
                        <div class="alert alert-danger mt-3" role="alert">
                            Can't input same Categories
                        </div>
                        <?php
                    } else {
                        $querySave = mysqli_query($con, "UPDATE category SET cgory='$category' WHERE id='$id'");
                        if ($querySave) {
                        ?>
                            <div class="alert alert-primary mt-3" role="alert">
                                Your category was successfully added
                            </div>
                            <meta http-equiv="refresh" content="1 ;url=category.php" />
                    <?php
                        } else {
                            echo mysqli_error($con);
                        }
                    }
                }
            }
            if (isset($_POST['delbtn'])) {
                $datacheck = mysqli_query($con, "SELECT * FROM product WHERE cgoryid='$id'");
                $dataCount = mysqli_num_rows($datacheck);

                if ($dataCount > 0) {
                    ?>
                    <div class="alert alert-primary mt-3" role="alert">
                        the product existed, you cannot delete a category
                    </div>
                <?php
                    die();
                }
                $delquery = mysqli_query($con, "DELETE FROM category WHERE id='$id'");

                if ($delquery) {
                ?>
                    <div class="alert alert-primary mt-3" role="alert">
                        Category was delete
                    </div>
                    <meta http-equiv="refresh" content="1 ;url=category.php" />
            <?php
                } else {
                    echo mysqli_error($con);
                }
            }
            ?>
        </div>
    </div>

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>
</body>

</html>