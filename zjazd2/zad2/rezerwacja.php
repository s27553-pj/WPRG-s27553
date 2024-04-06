<html>
<head>
    <meta charset="UTF-8">
    <title>Podsumowanie</title>
</head>
<body>
<?php
$liczba_gosci =$_POST['liczba_gosci'];
$imie =$_POST['imie'];
$nazwisko=$_POST['nazwisko'];
$adres=$_POST['adres'];
$numer_karty =$_POST['numer_karty'];
$email =$_POST['email'];
$data_przyjazdu =$_POST['data_przyjazdu'];
$data_wyjazdu =$_POST['data_wyjazdu'];
$godzina_przyjazdu =$_POST['godzina_przyjazdu'];
$dodatkowe_lozko =isset($_POST['dodatkowe_lozko']) ? "Tak" : "Nie";
$udogodnienia = isset($_POST['udogodnienia']) ? implode(',',$_POST['udogodnienia']): "brak";
echo "<p>liczba gosci: $liczba_gosci</p>";
echo "<p>Dane osoby rezerwującej:</p>";
echo "<p>imie: $imie <p>";
echo "<p>nazwisko: $nazwisko";
echo "<p>email: $email</p>";
echo "<p>adres: $adres</p>";
echo "<p>numer karty kredytowej: $numer_karty</p>";
echo "<p>data przyjazdu: $data_przyjazdu</p>";
echo "<p>data wyjazdu: $data_wyjazdu</p>";
echo "<p>godzina przyjazdu: $godzina_przyjazdu</p>";
echo "<p>Czy potrzebne łóżko dla dziecka? $dodatkowe_lozko</p>";
echo "<p> Wybrane udogodnienia: $udogodnienia</p>"
?>
</body>
</html>

