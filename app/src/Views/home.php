<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>teste</title>
</head>
<body>
<h1>Lista de Usuários</h1>

<?php foreach ($users as $user): ?>
    <p><?= htmlspecialchars($user['name']) ?></p>
    <p><?= htmlspecialchars($user['email']) ?></p>
<?php endforeach; ?>
</body>
</html>
