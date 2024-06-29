<?php
session_start();

require_once 'database.php';
$db = new database();
$conn = $db->getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sprawdź, czy użytkownik jest zalogowany
    if (isset($_SESSION['user_id'])) {
        // Jeśli zalogowany, pobierz user_id z sesji
        $user_id = $_SESSION['user_id'];
    } else {
        // Jeśli niezalogowany, ustaw user_id na 0 (gość)
        $user_id = 0;
    }

    $post_id = $conn->real_escape_string($_POST['post_id']);
    $comment = $conn->real_escape_string($_POST['comment']);

    $query = "INSERT INTO comments (post_id, user_id, comment) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iis", $post_id, $user_id, $comment);

    if ($stmt->execute() === TRUE) {
        echo '<script>alert("Komentarz został dodany pomyślnie."); window.location.href = "wpis.php?id=' . $post_id . '";</script>';
    } else {
        echo '<script>alert("Wystąpił błąd podczas dodawania komentarza: ' . $conn->error . '"); window.location.href = "wpis.php?id=' . $post_id . '";</script>';
    }
    $stmt->close();
}
?>
