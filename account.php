<?php include('php/account_logic.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nalog</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body style="background-color: #f8f9fa;">
<?php include 'navbar.php'; ?>

<section class="pt-5 mt-5">
    <div class="container">
        <div class="row justify-content-center g-5">

            <!-- Korisnički podaci -->
            <div class="col-lg-6">
                <div class="card shadow-sm p-4">
                    <h3 class="text-center mb-3"><?= $Language["acnt"] ?? "Vaš nalog" ?></h3>

                    <?php if (isset($_GET['error'])): ?>
                        <div class="alert alert-danger"><?= $_GET['error'] ?></div>
                    <?php endif; ?>
                    <?php if (isset($_GET['message'])): ?>
                        <div class="alert alert-success"><?= $_GET['message'] ?></div>
                    <?php endif; ?>

                    <p><strong><?= $Language["name"] ?? "Ime" ?>:</strong> <?= $_SESSION["user_name"] ?></p>
                    <p><strong>Email:</strong> <?= $_SESSION["user_email"] ?></p>

                    <button class="btn btn-outline-primary btn-sm mt-3" data-bs-toggle="modal" data-bs-target="#editAccountModal">
                        Uredi nalog
                    </button>
                    <a href="account.php?logout=1" class="btn btn-outline-danger btn-sm mt-3">Odjavi se</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- edit account -->
<div class="modal fade" id="editAccountModal" tabindex="-1" aria-labelledby="editAccountLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form method="post" action="account.php">
        <div class="modal-header">
          <h5 class="modal-title" id="editAccountLabel">Uredi nalog</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Zatvori"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
              <label class="form-label">Ime</label>
              <input type="text" class="form-control" name="user_name" value="<?= $_SESSION['user_name'] ?>" required>
          </div>
          <div class="mb-3">
              <label class="form-label">Email</label>
              <input type="email" class="form-control" name="user_email" value="<?= $_SESSION['user_email'] ?>" required>
          </div>
          <hr>
          <div class="mb-3">
              <label class="form-label">Nova lozinka</label>
              <input type="password" class="form-control" name="password" placeholder="Ostavite prazno ako ne menjate">
          </div>
          <div class="mb-3">
              <label class="form-label">Potvrdi lozinku</label>
              <input type="password" class="form-control" name="password-confirm" placeholder="Ponovite lozinku">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Otkaži</button>
          <button type="submit" name="update_account" class="btn btn-primary">Sačuvaj izmene</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Narudžbine -->
<section class="container my-5">
    <div class="text-center mb-4">
        <h2 class="fw-bold"><?= $Language["yOrder"] ?? "Vaše narudžbine" ?></h2>
        <hr class="w-25 mx-auto">
    </div>

    <?php if ($proizvodi->num_rows > 0): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover text-center bg-white">
                <thead class="table-light">
                    <tr>
                        <th><?= $Language["iOrder"] ?? "ID" ?></th>
                        <th><?= $Language["pOrder"] ?? "Cena" ?></th>
                        <th><?= $Language["sOrder"] ?? "Status" ?></th>
                        <th><?= $Language["dOrder"] ?? "Datum" ?></th>
                        <th><?= $Language["details"] ?? "Detalji" ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $proizvodi->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['order_id'] ?></td>
                            <td><?= $row['order_cost'] ?> RSD</td>
                            <td><?= $row['order_status'] ?></td>
                            <td><?= $row['order_date'] ?></td>
                            <td>
                                <form method="POST" action="order_details.php">
                                    <input type="hidden" name="order_id" value="<?= $row['order_id'] ?>">
                                    <button type="submit" name="detalji-btn" class="btn btn-outline-primary btn-sm">
                                        <?= $Language["details"] ?? "Detalji" ?>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p class="text-center">Nemate nijednu narudžbinu.</p>
    <?php endif; ?>
</section>

<?php include 'footer.html'; ?>

</body>
</html>
