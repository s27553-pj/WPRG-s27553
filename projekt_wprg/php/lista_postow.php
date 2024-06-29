<?php
session_start();
require_once 'database.php';

if (!isset($_SESSION['user_id'])) {
    echo "<p>Nie jesteś zalogowany.</p>";
    exit();
}

$user_id = $_SESSION['user_id'];

$db = new database();
$conn = $db->getConnection();

// Zapytanie SQL do pobrania postów
$sql = "SELECT p.id, p.title, p.content, p.date_pub, p.image_path 
        FROM posts p 
        INNER JOIN users u ON p.user_id = u.id 
        WHERE p.user_id = ? OR u.role = 'admin' OR u.role = 'redaktor'
        ORDER BY p.date_pub DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result === false) {
    echo "<p>Wystąpił błąd podczas pobierania postów.</p>";
} else if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<div class='col-md-4'>";
        echo "<div class='card mb-4 shadow-sm'>";
        if ($row['image_path']) {
            $image_path = htmlspecialchars($row['image_path']); // Zmiana ścieżki obrazka
            echo "<div class='text-center' style='max-height: 200px; overflow: hidden;'>";
            echo "<img src='" . $image_path . "' class='card-img-top img-fluid' alt='Post image'>"; // Używamy zmiennej $image_path
            echo "</div>";
        }
        echo "<div class='card-body'>";
        echo "<h5 class='card-title'>" . htmlspecialchars($row['title']) . "</h5>";
        echo "<p class='card-text'>" . nl2br(htmlspecialchars($row['content'])) . "</p>";
        echo "<div class='d-flex justify-content-between align-items-center'>";
        echo "<div class='btn-group'>";
        echo "<button type='button' class='btn btn-sm btn-outline-secondary' onclick='showEditPostForm(" . $row['id'] . ")'>Edytuj</button>";
        echo "<button type='button' class='btn btn-sm btn-outline-secondary' onclick='deletePost(" . $row['id'] . ")'>Usuń</button>";
        echo "</div>";
        echo "<small class='text-muted'>" . $row['date_pub'] . "</small>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
    }
} else {
    echo "<p>Brak postów do wyświetlenia.</p>";
}

$stmt->close();
?>
