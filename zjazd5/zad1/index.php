<?php
// Dane do połączenia z bazą danych
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "osoba";

// Nawiązanie połączenia
$conn = new mysqli($servername, $username, $password, $dbname);

// Sprawdzenie połączenia
if ($conn->connect_error) {
    die("Połączenie nieudane: " . $conn->connect_error);
}

// Polecenie SELECT
$sql_select = "SELECT * FROM dane";
$result_select = $conn->query($sql_select);

// Przykład użycia mysqli_fetch_row
if ($result_select->num_rows > 0) {
    while ($row = $result_select->fetch_row()) {
        printf("ID: %s, Imię: %s, Nazwisko: %s, Data urodzenia: %s<br>", $row[0], $row[1], $row[2], $row[3]);
    }
} else {
    echo "Brak wyników dla polecenia SELECT.";
}

// Polecenie INSERT INTO
$sql_insert = "INSERT INTO dane (imie, nazwisko, data_urodzenia) VALUES ('Natalia', 'Sokol', '1990-01-01')";
if ($conn->query($sql_insert) === TRUE) {
    echo "Nowy rekord został dodany poprawnie.";
} else {
    echo "Błąd: " . $sql_insert . "<br>" . $conn->error;
}

// Sprawdzenie liczby wierszy
$sql_count = "SELECT COUNT(*) AS total FROM dane";
$result_count = $conn->query($sql_count);
if ($result_count->num_rows > 0) {
    $row_count = $result_count->fetch_assoc();
    echo "Liczba wierszy w tabeli: " . $row_count["total"];
} else {
    echo "Błąd: " . $sql_count . "<br>" . $conn->error;
}

// Zamykanie połączenia
$conn->close();
?>
