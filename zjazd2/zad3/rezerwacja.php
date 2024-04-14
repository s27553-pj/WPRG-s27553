<html>
<head>
    <meta charset="UTF-8">
    <title>Podsumowanie</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container mt-3 p-5 my-5">
   <form  action='podsumowanie.php' method='post'>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['imie'], $_POST['nazwisko'], $_POST['adres'], $_POST['numer_karty'], $_POST['numer_telefonu'], $_POST['email'], $_POST['data_przyjazdu'], $_POST['data_wyjazdu'], $_POST['godzina_przyjazdu'])) {
        $data_przyjazdu = strtotime($_POST['data_przyjazdu']);
        $data_wyjazdu = strtotime($_POST['data_wyjazdu']);
        if ($data_przyjazdu === false || $data_wyjazdu === false || $data_przyjazdu >= $data_wyjazdu || $data_przyjazdu < strtotime('today')) {
            echo "<p class='text-danger'>Nieprawidłowa data przyjazdu lub wyjazdu!</p>";
        } else {
            $liczba_gosci = $_POST['liczba_gosci'];
            if ($liczba_gosci > 1) {
                echo "<label>Podaj dane gości </label></br>";
                for ($i = 2; $i <= $liczba_gosci; $i++) {
                    echo "<label>osoba $i</label>";
                    echo "<div class='mb-3'> <label for='imie'>Imię </label><input type='text' name='imie[]' class='form-control' required></div>";
                    echo "<div class='mb-3'<label for='imie'>Nazwisko </label><input type='text' name='nazwisko[]' class='form-control' required></div>";
                    echo "<div class='mb-3'<label for='imie'>Numer telefonu </label><input type='number' name='numer_telefonu[]' pattern='[0-9]{9}' title='podaj prawidlowy numer telefonu' class='form-control' required></div>";
                }
                $liczba_gosci = $_POST['liczba_gosci'];
                $imie = $_POST['imie'];
                $nazwisko = $_POST['nazwisko'];
                $adres = $_POST['adres'];
                $numer_telefonu = $_POST['numer_telefonu'];
                $numer_karty = $_POST['numer_karty'];
                $email = $_POST['email'];
                $godzina_przyjazdu = $_POST['godzina_przyjazdu'];
                $dodatkowe_lozko = isset($_POST['dodatkowe_lozko']) ? "Tak" : "Nie";
                $udogodnienia = isset($_POST['udogodnienia']) ? implode(',', $_POST['udogodnienia']) : "brak";
                echo "<p class='card-text'>liczba gosci: $liczba_gosci</p>";
                echo "<p class='card-text'>Dane osoby rezerwującej:</p>";
                echo "<p class='card-text'>imie: $imie <p>";
                echo "<p class='card-text'>nazwisko: $nazwisko";
                echo "<p class='card-text'>email: $email</p>";
                echo "<p class='card-text'>adres: $adres</p>";
                echo "<p class='card-text'>numer karty kredytowej: $numer_karty</p>";
                echo "<p class='card-text'>data przyjazdu: $data_przyjazdu</p>";
                echo "<p class='card-text'>data wyjazdu: $data_wyjazdu</p>";
                echo "<p class='card-text'>godzina przyjazdu: $godzina_przyjazdu</p>";
                echo "<p class='card-text'>Czy potrzebne łóżko dla dziecka? $dodatkowe_lozko</p>";
                echo "<p class='card-text'> Wybrane udogodnienia: $udogodnienia</p>";
                echo "<input type='submit' value='zatwierdź rezerwację' class='btn btn-primary'>";
            }
        }
    }
}
?>

   </form>
</div>
</body>
</html>

