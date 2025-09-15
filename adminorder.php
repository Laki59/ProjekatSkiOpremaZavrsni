<?php include 'php/admin_order_logic.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Orders</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" crossorigin="anonymous" />
    <link rel="stylesheet" href="assets/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="assets/css/style.css"/>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin-top:30px;
        }
    </style>
</head>
<body>
<?php include 'adminsidebar.html';?>

    <div id="content">
        <div class="container-fluid">
            <h1 class="mt-4">Sve porudžbine</h1>
            <p>U našoj bazi podataka</p>

            <!-- 🔍 Search bar -->
            <form method="GET" action="adminorder.php" class="mb-3 d-flex" style="max-width:400px;">
                <input type="number" name="search" class="form-control me-2" placeholder="Pretraži po Order ID" value="<?php echo htmlspecialchars($search); ?>">
                <button type="submit" class="btn btn-primary">Pretraži</button>
            </form>

            <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Porudžbina ID</th>
                                    <th>Cena porudžbine</th>
                                    <th>Status porudžbine</th>
                                    <th>ID korisnika</th>
                                    <th>Broj korisnika</th>
                                    <th>Grad korisnika</th>
                                    <th>Adresa korisnika</th>
                                    <th>Datum porudžbine</th>
                                    <th>Brisanje</th>
                                </tr>
                            </thead>
                            <tbody>
    <?php while ($row = $stvari->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['order_id']; ?></td>
            <td><?php echo $row['order_cost']; ?></td>
            <td><?php echo $row['order_status']; ?></td>
            <td><?php echo $row['user_id']; ?></td>
            <td><?php echo $row['user_phone']; ?></td>
            <td><?php echo $row['user_city']; ?></td>
            <td><?php echo $row['user_address']; ?></td>
            <td><?php echo $row['order_date']; ?></td>
            <td>
                <form method="POST" action="adminorder.php" style="display:inline;">
                    <input type="hidden" name="order_id" value="<?php echo $row['order_id']; ?>">
                    <input type="submit" value="Brisi" name="delete_btn_order" class="btn btn-danger btn-sm">
                </form>
            </td>
        </tr>
    <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
