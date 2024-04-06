<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $operacja = $_POST["dzialanie"];
    $num1 = $_POST["l1"];
    $num2 = $_POST["l2"];
    switch ($operacja) {
        case "dodawanie":
            $wynik = $num1+$num2;
            echo "wynik: $wynik";
            break;
        case "odejmowanie":
            $wynik = $num1-$num2;
            echo "wynik: $wynik";
            break;
        case "mnozenie":
            $wynik = $num1*$num2;
            echo "wynik: $wynik";
            break;
        case "dzielenie":
            if ($num2 !=0){
            $wynik = $num1/$num2;
            echo "wynik: $wynik";
            }else {
                echo "nie dziel przez 0";
            }
            break;
        default:
            echo "niepoprawne dzialanie wybrane";
    }
}