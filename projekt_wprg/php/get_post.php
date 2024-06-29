<?php
require_once 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $post_id = intval($_GET['id']);

    $db = new database();
    $conn = $db->getConnection();

    $sql = "SELECT p.id, p.title, p.content, p.date_pub, p.image_path, u.role 
            FROM posts p 
            INNER JOIN users u ON p.user_id = u.id 
            WHERE p.id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode($row);
    } else {
        echo json_encode(['error' => "Nie znaleziono postu."]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['error' => "Nieprawidłowe żądanie."]);
}
?>
