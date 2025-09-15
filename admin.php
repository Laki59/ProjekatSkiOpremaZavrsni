<?php include("php/admin_user_logic.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Korisnici</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="assets/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="assets/css/style.css"/>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin-top: 30px;
        }
    </style>
</head>
<body>
<?php include 'adminsidebar.html'; ?>

<div id="content">
    <div class="container-fluid">
        <h1 class="mt-4">Svi korisnici</h1>
        <p>u našoj bazi podataka</p>
        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Korisnik ID</th>
                                <th>Ime</th>
                                <th>Email</th>
                                <th>Šifra</th>
                                <th>Admin</th>
                                <th>Briši</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $ljudi->fetch_assoc()): ?>
                                <tr>
                                    <td><?= $row['user_id']; ?></td>
                                    <td><?= $row['user_name']; ?></td>
                                    <td><?= $row['user_email']; ?></td>
                                    <td><?= $row['user_password']; ?></td>
                                    <td><?= $row['admin']; ?></td>
                                    <td>
                                        <form method="POST" action="admin.php" onsubmit="return confirm('Da li ste sigurni da želite obrisati korisnika?');">
                                            <input type="hidden" name="user_id" value="<?= $row['user_id']; ?>">
                                            <input type="submit" value="Briši" name="delete_btn" class="btn btn-sm btn-danger">
                                        </form>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
