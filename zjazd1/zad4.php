<?php
$tekst = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.";

$separator = " ";
$tablica = explode($separator, $tekst);

// Usuwanie znaków interpunkcyjnych
for ($i = 0; $i < count($tablica); $i++) {
    $ostatniZnak = substr($tablica[$i], -1);
    $znakiInterpunkcyjne = array(",", ".", "'", ";", ":", "?", "!", "(", ")", "[", "]", "{", "}", "<", ">");
    if (in_array($ostatniZnak, $znakiInterpunkcyjne)) {
        unset($tablica[$i]);
        for ($j = $i; $j < count($tablica) - 1; $j++) {
            $tablica[$j] = $tablica[$j + 1];
        }
        unset($tablica[count($tablica) - 1]);
        $i--;
    }
}

$tabAsocjacyjna =array();
for ($i=0;$i<count($tablica);$i+=2) {
    if (isset($tablica[$i + 1])) {
        $tabAsocjacyjna[$tablica[$i]] = $tablica[$i + 1];
    } else {
        $tabAsocjacyjna[$tablica[$i]] = null;
    }
}
    foreach ($tabAsocjacyjna as $klucz => $wartosc) {
        echo $klucz . " => " . $wartosc . "<br>";
    }
