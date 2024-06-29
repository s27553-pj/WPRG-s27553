<?php
session_start();
include_once __DIR__ . '/database.php';

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

$db = new database();
$conn = $db->getConnection();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: ../zaloguj.html');
    exit();
}
if (isset($_SESSION['message_status']) && isset($_SESSION['message_content'])) {
    echo '<script>alert("' . $_SESSION['message_content'] . '");</script>';
    unset($_SESSION['message_status']);
    unset($_SESSION['message_content']);
}
$role = $_SESSION['role'];
$email=$_SESSION['email'];



$query = "SELECT * FROM messages ORDER BY date_sent DESC";
$result = $db->runPreparedQuery($query, "", []);

$messages = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $messages[] = $row;
    }
}
//echo "Rola użytkownika: " . $role; // Sprawdzenie, czy rola jest poprawnie ustawiona


$conn->close();

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>BlogoStrefa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="apple-touch-icon" sizes="180x180" href="../images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../images/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="stylesheet" href="../css/style.css" type="text/css">
    <script src="../javascripts/script.js" async></script>
</head>
<style>
    body {
        background: white;
    }
    .sidebar {
        height: 100vh;
        position: fixed;
    }
    .content {
        margin-left: 25%;
    }
</style>
<body>
<div class="container-fluid">
    <div class="row">
        <!-- Boczne menu -->
        <nav class="col-md-3 d-none d-md-block bg-light sidebar">
            <div class="position-sticky pt-3">
                <!-- Navbar brand -->
                <a class="navbar-brand" href="../index.html?loggedin=true">BlogoStrefa</a>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="showPostForm()">Dodaj post</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="showSettings()">Ustawienia</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="showMessages()">Skrzynka odbiorcza</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="wyloguj.php">Wyloguj</a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Menu hamburgera dla mniejszych rozdzielczości -->
        <nav class="navbar navbar-expand-md navbar-light bg-light d-md-none">
            <div class="container-fluid">
                <a class="navbar-brand" href="../index.html?loggedin=true">BlogoStrefa</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="showPostForm()">Dodaj post</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="showSettings()">Ustawienia</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="showMessages()">Skrzynka odbiorcza</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="wyloguj.php">Wyloguj</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Zawartość strony -->
        <main class="col-md-9 ms-sm-auto col-lg-9">
            <div id="postForm" class="container mt-5" style="display: none;">
                <div class="row">
                    <div class="col-md-8">
                        <h2>Dodaj nowy post</h2>
                        <form action="dodaj_post.php" method="post" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="title" class="form-label">Tytuł:</label>
                                <input type="text" class="form-control" id="title" name="title" required>
                            </div>
                            <div class="mb-3">
                                <label for="content" class="form-label">Treść:</label>
                                <textarea class="form-control" id="content" name="content" rows="10" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">Obrazek (opcjonalnie)</label>
                                <input type="file" class="form-control" id="image" name="image">
                            </div>
                            <button type="submit" class="btn btn-primary">Opublikuj</button>
                        </form>
                    </div>
                </div>
            </div>
            <div id="editPost" class="container mt-5" style="display: none;">
                <div class="row">
                    <div class="col-md-8">
                        <h2>Edytuj post</h2>
                        <form action="edytuj_post.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" id="editPostId" name="id">
                            <div class="mb-3">
                                <label for="editTitle" class="form-label">Tytuł:</label>
                                <input type="text" class="form-control" id="editTitle" name="title" required>
                            </div>
                            <div class="mb-3">
                                <label for="editContent" class="form-label">Treść:</label>
                                <textarea class="form-control" id="editContent" name="content" rows="10" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="editImage" class="form-label">Obrazek (opcjonalnie)</label>
                                <input type="file" class="form-control" id="editImage" name="image">
                            </div>
                            <button type="submit" class="btn btn-primary">Zaktualizuj</button>
                        </form>
                    </div>
                </div>
            </div>
            <div id="ustawienia" class="container mt-5" style="display: none;">
                <?php include 'ustawienia.php'; ?>
            </div>
            <div class="container mt-5" id="postListContainer">
                <h2 id="hlist">Twoje posty</h2>
                <div id="postList" class="row row-cols-1 row-cols-md-3 g-4">
                    <?php
                    include __DIR__ . '/lista_postow.php';
                    ?>
                </div>
            </div>
    <div id="messages" class="container mt-5" style="display: none;">
        <h2>Skrzynka odbiorcza</h2>
        <?php if (count($messages) > 0): ?>
            <table class="table">
                <thead>
                <tr>
                    <th>Tytuł</th>
                    <th>Email</th>
                    <th>Data</th>
                    <th>Akcje</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($messages as $message): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($message['title']); ?></td>
                        <td><?php echo htmlspecialchars($message['email']); ?></td>
                        <td><?php echo htmlspecialchars($message['date_sent']); ?></td>
                        <td>
                            <button class="btn btn-primary" onclick="readMessage(<?php echo $message['id']; ?>)">Przeczytaj</button>
                            <button class="btn btn-danger" onclick="deleteMessage(<?php echo $message['id']; ?>)">Usuń</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Brak wiadomości w skrzynce odbiorczej.</p>
        <?php endif; ?>

    </div>

    <div id="messageDetail" class="container mt-5" style="display: none;">
        <h2>Wiadomość</h2>
        <p id="messageTitle"></p>
        <p id="messageEmail"></p>
        <p id="messageContent"></p>
        <p id="messageDate"></p>
        <form action="wyslij_wiadomosc.php" method="post" enctype="multipart/form-data" target="_self">
            <input type="hidden" id="messageId" name="message_id">
            <input type="hidden" name="page" value="zalogowany">
            <input type="hidden" id="postId" name="post_id">
            <input type="hidden" id="authorId" name="author_id">
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($_SESSION['loggedin']) ? htmlspecialchars($_SESSION['email']) : ''; ?>" <?php echo isset($_SESSION['loggedin']) ? 'readonly' : ''; ?> required>
            </div>
            <div class="mb-3">
                <label for="responseTitle" class="form-label">Tytuł wiadomości:</label>
                <input type="text" class="form-control" id="responseTitle" name="title" required>
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">Wiadomość:</label>
                <textarea class="form-control" id="message" name="message" rows="3" required></textarea>
            </div>
            <input type="hidden" name="author_id" value="<?php echo isset($_SESSION['id']) ? htmlspecialchars($_SESSION['id']) : ''; ?>">
            <button type="submit" class="btn btn-primary">Wyślij</button>
        </form>
    </div>

</div>
</div>
</main>
</body>
</html>
