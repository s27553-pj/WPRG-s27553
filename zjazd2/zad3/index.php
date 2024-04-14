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
            <input type="text" name="imie" id="imie" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="nazwisko">Nazwisko</label>
            <input type="text" name="nazwisko" id="nazwisko" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="email">E-mail</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="adres">Adres</label>
            <input type="text" name="adres" id="adres" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="numer_telefonu">Numer telefonu</label>
            <input type="text" name="numer_telefonu" id="numer_telefonu" class="form-control" pattern="[0-9]{9}" title="Podaj prawidłowy numer telefonu" required>
        </div>
        <div class="mb-3">
            <label for="numer_karty">Numer karty kredytowej</label>
            <input type="text" name="numer_karty" id="numer_karty" class="form-control" pattern="[0-9]{16}" title="Numer karty musi mieć 16 znaków" required>
        </div>
        <div class="mb-3">
            <label for="data_przyjazdu">Data przyjazdu</label>
            <input type="date" name="data_przyjazdu" id="data_przyjazdu" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="data_wyjazdu">Data wyjazdu</label>
            <input type="date" name="data_wyjazdu" id="data_wyjazdu" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="godzina_przyjazdu">Godzina przyjazdu</label>
            <input type="time" name="godzina_przyjazdu" id="godzina_przyjazdu" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Potrzebujesz aby dostawić łóżko dla dziecka?</label> </br>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="dodatkowe_lozko" id="lozko_tak" value="tak">
                <label class="form-check-label" for="lozko_tak">Tak</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="dodatkowe_lozko" id="lozko_nie" value="nie">
                <label class="form-check-label" for="lozko_nie">Nie</label>
            </div>
        </div>
        <div class="mb-3">
            <label>Dodatkowe udogodnienia:</label> </br>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="udogodnienia[]" id="popielniczka" value="popielniczka">
                <label class="form-check-label" for="popielniczka">Popielniczka</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="udogodnienia[]" id="klimatyzacja" value="klimatyzacja">
                <label class="form-check-label" for="klimatyzacja">Klimatyzacja</label>
            </div>
        </div>
        <input type="submit" value="przejdź dalej" class="btn btn-primary">
    </form>
</div>
</body>
</html>
