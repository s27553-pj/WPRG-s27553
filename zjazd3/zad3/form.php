<?php
function handle_directory_operation($path, $directory, $operation) {
    $full_path = $path . '/' . $directory;
    switch ($operation) {
        case 'read':
            if (is_dir($full_path)) {
                $contents = scandir($full_path);
                echo "Zawartość katalogu '$directory' w ścieżce '$path':<br>";
                foreach ($contents as $item) {
                    if ($item != '.' && $item != '..') {
                        echo $item . "<br>";
                    }
                }
            } else {
                echo "Katalog '$directory' nie istnieje w ścieżce '$path'.";
            }
            break;
        case 'create':
            if (!is_dir($full_path)) {
                mkdir($full_path);
                echo "Utworzono katalog '$directory' w ścieżce '$path'.";
            } else {
                echo "Katalog '$directory' już istnieje w ścieżce '$path'.";
            }
            break;
        case 'delete':
            if (is_dir($full_path)) {
                rmdir($full_path);
                echo "Usunięto katalog '$directory' z ścieżki '$path'.";
            } else {
                echo "Katalog '$directory' nie istnieje w ścieżce '$path'.";
            }
            break;
        default:
            echo "Niepoprawna operacja.";
            break;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $path = isset($_POST['path']) ? $_POST['path'] : '';
    $directory = isset($_POST['directory']) ? $_POST['directory'] : '';
    $operation = isset($_POST['operation']) ? $_POST['operation'] : 'read';

    if (!empty($path) && !empty($directory) && !empty($operation)) {
        handle_directory_operation($path, $directory, $operation);
    } else {
        echo "Proszę wypełnić wszystkie pola formularza.";
    }
}
?>