<?php

function pierwsza($liczba) {
    $iteracje = 0;
    if ($liczba < 2) return 0;
    $p = sqrt($liczba);
    for ($i = 2; $i <= $p; $i++) {
        if (($liczba % $i) == 0) return $iteracje;
        $iteracje++;
    }
    return $iteracje;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $liczba =$_POST['l1'];
        $iteracje = pierwsza($liczba);
        if ($iteracje !== false) {
            echo 'Liczba ' . $liczba . ' jest liczbą pierwszą';
        } else {
            echo 'Liczba ' . $liczba . ' nie jest liczbą pierwszą';
        }
        echo "<br>Liczba iteracji: $iteracje";
    } else {
        echo 'Podana wartość nie jest poprawną liczbą całkowitą dodatnią';
    }

?>
