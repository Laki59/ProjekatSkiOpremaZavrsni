<?php
include(__DIR__ . '/../server/connection.php');
session_start();

//Uzimamo jezik iz GET ili cookie (default rs)
$lang = "rs";
if (isset($_GET['lang'])) {
  $lang = $_GET['lang'];
  setcookie("lang", $lang, time() + (86400 * 30), "/");
} elseif (isset($_COOKIE['lang'])) {
  $lang = $_COOKIE['lang'];
}

//Koliko proizvoda po strani
$total_records_per_page = 8; 

$page_no = 1;
$search_mode = false;
$kategorija = null;
$price = null;

//Ako je poslata pretraga
if (isset($_POST['search'])) {
    $search_mode = true;
    $kategorija = $_POST['kategorija'];
    $price = (int)$_POST['cena_trazi'];

    //Brojimo koliko ima proizvoda u filteru
    $stmt_count = $conn->prepare("SELECT COUNT(*) FROM products WHERE product_category=? AND product_price<=?");
    $stmt_count->bind_param("si", $kategorija, $price);
    $stmt_count->execute();
    $stmt_count->bind_result($total_records);
    $stmt_count->fetch();
    $stmt_count->close();

    $total_no_of_pages = ($total_records > 0) ? ceil($total_records / $total_records_per_page) : 1;

    //Kada se trazi vraca se na prvu stranu
    $page_no = 1; 
    $offset = 0;

    //Uzimamo proizvode sa prevodima
    $stmt = $conn->prepare("
      SELECT p.*, 
             COALESCE(t.name, p.product_name) AS trans_name
      FROM products p
      LEFT JOIN product_translations t 
        ON p.product_id = t.product_id AND t.lang = ?
      WHERE p.product_category=? AND p.product_price<=?
      LIMIT ?, ?
    ");
    $stmt->bind_param("ssiii", $lang, $kategorija, $price, $offset, $total_records_per_page);
    $stmt->execute();
    $stvari = $stmt->get_result();

} else {
    //Ako nije search gleda se stranica iz GET
    if (isset($_GET['page_no']) && $_GET['page_no'] != "") {
        $page_no = (int)$_GET['page_no'];
        if ($page_no < 1) $page_no = 1;
    } else {
        $page_no = 1;
    }

    //Ukupan broj proizvoda
    $stmt1 = $conn->prepare("SELECT COUNT(*) FROM products");
    $stmt1->execute();
    $stmt1->bind_result($total_records);
    $stmt1->fetch();
    $stmt1->close();

    $total_no_of_pages = ($total_records > 0) ? ceil($total_records / $total_records_per_page) : 1;

    if ($page_no > $total_no_of_pages) {
        $page_no = $total_no_of_pages;
    }

    $offset = ($page_no - 1) * $total_records_per_page;

    //Uzimamo proizvode sa prevodima
    $stmt2 = $conn->prepare("
      SELECT p.*, 
             COALESCE(t.name, p.product_name) AS trans_name
      FROM products p
      LEFT JOIN product_translations t 
        ON p.product_id = t.product_id AND t.lang = ?
      LIMIT ?, ?
    ");
    $stmt2->bind_param("sii", $lang, $offset, $total_records_per_page);
    $stmt2->execute();
    $stvari = $stmt2->get_result();
}

//Ako nema rezultata → alert i vraćanje na shop.php
if (!$stvari->num_rows) {
    echo "
    <script type='text/javascript'>
        alert('Nema stvari unetih za date kategorije');
        window.location.href = 'shop.php';
    </script>
    ";
    exit;
}
?>