<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: ../zaloguj.html');
    exit();
}

if (isset($_SESSION['message_status']) && isset($_SESSION['message_content'])) {
    echo '<script>alert("' . $_SESSION['message_content'] . '");</script>';
    unset($_SESSION['message_status']);
    unset($_SESSION['message_content']);
}

require_once 'database.php';

$role = $_SESSION['role'];

// Połączenie z bazą danych
$db = new database();
$conn = $db->getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'delete') {
    $message_id = intval($_POST['message_id']);

    // Usunięcie wiadomości z bazy danych
    $delete_query = "DELETE FROM messages WHERE id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $message_id);

    if ($stmt->execute()) {
        $_SESSION['message_status'] = 'success';
        $_SESSION['message_content'] = 'Wiadomość została usunięta!';
    } else {
        $_SESSION['message_status'] = 'error';
        $_SESSION['message_content'] = 'Błąd: ' . $conn->error;
    }

    $stmt->close();

    // Przekierowanie, aby odświeżyć stronę i uniknąć ponownego przesłania formularza
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

// Pobranie wiadomości z bazy danych
$query = "SELECT * FROM messages ORDER BY date_sent DESC";
$result = $conn->query($query);
$messages = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $messages[] = $row;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Lista Wiadomości</title>
</head>
<body>
<h1>Lista Wiadomości</h1>
<?php if (!empty($messages)): ?>
    <ul>
        <?php foreach ($messages as $message): ?>
            <li>
                <p><strong>Od:</strong> <?= htmlspecialchars($message['email']) ?></p>
                <p><strong>Wiadomość:</strong> <?= htmlspecialchars($message['message']) ?></p>
                <p><strong>Data:</strong> <?= htmlspecialchars($message['date_sent']) ?></p>
                <form method="post" action="">
                    <input type="hidden" name="message_id" value="<?= $message['id'] ?>">
                    <input type="hidden" name="action" value="delete">
                    <button type="submit">Usuń</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>Brak wiadomości do wyświetlenia.</p>
<?php endif; ?>
</body>
</html>
