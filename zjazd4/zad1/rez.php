<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    echo "Brak dostępu. Musisz być zalogowany, aby uzyskać dostęp do tej części strony.";
    exit;
}
$username = isset($_COOKIE['username']) ? $_COOKIE['username'] : '';
$imie = isset($_COOKIE['imie']) ? $_COOKIE['imie'] : '';
$nazwisko = isset($_COOKIE['nazwisko']) ? $_COOKIE['nazwisko'] : '';
$adres = isset($_COOKIE['adres']) ? $_COOKIE['adres'] : '';
$numer_telefonu = isset($_COOKIE['numer_telefonu']) ? $_COOKIE['numer_telefonu'] : '';
$numer_karty = isset($_COOKIE['numer_karty']) ? $_COOKIE['numer_karty'] : '';
$email = isset($_COOKIE['email']) ? $_COOKIE['email'] : '';
$godzina_przyjazdu = isset($_COOKIE['godzina_przyjazdu']) ? $_COOKIE['godzina_przyjazdu'] : '';
$dodatkowe_lozko = isset($_COOKIE['dodatkowe_lozko']) ? $_COOKIE['dodatkowe_lozko'] : '';
$udogodnienia = isset($_COOKIE['udogodnienia']) ? $_COOKIE['udogodnienia'] : '';
$liczba_gosci = isset($_COOKIE['liczba_gosci']) ? $_COOKIE['liczba_gosci'] : '';
$data_przyjazdu = isset($_COOKIE['data_przyjazdu']) ? $_COOKIE['data_przyjazdu'] : '';
$data_wyjazdu = isset($_COOKIE['data_wyjazdu']) ? $_COOKIE['data_wyjazdu'] : '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['clear_cookies']) && $_POST['clear_cookies'] == "true") {
        setcookie('imie', '', time() - 3600, "/");
        setcookie('nazwisko', '', time() - 3600, "/");
        setcookie('email', '', time() - 3600, "/");
        setcookie('adres', '', time() - 3600, "/");
        setcookie('numer_telefonu', '', time() - 3600, "/");
        setcookie('numer_karty', '', time() - 3600, "/");
        setcookie('data_przyjazdu', '', time() - 3600, "/");
        setcookie('data_wyjazdu', '', time() - 3600, "/");
        setcookie('godzina_przyjazdu', '', time() - 3600, "/");
        setcookie('dodatkowe_lozko', '', time() - 3600, "/");
        setcookie('udogodnienia', '', time() - 3600, "/");
        setcookie('liczba_gosci', '', time() - 3600, "/");

    }
    setcookie('imie', isset($_POST['imie']) ? $_POST['imie'] : '', time() + (86400 * 3), "/");
    setcookie('nazwisko', isset($_POST['nazwisko']) ? $_POST['nazwisko'] : '', time() + (86400 * 3), "/");
    setcookie('email', isset($_POST['email']) ? $_POST['email'] : '', time() + (86400 * 3), "/");
    setcookie('adres', isset($_POST['adres']) ? $_POST['adres'] : '', time() + (86400 * 3), "/");
    setcookie('numer_telefonu', isset($_POST['numer_telefonu']) ? $_POST['numer_telefonu'] : '', time() + (86400 * 3), "/");
    setcookie('numer_karty', isset($_POST['numer_karty']) ? $_POST['numer_karty'] : '', time() + (86400 * 3), "/");
    setcookie('data_przyjazdu', isset($_POST['data_przyjazdu']) ? $_POST['data_przyjazdu'] : '', time() + (86400 * 3), "/");
    setcookie('data_wyjazdu', isset($_POST['data_wyjazdu']) ? $_POST['data_wyjazdu'] : '', time() + (86400 * 3), "/");
    setcookie('godzina_przyjazdu', isset($_POST['godzina_przyjazdu']) ? $_POST['godzina_przyjazdu'] : '', time() + (86400 * 3), "/");
    setcookie('dodatkowe_lozko', isset($_POST['dodatkowe_lozko']) ? $_POST['dodatkowe_lozko'] : '', time() + (86400 * 3), "/");
    setcookie('udogodnienia', isset($_POST['udogodnienia']) ? implode(',', $_POST['udogodnienia']) : '', time() + (86400 * 3), "/");
    setcookie('liczba_gosci', isset($_POST['liczba_gosci']) ? $_POST['liczba_gosci'] : '', time() + (86400 * 3), "/");
}
?>

<html>
<head>
    <meta charset="utf-8">
    <title>Rezerwacja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container mt-3 p-5 my-5">
    <form  action="rezerwacja.php" method="post">
        <div class="mb-3">
            <label for="liczba_gosci">Wybierz ilość gości</label>
            <select name="liczba_gosci" id="liczba_gosci" class="form-select" required>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="imie">Imię</label>
            <input type="text" name="imie" id="imie" class="form-control" required value="<?php echo $imie; ?>">
        </div>
        <div class="mb-3">
            <label for="nazwisko">Nazwisko</label>
            <input type="text" name="nazwisko" id="nazwisko" class="form-control" required value="<?php echo $nazwisko; ?>">
        </div>
        <div class="mb-3">
            <label for="email">E-mail</label>
            <input type="email" name="email" id="email" class="form-control" required value="<?php echo $email; ?>">
        </div>
        <div class="mb-3">
            <label for="adres">Adres</label>
            <input type="text" name="adres" id="adres" class="form-control" required value="<?php echo $adres; ?>">
        </div>
        <div class="mb-3">
            <label for="numer_telefonu">Numer telefonu</label>
            <input type="text" name="numer_telefonu" id="numer_telefonu" class="form-control" pattern="[0-9]{9}" title="Podaj prawidłowy numer telefonu" required value="<?php echo $numer_telefonu; ?>">
        </div>
        <div class="mb-3">
            <label for="numer_karty">Numer karty kredytowej</label>
            <input type="text" name="numer_karty" id="numer_karty" class="form-control" pattern="[0-9]{16}" title="Numer karty musi mieć 16 znaków" required value="<?php echo $numer_karty; ?>">
        </div>
        <div class="mb-3">
            <label for="data_przyjazdu">Data przyjazdu</label>
            <input type="date" name="data_przyjazdu" id="data_przyjazdu" class="form-control" required value="<?php echo $data_przyjazdu; ?>">
        </div>
        <div class="mb-3">
            <label for="data_wyjazdu">Data wyjazdu</label>
            <input type="date" name="data_wyjazdu" id="data_wyjazdu" class="form-control" required value="<?php echo $data_wyjazdu; ?>">
        </div>
        <div class="mb-3">
            <label for="godzina_przyjazdu">Godzina przyjazdu</label>
            <input type="time" name="godzina_przyjazdu" id="godzina_przyjazdu" class="form-control" required value="<?php echo $godzina_przyjazdu; ?>">
        </div>
        <div class="mb-3">
            <label>Potrzebujesz aby dostawić łóżko dla dziecka?</label> </br>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="dodatkowe_lozko" id="lozko_tak" value="tak" <?php if($dodatkowe_lozko == 'tak') echo 'checked'; ?>>
                <label class="form-check-label" for="lozko_tak">Tak</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="dodatkowe_lozko" id="lozko_nie" value="nie" <?php if($dodatkowe_lozko == 'nie') echo 'checked'; ?>>
                <label class="form-check-label" for="lozko_nie">Nie</label>
            </div>
        </div>
        <div class="mb-3">
            <label>Dodatkowe udogodnienia:</label> </br>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="udogodnienia[]" id="popielniczka" value="popielniczka" <?php if(strpos($udogodnienia, 'popielniczka') !== false) echo 'checked'; ?>>
                <label class="form-check-label" for="popielniczka">Popielniczka</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="udogodnienia[]" id="klimatyzacja" value="klimatyzacja" <?php if(strpos($udogodnienia, 'klimatyzacja') !== false) echo 'checked'; ?>>
                <label class="form-check-label" for="klimatyzacja">Klimatyzacja</label>
            </div>
        </div>
        <input type="submit" value="przejdź dalej" class="btn btn-primary">
    </form>
    <form action="rez.php" method="post">
        <input type="hidden" name="clear_cookies" value="true">
        <input type="submit" value="Wyczyść formularz" class="btn btn-danger">
    </form>
</div>
</body>
</html>
