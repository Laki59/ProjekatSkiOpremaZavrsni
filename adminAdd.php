<?php include 'php/admin_add_logic.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dodaj proizvod</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" crossorigin="anonymous"/>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="assets/css/style.css"/>

    <style>
        input.form-control, textarea.form-control {
            border-radius: 0;
        }
    </style>
</head>
<body>
    <?php include 'adminsidebar.html'; ?>

    <div class="container col-lg-12 col-md-12 col-sm-12 mt-5">
        <h1 class="mb-4">Dodaj novu stvar</h1>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Ime proizvoda</label>
                <input type="text" class="form-control" name="product_name" required>
            
            </div>
            <div class="mb-3">
    <label class="form-label">Ime proizvoda (EN)</label>
    <input type="text" class="form-control" name="product_name_en">
</div>

<div class="mb-3">
    <label class="form-label">Deskripcija proizvoda (EN)</label>
    <textarea class="form-control" name="product_description_en" rows="3"></textarea>
</div>


            <div class="mb-3">
                <label class="form-label">Deskripcija proizvoda</label>
                <textarea class="form-control" name="product_description" rows="3" required></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Cena proizvoda</label>
                <input type="text" step="0.01" class="form-control" name="product_price" required>
            </div>


            <div class="mb-3">
                <label class="form-label">Boja proizvoda</label>
                <input type="text" class="form-control" name="product_color" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Kategorija proizvoda</label>
                <input type="text" class="form-control" name="product_category" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Glavna slika proizvoda</label>
                <input type="file" class="form-control" name="product_image" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Dodatna slika proizvoda 1</label>
                <input type="file" class="form-control" name="product_image2">
            </div>

            <div class="mb-3">
                <label class="form-label">Dodatna slika proizvoda 2</label>
                <input type="file" class="form-control" name="product_image3">
            </div>

            <div class="mb-3">
                <label class="form-label">Dodatna slika proizvoda 3</label>
                <input type="file" class="form-control" name="product_image4">
            </div>

            <button type="submit" class="btn btn-primary">Dodaj proizvod</button>
        </form>
    </div>
</body>
</html>
