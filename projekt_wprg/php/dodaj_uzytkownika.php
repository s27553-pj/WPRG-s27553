<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
//session_start();
//if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
//    header('Location: ../zaloguj.html');
//    exit();
//}
//
//$role = isset($_SESSION['role']) ? $_SESSION['role'] : null;
//
//if ($role !== 'admin') {
//    echo "Nie masz uprawnień do dodawania użytkowników.";
//    exit();
//}
//
//// Pobranie danych z formularza
//$imie = $_POST['imie'];
//$nazwisko = $_POST['nazwisko'];
//$data_urodzenia = $_POST['data_urodzenia'];
//$email = $_POST['email'];
//$password = $_POST['password'];
//$role = $_POST['role'];
//
//// Hashowanie hasła
//$hashed_password = password_hash($password, PASSWORD_DEFAULT);
//
//// Połączenie z bazą danych
//require_once 'database.php'; // Zakładając, że masz plik database.php do obsługi połączenia
//
//$db = new database();
//$conn = $db->getConnection();
//
//if (!$conn) {
//    die("Błąd połączenia z bazą danych: " . mysqli_connect_error());
//}
//
//// Sprawdzenie, czy email już istnieje w bazie danych
//$sql_check_email = "SELECT * FROM users WHERE email = ?";
//$stmt_check_email = $conn->prepare($sql_check_email);
//$stmt_check_email->bind_param("s", $email);
//$stmt_check_email->execute();
//$result_check_email = $stmt_check_email->get_result();
//
//if ($result_check_email->num_rows > 0) {
//    echo '<script>alert("Użytkownik z takim adresem email już istnieje."); history.back();</script>';
//    exit();
//}
//
//// Dodanie użytkownika do bazy danych
//$sql_insert_user = "INSERT INTO users (imię, nazwisko, data_urodzenia, email, haslo, role) VALUES (?, ?, ?, ?, ?, ?)";
//$stmt_insert_user = $conn->prepare($sql_insert_user);
//
//if ($stmt_insert_user === false) {
//    echo "Błąd przy przygotowywaniu zapytania SQL: " . $conn->error;
//    exit();
//}
//
//$stmt_insert_user->bind_param("ssssss", $imie, $nazwisko, $data_urodzenia, $email, $hashed_password, $role);
//
//if ($stmt_insert_user->execute()) {
//    echo '<script>alert("Użytkownik został pomyślnie dodany."); window.location.href = "zalogowany.php";</script>';
//} else {
//    echo '<script>alert("Wystąpił błąd podczas dodawania użytkownika."); history.back();</script>';
//    exit();
//}
//
//$stmt_insert_user->close();
//$conn->close();
//?>
<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

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

if (!$conn) {
    die("Błąd połączenia z bazą danych: " . mysqli_connect_error());
}

// Sprawdzenie, czy email już istnieje w bazie danych
$sql_check_email = "SELECT * FROM users WHERE email = ?";
$stmt_check_email = $conn->prepare($sql_check_email);
$stmt_check_email->bind_param("s", $email);
$stmt_check_email->execute();
$result_check_email = $stmt_check_email->get_result();

if ($result_check_email->num_rows > 0) {
    echo '<script>alert("Użytkownik z takim adresem email już istnieje."); history.back();</script>';
    exit();
}

// Dodanie użytkownika do bazy danych
$sql_insert_user = "INSERT INTO users (imię, nazwisko, data_urodzenia, email, haslo, role, added_by) VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt_insert_user = $conn->prepare($sql_insert_user);

if ($stmt_insert_user === false) {
    echo "Błąd przy przygotowywaniu zapytania SQL: " . $conn->error;
    exit();
}

$added_by = $_SESSION['user_id']; // ID admina lub właściciela bloga, który dodaje użytkownika
$stmt_insert_user->bind_param("ssssssi", $imie, $nazwisko, $data_urodzenia, $email, $hashed_password, $role, $added_by);

if ($stmt_insert_user->execute()) {
    echo '<script>alert("Użytkownik został pomyślnie dodany."); window.location.href = "zalogowany.php";</script>';
} else {
    echo '<script>alert("Wystąpił błąd podczas dodawania użytkownika."); history.back();</script>';
    exit();
}

$stmt_insert_user->close();
$conn->close();
?>
