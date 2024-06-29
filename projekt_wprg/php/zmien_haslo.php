<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: ../zaloguj.html');
    exit();
}

$role = isset($_SESSION['role']) ? $_SESSION['role'] : null;

if ($role !== 'admin') {
    echo "Nie masz uprawnień do dodawania użytkowników.";
    exit();
}

// Pobranie danych z formularza
$imie = $_POST['imie'];
$nazwisko = $_POST['nazwisko'];
$data_urodzenia = $_POST['data_urodzenia'];
$email = $_POST['email'];
$password = $_POST['password'];
$role = $_POST['role'];

// Hashowanie hasła
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Połączenie z bazą danych
require_once 'database.php'; // Zakładając, że masz plik database.php do obsługi połączenia

$db = new database();
$conn = $db->getConnection();

// Sprawdzenie, czy email już istnieje w bazie danych
$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo '<script>alert("Użytkownik z takim adresem email już istnieje."); history.back();</script>';
    exit();
} else {
    // Dodanie użytkownika do bazy danych
    $sql = "INSERT INTO users (imie, nazwisko, data_urodzenia, email, haslo, role) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $imie, $nazwisko, $data_urodzenia, $email, $hashed_password, $role);

    if ($stmt->execute()) {
        echo '<script>alert("Użytkownik został pomyślnie dodany."); window.location.href = "ustawienia.php";</script>';
    } else {
        echo '<script>alert("Wystąpił błąd podczas dodawania użytkownika."); history.back();</script>';
        exit();
    }
}

$stmt->close();
$conn->close();
?>
