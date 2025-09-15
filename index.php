<?php 
session_start();

?>
<!DOCTYPE html>
<html lang="rs">
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


      <!-- HOME -->
       <section id="home">
        <div class="container">
          <h1><b><?=$Language["Welcome"]?></h1>
          <h1><span><b><?=$Language["bestprice"]?></b></span> <?=$Language["thisseason"]?></h1>
          <p><?=$Language["itez"]?></p>
          <a href="shop.php"> <button class="text-uppercase"><?=$Language["dKupi"]?></button></a>
        </div>
       </section>

       <!--BRENDOVI SLIKE-->
<hr>
       <section id="brand" class="container">
        <div class="row">
<!--col-lg-3 znaci da za vece ekrane vece od 992px jedna slika ce zauzimati 3 od 12 grid kolona-->
          <img class="img-fluid col-lg-3 col-md-6 col-sm-12 " src="assets/imgs/AtomicLogo-removebg-preview.png"/>
          <img class="img-fluid col-lg-3 col-md-6 col-sm-12 " src="assets/imgs/fischerLogo_resized.png"/>
          <img class="img-fluid col-lg-3 col-md-6 col-sm-12 " src="assets/imgs/nordicaLogo.jpg"/>
          <img class="img-fluid col-lg-3 col-md-6 col-sm-12 " src="assets/imgs/headLogo.png"/>
          
        </div>
       </section>
<hr>
       <!--SHOPOVI sa bootstrap klasama za size kolone-->
       <section id="novo" class="width-100">
        <div class="row p-0 m-0">
          <div class="slike col-lg-4 col-md-12 col-sm-12 p-0">
            <img class="img-fluid" src="assets/imgs/skijeDonje.jpg">
            <div class="details">
              <h2><B><?=$Language["ski"]?></B></h2>
              <a href="shop.php"> <button class="text-uppercase"><?=$Language["dKupi"]?></button></a>
            </div>
          </div>
          <div class="slike col-lg-4 col-md-12 col-sm-12 p-0">
            <img class="img-fluid" src="assets/imgs/pancericeDonje.jpg"/>
            <div class="details">
              <h2><B><?=$Language["boots"]?></B></h2>
              <a href="shop.php"> <button class="text-uppercase"><?=$Language["dKupi"]?></button></a>
            </div>
          </div>
          <div class="slike col-lg-4 col-md-12 col-sm-12 p-0">
            <img class="img-fluid" src="assets/imgs/odelaDonje.jpg"/>
            <div class="details">
              <h2><b><?=$Language["gear"]?></b></h2>
              <a href="shop.php"> <button class="text-uppercase"><?=$Language["dKupi"]?></button></a>
            </div>
          </div>
        </div>
       </section>

       <!--Featured stvari-->

       <section id="featured" class="my-5 pb-5">
        <!--Container ima predefinisane padding levo i desno da stvari ne doticu krajeve strane,mt je margin top i py je padding po y osi-->
        <div class="container text-center mt-5 py-5">
          <h3><?=$Language["prdct"]?></h3>
          <hr>
          <p><?=$Language["prdct1"]?></p>
        </div>
        <!--fluid stavlja stvari kako treba-->
        <div class="row mx-auto container-fluid">
        <!--PHP KOD KOJI PROLAZI KROZ BAZU I UZIMA PRVA 4 PROIZVODA-->
        <?php include('server/get_featured_products.php');?>

        <?php while($row=$featured_products->fetch_assoc()){?>
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
          <a href="<?php echo "single.php?product_id=" . $row['product_id'];?>"><button class="buy-btn"><?=$Language["dKupi"]?></button> </a>
          </div>
          <?php }?>

        </div>
</section>
        <!--Baner-->
        <section id="banner" class="my-5 py-5">
          <div class="container">
            <h4><b><?=$Language["meet"]?>!</b></h4>
            <h1><b><?=$Language["look"]?>!</b></h1>
            <a href="blog.php"><button class="text-uppercase"><?=$Language["read"]?></button></a>
          </div>
        </section>
        <!--Footer-->
       </section>
       <hr>
       <?php include 'footer.html';?>


</body>
</html>