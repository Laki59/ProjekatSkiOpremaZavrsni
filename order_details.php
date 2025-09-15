<?php include 'php/order_details_logic.php';?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="assets/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="assets/css/style.css"/>
</head>
<body>
<?php include 'navbar.php';?>


<section class="proizvod container my-5 py-5">
        <div class="container mt-5">
            <h2 class="font-weight-bold text-center">Detalji o porudzbini broj: <?php echo $order_id?></h2>
            <hr>
        </div>
        <table class="mt-5 pt-5">
            <tr>
            <th>ID porudzbine</th>
                <th>Ime stvari</th>
                <th>Broj stvari</th>
                <th>Tip porudzbine</th>
                <th>Pocetak</th>
                <th>Kraj</th>
            </tr>
            <?php while($row=$proizvod_detalji->fetch_assoc()){?>
            <tr>
                <td>
                <span><?php echo $row['order_id'];?></span>
            </td>
                <td>
                    <div class="proizvod-info">
                        <img src="assets/imgs/proizvod/<?php echo $row['product_image'];?>"/>
                        <div>
                            <p class="mt-3"><?php echo $row['product_name'];?></p>
                        </div>
                    </div>
                <td>
                    <span><?php echo $row['product_quantity'];?></span>
                </td>
<td>
                    <span><?php echo $row['rent_type'];?></span>
                </td>
                <td>
                    <span><?php echo $row['start_date'];?></span>
                </td>
                                <td>
                    <span><?php echo $row['end_date'];?></span>
                </td>
            </tr>
            <?php }?>
        </table>
      </section>

<?php include 'footer.html';?>
</body>
</html>