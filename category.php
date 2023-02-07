<?php
require "session.php";
require "../koneksi.php";

$queryCategory = mysqli_query($con, "SELECT * FROM category");
$Categorytotal = mysqli_num_rows($queryCategory);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category</title>
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
                    Category
                </li>
            </ol>
        </nav>
        <div class="mt-3">
            <h2><i class="fa-solid fa-bars me-2"></i> List Categories</h2>
            <div class="table-responsive mt-5">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Name of Product</th>
                            <th scope="col">Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($Categorytotal == 0) {
                        ?>
                            <tr>
                                <td colspan=3 class="text-center"> Unavailable </td>
                            </tr>
                            <?php
                        } else {
                            $total = 1;
                            while ($data = mysqli_fetch_array($queryCategory)) {
                            ?>
                                <tr>
                                    <td><?php echo $total; ?></td>
                                    <td><?php echo $data['cgory']; ?></td>
                                    <td>
                                        <a href="cgorydetails.php?erka=<?php echo $data['id']; ?>" class="btn btn-success"><i class="fa-solid fa-magnifying-glass"></i>
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
        <div class="ms-auto my-3 col-6 col-md-3">
            <h5>Add Categories Here</h5>
            <form action="" method="post">
                <div>
                    <label for="category"></label>
                    <input type="text" id="category" name="category" placeholder="New category" class="form-control">
                </div>
                <div class="mt-3 mb-5">
                    <button class="btn btn-warning form-control" type="submit" name="save_categories">Add</button>
                </div>
            </form>
            <?php
            if (isset($_POST['save_categories'])) {
                $category = htmlspecialchars($_POST['category']);

                $queryExist = mysqli_query($con, "SELECT * FROM category WHERE cgory='$category'");
                $totalnewcategory = mysqli_num_rows($queryExist);

                if ($totalnewcategory > 0) {
            ?>
                    <div class="alert alert-danger mt-3" role="alert">
                        Please! Input Other Categories
                    </div>
                    <?php
                } else {
                    $querySave = mysqli_query($con, "INSERT INTO category (cgory) VALUES ('$category')");
                    if ($querySave) {
                    ?>
                        <div class="alert alert-warning mt-3" role="alert">
                            Your category was added
                        </div>
                        <meta http-equiv="refresh" content="0" ; url="category.php" />
                    <?php
                    } else {
                        echo mysqli_error($con);
                    }
                    ?>
            <?php
                }
            }
            ?>
        </div>
        <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../fontawesome/js/all.min.js"></script>
    </div>
</body>

</html>