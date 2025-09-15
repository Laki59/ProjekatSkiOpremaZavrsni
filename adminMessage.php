<?php include("php/admin_message_logic.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Poruke</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" />
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
        <h1 class="mt-4">Sve poruke</h1>
        <p>U našoj bazi podataka</p>
        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Poruka ID</th>
                                <th>Korisnik ID</th>
                                <th>Ime korisnika</th>
                                <th>Email</th>
                                <th>Naslov</th>
                                <th>Poruka</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $poruke->fetch_assoc()): ?>
                                <tr>
                                    <td><?= $row['message_id'] ?></td>
                                    <td><?= $row['user_id'] ?></td>
                                    <td><?= htmlspecialchars($row['user_name']) ?></td>
                                    <td><?= htmlspecialchars($row['user_email']) ?></td>
                                    <td><?= htmlspecialchars($row['subject']) ?></td>
<td>
    <?= substr(htmlspecialchars($row['message']), 0, 50) . "..." ?>
    <form method="GET" action="adminViewMessage.php" style="display:inline;">
        <input type="hidden" name="message_id" value="<?= $row['message_id'] ?>">
        <button type="submit" class="btn btn-sm btn-outline-primary">View</button>
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
