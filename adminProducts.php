<?php include 'php/admin_product_logic.php';?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Products</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" crossorigin="anonymous" />
    <link rel="stylesheet" href="assets/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="assets/css/style.css"/>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin-top: 30px;
        }
        .add-product-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
        }
    </style>
</head>
<body>
<?php include 'adminsidebar.html';?>

    <div id="content">
        <div class="container-fluid">
            <h1 class="mt-4">Svi proizvodi</h1>
            <?php if (isset($_SESSION['message'])): ?>
    <div class="alert alert-info">
        <?php 
            echo $_SESSION['message']; 
            unset($_SESSION['message']); 
        ?>
    </div>
<?php endif; ?>

            <p>U našoj bazi podataka</p>

            <!-- 🔍 Search bar -->
            <form method="GET" action="adminProducts.php" class="mb-3 d-flex" style="max-width:400px;">
                <input type="number" name="search" class="form-control me-2" placeholder="Pretraži po ID-u" value="<?php echo htmlspecialchars($search); ?>">
                <button type="submit" class="btn btn-primary">Pretraži</button>
            </form>

            <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID proizvoda</th>
                                    <th>Ime proizvoda</th>
                                    <th>Kategorija proizvoda</th>
                                    <th>Proizvod velika slika</th>
                                    <th>Proizvod cena</th>
                                    <th>Proizvod boja</th>
                                    <th>Količina</th>
                                    <th>Brisi</th>
                                    <th>Edit</th>
                                </tr>
                            </thead>
                            <tbody>
    <?php while ($row = $all_products->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['product_id']; ?></td>
            <td><?php echo $row['product_name']; ?></td>
            <td><?php echo $row['product_category']; ?></td>
            <td><?php echo $row['product_image']; ?></td>
            <td><?php echo $row['product_price']; ?></td>
            <td><?php echo $row['product_color']; ?></td>
<td>
    <form method="POST" action="adminProducts.php" class="d-flex">
        <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
        <input type="number" name="new_quantity" 
               value="<?php echo $row['quantity']; ?>" 
               min="0" class="form-control form-control-sm me-2" style="width:80px;">
        <button type="submit" name="update_quantity" class="btn btn-sm btn-warning">
            Update
        </button>
    </form>
</td>

            <td>
                <form method="POST" action="adminProducts.php" style="display:inline;">
                    <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
                    <input type="submit" value="Brisi" name="delete_btn_order" class="btn btn-danger btn-sm">
                </form>
            </td>
            <td>
                <a href="adminProductEdit.php?product_id=<?php echo $row['product_id']; ?>" class="btn btn-primary btn-sm">Edit</a>
            </td>
        </tr>
    <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Add Product Button -->
        <a href="adminAdd.php" class="btn btn-success btn-lg add-product-btn">
            <i class="fa fa-plus"></i> Add Product
        </a>
    </div>

</body>
</html>
