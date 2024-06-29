<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
$title = $_POST["title"];
$email = $_POST["email"];
$message = $_POST["message"];
$post_id = $_POST["post_id"];
$author_id = $_POST["author_id"];
$page = $_POST["page"];

$servername = "localhost";
$username = "root";
$password_db = "root";
$dbname = "blogostrefa";

$conn = new mysqli($servername, $username, $password_db, $dbname);

if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}

// Zabezpieczenie przed SQL Injection
$email = $conn->real_escape_string($email);
$message = $conn->real_escape_string($message);
$title = $conn->real_escape_string($title);

// Wstawienie danych do tabeli messages
$query = "INSERT INTO messages (email, title, message, user_id, author_id) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
$stmt->bind_param("ssiii", $email, $title, $message, $user_id, $author_id);

if ($stmt->execute()) {
$_SESSION['message_status'] = 'success';
$_SESSION['message_content'] = 'Wysłano wiadomość!';
} else {
$_SESSION['message_status'] = 'error';
$_SESSION['message_content'] = 'Błąd: ' . $conn->error;
}

$stmt->close();
$conn->close();

// Przekierowanie z powrotem na odpowiednią stronę
if ($page == 'zalogowany') {
header("Location: zalogowany.php");
} else if ($page == 'wpis') {
header("Location: wpis.php?id=" . $post_id);
}
exit();
}
?>