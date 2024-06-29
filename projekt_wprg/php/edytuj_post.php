<?php
session_start();
include_once 'database.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: ../zaloguj.html');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Pobierz dane z formularza
    $postId = $_POST['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $image = $_FILES['image'];

    // Przygotowanie zapytania aktualizacji
    $query = "UPDATE posts SET title = ?, content = ? WHERE id = ?";
    $params = [$title, $content, $postId];

    if (!empty($image['name'])) {
        // Jeśli dodano nowy obrazek, aktualizuj również obrazek
        $query = "UPDATE posts SET title = ?, content = ?, image = ? WHERE id = ?";
        $params = [$title, $content, $image['name'], $postId];

        // Przenieś przesłany plik do docelowego katalogu
        move_uploaded_file($image['tmp_name'], '../images/' . $image['name']);
    }

    // Wykonaj zapytanie przygotowane
    $db = new database();
    $conn = $db->getConnection();
    $stmt = $conn->prepare($query);
    $stmt->bind_param(str_repeat('s', count($params)), ...$params);

    // Sprawdź, czy zapytanie się powiodło
    if ($stmt->execute()) {
        // Jeśli sukces, przekieruj do zalogowanego panelu
        $_SESSION['message_status'] = true;
        $_SESSION['message_content'] = "Post został pomyślnie zaktualizowany.";
    } else {
        // Jeśli niepowodzenie, ustaw komunikat o błędzie
        $_SESSION['message_status'] = false;
        $_SESSION['message_content'] = "Wystąpił błąd podczas aktualizacji posta: " . $stmt->error;
    }

    // Zakończ połączenie i przekieruj
    $stmt->close();
    $conn->close();

    // Przekierowanie do panelu zalogowanego użytkownika
    header('Location: zalogowany.php');
    exit();
} else {
    // Jeśli próba dostępu bezpośredniego, przekieruj na stronę logowania
    header('Location: ../zaloguj.html');
    exit();
}
?>
