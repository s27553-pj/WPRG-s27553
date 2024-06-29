<?php
session_start();
include_once 'database.php';

$db = new database();
$conn = $db->getConnection();

$author = isset($_GET['autor']) ? $_GET['autor'] : '';

$query = "SELECT posts.*, users.imię, users.nazwisko, users.email FROM posts 
          JOIN users ON posts.user_id = users.id 
          WHERE CONCAT(users.imię, ' ', users.nazwisko) LIKE ? 
          OR users.email LIKE ?";
$result = $db->runPreparedQuery($query, "ss", ["%$author%", "%$author%"]);

$blogs = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $blogs[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Wyniki wyszukiwania</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5 pt-5">
    <h2>Wyniki wyszukiwania dla "<?php echo htmlspecialchars($author); ?>"</h2>
    <div class="row">
        <?php if (count($blogs) > 0): ?>
            <?php foreach ($blogs as $blog): ?>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img src="<?php echo htmlspecialchars($blog['image_path']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($blog['title']); ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($blog['title']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars(substr($blog['content'], 0, 100)); ?>...</p>
                            <p class="card-text"><small class="text-muted">Autor: <?php echo htmlspecialchars($blog['imię'] . ' ' . $blog['nazwisko']); ?></small></p>
                            <a href="wpis.php?id=<?php echo $blog['id']; ?>" class="btn btn-primary">Czytaj więcej</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Nie znaleziono blogów dla tego autora.</p>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
