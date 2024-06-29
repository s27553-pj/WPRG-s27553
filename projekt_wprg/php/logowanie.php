<?php
session_start();
require_once 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $db = new database();
    $conn = $db->getConnection();

    // Zabezpiecz dane wejściowe przed SQL injection
    $email = $conn->real_escape_string($email);

    // Używamy przygotowanych instrukcji (prepared statements) dla bezpieczeństwa
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Sprawdź hasło
        if (password_verify($password, $row['haslo'])) {
            $_SESSION['loggedin'] = true;
            $_SESSION['user_id'] = $row['id']; // Poprawka na 'user_id'
            $_SESSION['email'] = $row['email'];
            $_SESSION['role'] = $row['role'];
            header('Location: zalogowany.php');
            exit();
        } else {
            echo '<script>alert("Nieprawidłowe hasło.");</script>';
        }
    } else {
        echo '<script>alert("Nieprawidłowy email.");</script>';
    }

    $stmt->close();
    $conn->close();
}
?>
