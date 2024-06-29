<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    echo json_encode(['loggedin' => false]);
    exit();
}

$role = isset($_SESSION['role']) ? $_SESSION['role'] : null;

echo json_encode([
    'loggedin' => true,
    'role' => $role
]);
?>

