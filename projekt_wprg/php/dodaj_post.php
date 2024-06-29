<?php
session_start();

require_once 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $content = $_POST["content"];
    $date = date("Y-m-d H:i:s");
    $imagePath = null;

    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $check = getimagesize($_FILES["image"]["tmp_name"]);

        if ($check !== false) {
            if ($_FILES["image"]["size"] <= 5000000) {
                if (in_array($imageFileType, ["jpg", "png", "jpeg", "gif"])) {
                    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                        $imagePath = $target_file;
                    } else {
                        echo '<script>alert("Błąd podczas przesyłania pliku.");</script>';
                    }
                } else {
                    echo '<script>alert("Dozwolone formaty plików to JPG, JPEG, PNG i GIF.");</script>';
                }
            } else {
                echo '<script>alert("Plik jest zbyt duży. Maksymalny rozmiar to 5MB.");</script>';
            }
        } else {
            echo '<script>alert("Plik nie jest obrazkiem.");</script>';
        }
    }

    $db = new database();
    $conn = $db->getConnection();

    $title = $conn->real_escape_string($title);
    $content = $conn->real_escape_string($content);
    $imagePath = $imagePath ? $conn->real_escape_string($imagePath) : null;
    $user_id = $_SESSION['user_id'];

    // Pobieranie roli użytkownika
    $query = "SELECT role FROM users WHERE id = ?";
    $roleStmt = $conn->prepare($query);
    $roleStmt->bind_param("i", $user_id);
    $roleStmt->execute();
    $roleResult = $roleStmt->get_result();

    if ($roleResult->num_rows > 0) {
        $row = $roleResult->fetch_assoc();
        $role = $row['role'];
    } else {
        // Obsługa błędu, jeśli nie można pobrać roli użytkownika
        echo '<script>alert("Błąd: Nie można pobrać roli użytkownika.");</script>';
        exit();
    }

    $roleStmt->close();

    // Ustawianie właściciela posta
    if ($role === 'admin') {
        $owner_id = $user_id; // Jeśli zalogowany użytkownik jest administratorem
    } else {
        // Jeśli zalogowany użytkownik jest redaktorem, właścicielem posta będzie administrator
        $query = "SELECT id FROM users WHERE role = 'admin' LIMIT 1";
        $ownerResult = $db->runPreparedQuery($query, "", []);

        if ($ownerResult->num_rows > 0) {
            $ownerRow = $ownerResult->fetch_assoc();
            $owner_id = $ownerRow['id'];
        } else {
            echo '<script>alert("Błąd: Nie można znaleźć administratora.");</script>';
            exit();
        }
    }

    $sql = "INSERT INTO posts (title, content, date_pub, image_path, user_id, owner_id) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssii", $title, $content, $date, $imagePath, $user_id, $owner_id);

    if ($stmt->execute() === TRUE) {
        echo '<script>
                alert("Nowy post został dodany pomyślnie!");
                window.location.href = "zalogowany.php";
              </script>';
    } else {
        echo '<script>alert("Błąd: ' . $conn->error . '");</script>';
    }

    $stmt->close();
}
?>
