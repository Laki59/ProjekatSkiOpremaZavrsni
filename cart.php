<?php
include 'php/cart_logic.php';
include('server/connection.php');

// Jezik iz cookie ili GET
$lang = "rs";
if (isset($_GET['lang'])) {
  $lang = $_GET['lang'];
  setcookie("lang", $lang, time() + (86400 * 30), "/");
} elseif (isset($_COOKIE['lang'])) {
  $lang = $_COOKIE['lang'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Korpa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" crossorigin="anonymous" />
    <link rel="stylesheet" href="assets/css/style.css"/>
</head>
<body>

<?php include 'navbar.php'; ?>

<section class="kolica container my-5 py-5">
    <p style="color:red"><?php if (isset($_GET['error'])) { echo $_GET['error']; } ?></p>

    <div class="container mt-5">
        <h2 class="font-weight-bold"><?=$Language["cartTxt"]?></h2>
        <hr>
    </div>

    <table class="mt-5 pt-5">
        <tr>
            <th><?=$Language["item"]?></th>
            <th><?=$Language["quantity"]?></th>
            <th><?=$Language["price"]?></th>
        </tr>

        <?php if (!empty($_SESSION['cart'])) { ?>
            <?php foreach($_SESSION['cart'] as $key => $value) { 
                // Uzimamo prevod imena proizvoda
                $stmt = $conn->prepare("
                    SELECT COALESCE(t.name, p.product_name) AS trans_name
                    FROM products p
                    LEFT JOIN product_translations t 
                      ON p.product_id = t.product_id AND t.lang = ?
                    WHERE p.product_id = ?
                ");
                $stmt->bind_param("si", $lang, $value['product_id']);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                $translated_name = $row ? $row['trans_name'] : $value['product_name'];
                $stmt->close();
            ?>
                <tr>
                    <td>
                        <div class="info d-flex align-items-center gap-3">
                            <img src="assets/imgs/proizvod/<?php echo $value['product_image']; ?>" width="80" height="80" />
                            <div>
                                <p><strong><?php echo htmlspecialchars($translated_name); ?></strong></p>
                                <small><?php echo $value['product_price']; ?> din.</small><br>
                                <small style="color:blue">
                                    <?php echo ($value['product_type'] == 'rent') ? 'Iznajmljeno (10% po danu)' : 'Kupljeno'; ?>
                                </small><br>
                                <?php if ($value['product_type'] == 'rent') { ?>
                                    <small>Od: <?php echo $value['start_date']; ?> Do: <?php echo $value['end_date']; ?></small><br>
                                <?php } ?>
                                <form method="POST" action="cart.php">
                                    <input type="hidden" name="product_id" value="<?php echo $value['product_id']; ?>" />
                                    <input type="submit" name="remove_btn" class="remove-btn btn btn-sm btn-outline-danger mt-1" value="Ukloni" />
                                </form>
                            </div>
                        </div>
                    </td>
                    <td>
                        <input type="number" name="product_quantity" readonly value="<?php echo $value['product_quantity']; ?>">
                    </td>
                    <td>
                        <span class="proizvod">
                            <?php
                                if ($value['product_type'] == 'rent') {
                                    $days = calculateDays($value['start_date'], $value['end_date']);
                                    $itemTotal = $value['product_price'] * 0.1 * $days * $value['product_quantity'];
                                } else {
                                    $itemTotal = $value['product_price'] * $value['product_quantity'];
                                }
                                echo round($itemTotal, 2) . " din.";
                            ?>
                        </span>
                    </td>
                </tr>
            <?php } ?>
        <?php } else { ?>
    <tr>
        <td colspan="3">
            <div class="alert alert-info text-center">
                <?=$Language["cart"]?>
                <a href="shop.php" class="btn btn-sm btn-primary ms-2"><?=$Language["cartB"]?></a>
            </div>
        </td>
    </tr>
        <?php } ?>
    </table>

    <div class="kolica-total mt-4">
        <table>
            <tr>
                <td><strong><?=$Language["priceCart"]?></strong></td>
                <td><strong><?php echo isset($_SESSION['total']) ? round($_SESSION['total'], 2) . ' din.' : '0 din.'; ?></strong></td>
            </tr>
        </table>
    </div>

    <div class="kupi-kontejner mt-4">
        <?php if (!empty($_SESSION['cart'])) { ?>
        <form method="POST" action="checkout.php">
            <input type="submit" class="kupi-btn btn btn-primary" value="<?=$Language["dKupi"]?>" name="checkout">
        </form>
        <?php } ?>
    </div>
</section>

<?php include 'footer.html'; ?>

</body>
</html>
