<?php
session_start();
include('server/connection.php');

// Jezik iz cookie-a ili default
$lang = "rs";
if (isset($_GET['lang'])) {
  $lang = $_GET['lang'];
  setcookie("lang", $lang, time() + (86400 * 30), "/");
} elseif (isset($_COOKIE['lang'])) {
  $lang = $_COOKIE['lang'];
}

if (isset($_SESSION['logged_in'])) {
  if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    $stmt = $conn->prepare("
      SELECT p.*, 
             COALESCE(t.name, p.product_name) AS trans_name,
             COALESCE(t.description, p.product_description) AS trans_description,
             p.product_category AS trans_category
      FROM products p
      LEFT JOIN product_translations t 
        ON p.product_id = t.product_id AND t.lang = ?
      WHERE p.product_id = ?
    ");

    if (!$stmt) {
      die("SQL error: " . $conn->error);
    }

    $stmt->bind_param("si", $lang, $product_id);
    $stmt->execute();
    $product = $stmt->get_result();

  } else {
            header('Location: index.php');
    exit;
  }
} else {
            header('Location: login.php?error=You must login');
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Proizvod</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css"/>
  <link rel="stylesheet" href="assets/css/bootstrap.min.css"/>
  <link rel="stylesheet" href="assets/css/style.css"/>
  <style>
    .stock-green { color: green; font-weight: bold; }
    .stock-yellow { color: orange; font-weight: bold; }
    .stock-red { color: red; font-weight: bold; }
  </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<section class="single-product my-5 pt-5">
  <div class="row mt-5">
    <?php while ($row = $product->fetch_assoc()) { 
      $stockClass = '';
      $quantity = $row['quantity'];
      if ($quantity == 0) {
        $stockClass = 'stock-red';
      } else if ($quantity >= 1 && $quantity <= 5) {
        $stockClass = 'stock-yellow';
      } else {
        $stockClass = 'stock-green';
      }
    ?>
    <div class="col-lg-5 col-md-6 col-md-12">
      <img class="pb-1" src="assets/imgs/proizvod/<?php echo $row['product_image']; ?>" id="glavnaSlika"/>
      <div class="small-slika-group">
        <div class="small-slika-col">
          <img class="small-slika" src="assets/imgs/proizvod/<?php echo $row['product_image']; ?>"/>
        </div>
        <div class="small-slika-col">
          <img class="small-slika" onerror="this.style.display='none'" src="assets/imgs/proizvod/<?php echo $row['product_image2']; ?>"/>
        </div>
        <div class="small-slika-col">
          <img class="small-slika" onerror="this.style.display='none'" src="assets/imgs/proizvod/<?php echo $row['product_image3']; ?>"/>
        </div>
        <div class="small-slika-col">
          <img class="small-slika" onerror="this.style.display='none'" src="assets/imgs/proizvod/<?php echo $row['product_image4']; ?>"/>
        </div>
      </div>
    </div>

    <div class="col-lg-6 col-md-12 col-sm-12">
      <h6><?php echo $row['trans_category']; ?></h6>
      <h3 class="py-4"><?php echo $row['trans_name']; ?></h3>
      <h2><?php echo $row['product_price']; ?> din.</h2>
      <h5 class="<?php echo $stockClass; ?>"><?=$Language["available"]?> <?php echo $quantity; ?></h5>

      <form method="POST" action="cart.php">
        <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>"/>
        <input type="hidden" name="product_image" value="<?php echo $row['product_image']; ?>"/>
        <input type="hidden" name="product_name" value="<?php echo $row['trans_name']; ?>"/>
        <input type="hidden" name="product_price" value="<?php echo $row['product_price']; ?>"/>

        <label for="product_quantity"><?=$Language["quantity"]?>:</label>
        <input type="number" name="product_quantity" value="1" min="1" max="<?php echo $quantity; ?>" required class="form-control w-25 mb-3"/>

        <label for="product_type"><?=$Language["option"]?></label>
        <select name="product_type" class="form-select w-50 mb-3" id="product_type_select" required>
          <option value="buy"><?=$Language["buy"]?></option>
          <option value="rent"><?=$Language["rent"]?></option>
        </select>

<div id="rental_dates" style="display: none;">
  <label for="start_date">Datum početka:</label>
  <input type="date" 
         id="start_date"
         name="start_date" 
         class="form-control w-50 mb-3" 
         min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" 
         max="<?php echo date('Y-m-d', strtotime('+2 months')); ?>" 
         />

  <label for="end_date">Datum kraja:</label>
  <input type="date" 
         id="end_date"
         name="end_date" 
         class="form-control w-50 mb-3" 
         disabled 
         />
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="assets/js/datumi.js"></script>

        <button class="buy-btn" type="submit" name="addcart_btn" <?php if($quantity == 0) echo "disabled"; ?>><?=$Language["cartAdd"]?></button>
      </form>

      <h4 class="mt-5 mb-5"><?=$Language["productDetails"]?></h4>
      <span><?php echo $row['trans_description']; ?></span>
    </div>
    <?php } ?>
  </div>
</section>

<section id="featured" class="my-5 pb-5">
  <div class="container text-center mt-5 py-5">
    <h3><?=$Language["prdct"]?></h3>
    <hr>
    <p><?=$Language["prdct1"]?></p>
  </div>
  <div class="row mx-auto container-fluid">
    <?php include('server/get_featured_products.php'); ?>
    <?php while($row=$featured_products->fetch_assoc()) { ?>
      <div onclick="window.location.href='<?php echo "single.php?product_id=" . $row['product_id'];?>'" class="proizvod text-center col-lg-3 col-md-4 col-sm-12">
        <img class="img-fluid mb-3" src="assets/imgs/proizvod/<?php echo $row['product_image'];?>"/>
        <div class="Star">
          <i class="fa-solid fa-star"></i>
          <i class="fa-solid fa-star"></i>
          <i class="fa-solid fa-star"></i>
          <i class="fa-solid fa-star"></i>
          <i class="fa-solid fa-star"></i>
        </div>
        <h5 class="p-name"><?php echo $row['product_name'];?></h5>
        <h4 class="p-price"><?php echo $row['product_price'];?> din.</h4>
        <a href="<?php echo "single.php?product_id=" . $row['product_id'];?>"><button class="buy-btn">Buy now</button> </a>
      </div>
    <?php } ?>
  </div>
</section>

<?php include 'footer.html'; ?>
<script src="assets/js/slika.js"></script>
<script src="assets/js/prikazOpcija.js"></script>
</body>
</html>
