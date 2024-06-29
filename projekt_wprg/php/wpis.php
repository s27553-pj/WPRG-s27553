<?php
session_start();
include_once 'database.php';

if (isset($_SESSION['message_status']) && isset($_SESSION['message_content'])) {
    echo '<script>alert("' . $_SESSION['message_content'] . '");</script>';
    unset($_SESSION['message_status']);
    unset($_SESSION['message_content']);
}

$db = new database();
$conn = $db->getConnection();

if (!isset($_GET['id'])) {
    header("Location: ../index.html");
    exit();
}

$post_id = $_GET['id'];

$query = "SELECT * FROM posts WHERE id = ?";
$result = $db->runPreparedQuery($query, "i", [$post_id]);

if ($result->num_rows > 0) {
    $post = $result->fetch_assoc();
    $author_id = $post['user_id'];
} else {
    header("Location: ../index.html");
    exit();
}

$query_comments = "SELECT comments.*, users.imię, users.nazwisko FROM comments 
                   LEFT JOIN users ON comments.user_id = users.id 
                   WHERE comments.post_id = ?";
$result_comments = $db->runPreparedQuery($query_comments, "i", [$post_id]);

$comments = [];
if ($result_comments->num_rows > 0) {
    while($row = $result_comments->fetch_assoc()) {
        $comments[] = $row;
    }
}
$entry_id = isset($_GET['entry_id']) ? $_GET['entry_id'] : 0;

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($post['title']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="navbar navbar-expand-sm bg-dark navbar-dark fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="../index.html">
            <img src="../images/logo.png" alt="Avatar Logo" style="width:50px;" class="rounded-pill">
        </a>
    </div>
    <div class="d-flex ms-auto">
        <a href="../zaloguj.html" class="btn btn-light me-2 text-nowrap">Zaloguj się</a>
    </div>
    <form class="d-flex" action="php/wyszukaj_autora.php" method="get">
        <input class="form-control me-2" type="text" placeholder="Wyszukaj autora" name="autor">
        <button class="btn btn-primary" type="submit">Szukaj</button>
    </form>

</div>
<div class="container mt-5 pt-5">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title"><?php echo htmlspecialchars($post['title']); ?></h5>
            <?php if (!empty($post['image_path'])): ?>
                <div class="text-center">
                    <img src="<?php echo htmlspecialchars($post['image_path']); ?>" class="img-fluid mb-3" style="max-width: 300px; height: auto;" alt="Zdjęcie do wpisu">
                </div>
            <?php endif; ?>
            <p class="card-text"><?php echo htmlspecialchars($post['content']); ?></p>
            <p class="card-text"><small class="text-muted">Data publikacji: <?php echo htmlspecialchars($post['date_pub']); ?></small></p>

            <?php if (!empty($comments)): ?>
                <h5 class="mt-4">Komentarze:</h5>
                <ul class="list-group">
                    <?php foreach ($comments as $comment): ?>
                        <li class="list-group-item">
                            <strong><?php echo isset($comment['imię']) && isset($comment['nazwisko']) ? htmlspecialchars($comment['imię'] . ' ' . $comment['nazwisko']) : 'Gość'; ?>:</strong>
                            <?php echo htmlspecialchars($comment['comment']); ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p class="mt-4">Brak komentarzy.</p>
            <?php endif; ?>

            <form action="dodaj_komentarz.php?id=<?php echo $post_id; ?>" method="post">
                <div class="mb-3">
                    <label for="comment">Dodaj komentarz:</label>
                    <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                </div>
                <?php if(isset($_SESSION['user_id'])): ?>
                    <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($_SESSION['user_id']); ?>">
                <?php else: ?>
                    <input type="hidden" name="user_id" value="0">
                <?php endif; ?>
                <input type="hidden" name="post_id" value="<?php echo htmlspecialchars($post_id); ?>">
                <button type="submit" class="btn btn-primary">Dodaj komentarz</button>
            </form>

        </div>
        <div class="container mt-5">
            <button class="btn btn-secondary" onclick="document.getElementById('contactForm').style.display='block'">Kontakt z autorem</button>
            <div id="contactForm" class="mt-4" style="display: none;">
                <h5>Kontakt z autorem</h5>
                <form action="wyslij_wiadomosc.php" method="post">
                    <input type="hidden" name="author_id" value="<?php echo $author_id; ?>">
                    <input type="hidden" name="post_id" value="<?php echo htmlspecialchars($post_id); ?>">
                    <input type="hidden" name="page" value="wpis">
                    <div class="mb-3">
                        <label for="messageTitle" class="form-label">Tytuł wiadomości:</label>
                        <input type="text" class="form-control" id="messageTitle" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($_SESSION['loggedin']) ? htmlspecialchars($_SESSION['email']) : ''; ?>" <?php echo isset($_SESSION['loggedin']) ? 'readonly' : ''; ?> required>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Wiadomość:</label>
                        <textarea class="form-control" id="message" name="message" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" onclick="showMessage()">Wyślij</button>
                </form>
            </div>


        </div>
    </div>
</div>
</body>
</html>
