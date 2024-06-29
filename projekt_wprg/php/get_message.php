<?php
session_start();
require_once 'database.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    echo json_encode(['error' => 'Użytkownik nie jest zalogowany.']);
    exit();
}

if (!isset($_GET['id'])) {
    echo json_encode(['error' => 'Nie przesłano identyfikatora wiadomości.']);
    exit();
}

$message_id = intval($_GET['id']);

$db = new database();
$conn = $db->getConnection();

// Pobierz email zalogowanego użytkownika z sesji
$user_email = $_SESSION['email'];

$query = "SELECT id, email, message, date_sent FROM messages WHERE id = ? AND email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("is", $message_id, $user_email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $message = $result->fetch_assoc();
    echo json_encode($message);
} else {
    echo json_encode(['error' => 'Nie znaleziono wiadomości o podanym identyfikatorze lub nie masz dostępu do tej wiadomości.']);
}

$stmt->close();
$conn->close();
?>
