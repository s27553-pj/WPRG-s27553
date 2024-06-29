<?php
session_start();
require_once 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $surname = $_POST["surname"];
    $dateofbirth = $_POST["dateofbirth"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    $terms = isset($_POST["terms"]);
    $newsletter = isset($_POST["newsletter"]);

    // Walidacja danych wejściowych
    if (empty($name) || empty($surname) || empty($dateofbirth) || empty($email) || empty($password) || empty($confirm_password)) {
        die("Proszę wypełnić wszystkie wymagane pola.");
    }
    if ($password !== $confirm_password) {
        die("Hasła nie są zgodne.");
    }
    if (!$terms) {
        die("Musisz zaakceptować regulamin.");
    }

    // Połączenie z bazą danych
    $db = new database();
    $conn = $db->getConnection();

    // Zabezpiecz dane wejściowe przed SQL injection
    $name = $conn->real_escape_string($name);
    $surname = $conn->real_escape_string($surname);
    $dob = $conn->real_escape_string($dateofbirth);
    $email = $conn->real_escape_string($email);

    // Sprawdź, czy użytkownik już istnieje
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        die("Użytkownik z tym adresem email już istnieje.");
    }

    // Hashowanie hasła
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Domyślna rola to 'admin'
    $role = 'admin';

    // Dodanie użytkownika do bazy danych z rolą 'admin'
    $sql = "INSERT INTO users (imię, nazwisko, data_urodzenia, email, haslo, role) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $name, $surname, $dob, $email, $hashed_password, $role);

    if ($stmt->execute() === TRUE) {
        echo "Rejestracja zakończona sukcesem!";
        // Przekierowanie na stronę logowania lub inną stronę
        header('Location: ../zaloguj.html');
        exit();
    } else {
        echo "Błąd: " . $sql . "<br>" . $conn->error;
    }

    // Zamknij połączenie z bazą danych
    $stmt->close();
    $conn->close();
}
?>
