<?php include 'php/admin_product_edit_logic.php';?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="assets/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="assets/css/style.css"/>
</head>
<body>
<?php include 'adminsidebar.html';?>
<div class="container mt-5">
    <h2>Edit Product</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="product_name" class="form-label">Ime proizvoda</label>
            <input type="text" class="form-control" id="product_name" name="product_name" value="<?php echo $product['product_name']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="product_description" class="form-label">Deskripcija proizvoda</label>
            <textarea class="form-control" id="product_description" name="product_description" required><?php echo $product['product_description']; ?></textarea>
        </div>
        <div class="mb-3">
            <label for="product_price" class="form-label">Cena proizvoda</label>
            <input type="number" step="0.01" class="form-control" id="product_price" name="product_price" value="<?php echo $product['product_price']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="product_color" class="form-label">Boja proizovda</label>
            <input type="text" class="form-control" id="product_color" name="product_color" value="<?php echo $product['product_color']; ?>">
        </div>
        <div class="mb-3">
            <label for="product_image" class="form-label">Glavna slika proizvoda</label>
            <input type="file" class="form-control" id="product_image" name="product_image"><span>Trenutna slika: <b><?php echo $product['product_image']; ?></b></span>
        </div>
        <div class="mb-3">
            <label for="product_image2" class="form-label">Dodatna slika proizvoda 1</label>
            <input type="file" class="form-control" id="product_image2" name="product_image2"><span>Trenutna slika: <b><?php echo $product['product_image2']; ?></b></span>
            
        </div>
        <div class="mb-3">
            <label for="product_image3" class="form-label">PDodatna slika proizvoda 2</label>
            <input type="file" class="form-control" id="product_image3" name="product_image3"><span>Trenutna slika: <b><?php echo $product['product_image3']; ?></b></span>
        </div>
        <div class="mb-3">
            <label for="product_image4" class="form-label">Dodatna slika proizvoda 3</label>
            <input type="file" class="form-control" id="product_image4" name="product_image4"><span>Trenutna slika: <b><?php echo $product['product_image4']; ?></b></span>
        </div>
        <button type="submit" class='btn_update' class="btn btn-primary" name="update_product">Update</button>
        <a href="adminProducts.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>
