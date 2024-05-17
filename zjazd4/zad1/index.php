<?php
session_start();

// Stałe dane logowania
const USERNAME = 'user';
const PASSWORD = 'password';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['username'], $_POST['password'])) {
        if ($_POST['username'] === USERNAME && $_POST['password'] === PASSWORD) {
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $_POST['username'];
            setcookie('username', $_POST['username'], time() + (86400 * 3), "/");
            header('Location: rez.php');
            exit;
        } else {
            $error = 'Nieprawidłowe dane logowania';
        }
    }
}

if (isset($_GET['logout'])) {
    session_destroy();
    setcookie('username', '', time() - 3600, "/");
    header('Location: index.php');
    exit;
}

?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Logowanie</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container mt-3 p-5 my-5">
    <h2>Logowanie</h2>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    <form action="index.php" method="post">
        <div class="mb-3">
            <label for="username">Nazwa użytkownika</label>
            <input type="text" name="username" id="username" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="password">Hasło</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Zaloguj się</button>
    </form>
</div>
</body>
</html>
