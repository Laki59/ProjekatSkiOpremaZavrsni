<?php include 'php/admin_ViewMessage_logic.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pogledaj poruku</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css"/>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="assets/css/style.css"/>
</head>
<body>

<?php include 'adminsidebar.html'; ?>

<div id="content" class="container mt-5">
    <h2>Poruka #<?= $message['message_id'] ?></h2>
    <div class="card p-4 shadow-sm">
        <p><strong>Korisnik:</strong> <?= htmlspecialchars($message['user_name']) ?> (<?= htmlspecialchars($message['user_email']) ?>)</p>
        <p><strong>Naslov:</strong> <?= htmlspecialchars($message['subject']) ?></p>
        <hr>
        <p><strong>Poruka:</strong></p>
        <p><?= nl2br(htmlspecialchars($message['message'])) ?></p>
    </div>

    <a href="adminMessage.php" class="btn btn-secondary mt-3">⬅ Nazad</a>
</div>

</body>
</html>
