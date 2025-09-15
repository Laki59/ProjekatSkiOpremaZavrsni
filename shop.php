<?php include 'php/shop_logic.php';?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Shop</title>


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" 
          integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" 
          crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/style.css" />



</head>
<body>

<?php include 'navbar.php'; ?>

<section id="trazi" class="py-5 bg-light">
    <div class="container">
        <h3 class="mb-3"><?=$Language["find"]?>!</h3>
        <hr />

        <form method="POST" action="shop.php">
            <div class="row">
                <div class="col-md-6">
                    <p class="fw-semibold"><?=$Language["cate"]?></p>

                    <?php
                    $categories = [
                        ['Pancerice', 'boots'],
                        ['Skije', 'ski'],
                        ['Rukavice', 'gloves'],
                        ['Kaciga', 'helmet'],
                        ['Aktivni ves', 'underclothes'],
                        ['Stapovi', 'sticks'],
                        ['Fantomka', 'mask'],
                        ['Vezovi', 'bindings'],
                        ['Naocare', 'googles']
                    ];
                    $i = 1;
                    foreach ($categories as $cat):
                        $value = $cat[0];
                        $label = $Language[$cat[1]];
                        $id = "kategorija_" . $i;
                        $checked = "";
                        
                        if ($search_mode && $kategorija === $value) {
                            $checked = "checked";
                        } elseif (!$search_mode && $i === 1) {
                            $checked = "checked"; 
                        }
                    ?>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="kategorija" id="<?=$id?>" value="<?=$value?>" <?=$checked?>>
                        <label class="form-check-label" for="<?=$id?>"><?=$label?></label>
                    </div>
                    <?php
                        $i++;
                    endforeach;
                    ?>
                </div>

                <div class="col-md-6">
                    <p class="fw-semibold"><?=$Language["price"]?></p>
                    <input type="range" name="cena_trazi" class="form-range" min="1" max="9999" id="cenaRange" oninput="updatePrice(this.value)" 
                        value="<?= ($search_mode && $price !== null) ? $price : 5000 ?>" />
                    <div class="d-flex justify-content-between">
                        <span>1</span>
                        <span id="cenaValue"><?= ($search_mode && $price !== null) ? $price : 5000 ?></span>
                        <span>9999</span>
                    </div>
                </div>
            </div>

<div class="mt-4 text-end">
    <button type="submit" name="search" class="btn btn-primary px-4"><?=$Language["search"]?></button>
    <a href="shop.php" class="btn btn-secondary ms-2"><?=$Language["show"]?></a>
</div>

            
        </form>
    </div>
</section>

<!-- Featured products -->
<section id="featured-shop" class="my-5 py-5">
    <div class="container">
        <h3><?=$Language["prdct"]?></h3>
        <hr />
        <p><?=$Language["prdct1"]?></p>

    <div class="row">
      <?php while ($row = $stvari->fetch_assoc()): ?>
        <div onclick="window.location.href='single.php?product_id=<?=$row['product_id']?>'" class="shopproizvod col-lg-3 col-md-4 col-sm-6">
          <img src="assets/imgs/proizvod/<?=$row['product_image']?>" alt="<?=htmlspecialchars($row['trans_name'])?>" class="img-fluid" />
          <div class="Star">
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
          </div>
          <h5 class="p-name"><?=htmlspecialchars($row['trans_name'])?></h5>
          <h4 class="p-price"><?=number_format($row['product_price'], 0, '', ' ')?> din.</h4>
          <a href="single.php?product_id=<?=$row['product_id']?>" class="btn buy-btn"><?=$Language["dKupi"]?></a>
        </div>
      <?php endwhile; ?>
    </div>

        <!-- Pagination -->
        <nav aria-label="Page navigation" class="mt-4">
            <ul class="pagination justify-content-center">

                <!-- Previous -->
                <li class="page-item <?= ($page_no <= 1) ? 'disabled' : '' ?>">
                    <?php if ($page_no > 1): ?>
                        <a class="page-link" href="?page_no=<?= $page_no - 1 ?><?= $search_mode ? "&kategorija=" . urlencode($kategorija) . "&cena_trazi=" . $price : "" ?>">Previous</a>
                    <?php else: ?>
                        <span class="page-link">Previous</span>
                    <?php endif; ?>
                </li>

                <!-- Page numbers -->
                <?php 
                $start_page = max(1, $page_no - 2);
                $end_page = min($total_no_of_pages, $page_no + 2);

                if ($start_page > 1) {
                    echo '<li class="page-item"><a class="page-link" href="?page_no=1'. ($search_mode ? "&kategorija=" . urlencode($kategorija) . "&cena_trazi=" . $price : "") .'">1</a></li>';
                    if ($start_page > 2) {
                        echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                    }
                }

                for ($i = $start_page; $i <= $end_page; $i++) {
                    $active = ($page_no == $i) ? "active" : "";
                    echo '<li class="page-item '.$active.'"><a class="page-link" href="?page_no='.$i. ($search_mode ? "&kategorija=" . urlencode($kategorija) . "&cena_trazi=" . $price : "") .'">'.$i.'</a></li>';
                }

                if ($end_page < $total_no_of_pages) {
                    if ($end_page < $total_no_of_pages - 1) {
                        echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                    }
                    echo '<li class="page-item"><a class="page-link" href="?page_no='.$total_no_of_pages. ($search_mode ? "&kategorija=" . urlencode($kategorija) . "&cena_trazi=" . $price : "") .'">'.$total_no_of_pages.'</a></li>';
                }
                ?>

                <!-- Next -->
                <li class="page-item <?= ($page_no >= $total_no_of_pages) ? 'disabled' : '' ?>">
                    <?php if ($page_no < $total_no_of_pages): ?>
                        <a class="page-link" href="?page_no=<?= $page_no + 1 ?><?= $search_mode ? "&kategorija=" . urlencode($kategorija) . "&cena_trazi=" . $price : "" ?>">Next</a>
                    <?php else: ?>
                        <span class="page-link">Next</span>
                    <?php endif; ?>
                </li>

            </ul>
        </nav>
    </div>
</section>

<?php include 'footer.html'; ?>

<script src="assets/js/slider.js"></script>
</section>
<script src="assets/js/showPrice.js">
</script>

</body>
</html>
