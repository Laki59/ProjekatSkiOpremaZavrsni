<?php include 'php/checkout_logic.php';?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Checkout</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="assets/css/bootstrap.min.css"/>
  <link rel="stylesheet" href="assets/css/style.css"/>
</head>
<body>
<?php include 'navbar.php'; ?>

<section class="my-5 py-5">
  <div class="container text-center mt-3 pt-5">
    <h2 class="form-weight-bold">Checkout</h2>
    <hr class="mx-auto">
  </div>

  <div class="mx-auto container text-center">
    <form id="checkout-forma" method="POST" action="php/place_order.php">
      <div class="form-groupa text-center checkout-element">
        <label>Ime</label><br>
        <input type="text" class="forma-kontrole" name="ime" value="<?php echo $_SESSION['user_name']; ?>" required/>
      </div>
      <div class="form-groupa text-center checkout-element">
        <label>Email</label><br>
        <input type="text" class="forma-kontrole" name="email" value="<?php echo $_SESSION['user_email']; ?>" required/>
      </div>
<div class="form-groupa text-center checkout-element">
  <label>Broj telefona</label><br>
  <input type="text" class="forma-kontrole" name="broj"
         pattern="^[0-9]{7,15}$"
         title="Unesite samo brojeve (7–15 cifara)"
         required/>
</div>

<div class="form-groupa text-center checkout-element">
  <label>Grad</label><br>
  <input type="text" class="forma-kontrole" name="grad"
         pattern="^[A-Za-zČĆŽŠĐčćžšđ\s]{2,20}$"
         title="Unesite samo slova (2–20 karaktera)"
         required/>
</div>

<div class="form-groupa text-center checkout-element">
  <label>Adresa</label><br>
  <input type="text" class="forma-kontrole" name="adresa"
         pattern="^[A-Za-zČĆŽŠĐčćžšđ0-9\s]{5,20}$"
         title="Unesite samo slova i brojeve (5–20 karaktera)"
         required/>
</div>


  
      <div class="form-groupa text-center checkout-btn-container">
        <br>
        <input type="submit" class="btn" id="btn-checkout" name="place_order_btn" value="Kupi sada"/>
        <p>Ukupna cena: <?php echo $_SESSION['total']; ?> din.</p>
      </div>
    </form>
  </div>
</section>

<?php include 'footer.html'; ?>
</body>
</html>
