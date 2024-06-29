<?php
session_start();
require_once 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['post_id'])) {
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        echo json_encode(['error' => "Nie jesteś zalogowany."]);
        exit();
    }

    $role = isset($_SESSION['role']) ? $_SESSION['role'] : null;

    // Sprawdź rolę użytkownika
    if ($role !== 'admin') {
        echo json_encode(['error' => "Nie masz uprawnień do usuwania postów jako redaktor."]);
        exit();
    }

    $post_id = $_POST['post_id'];

    $db = new database();
    $conn = $db->getConnection();

    // Zapytanie SQL do usuwania posta
    $sql_delete_post = "DELETE FROM posts WHERE id = ?";
    $stmt_delete_post = $conn->prepare($sql_delete_post);
    $stmt_delete_post->bind_param("i", $post_id);

    if ($stmt_delete_post->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => "Wystąpił błąd podczas usuwania posta."]);
    }

    $stmt_delete_post->close();
    $conn->close();
} else {
    echo json_encode(['error' => "Nieprawidłowe żądanie."]);
}
?>
