<?php
function fibonacci_i($n){
    $tab=array();
    $a=0;
    $b=1;
    for($i=0;$i<$n;$i++){
        $tab[]=$a;
        $next=$a+$b;
        $a=$b;
        $b=$next;
    }
    return $tab;
}
function fibonacci_r($n)
{
    if ($n == 0) return 0;
    if ($n == 1) return 1;
    return fibonacci_r($n-1)+fibonacci_r($n-2);
}
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $zakres = $_POST['num'];

    $start_i = microtime(true);
    $fib_i = fibonacci_i($zakres);
    $stop_i = microtime(true);
    $czas_i = $stop_i - $start_i;

    $start_r = microtime(true);
    $fib_r = array();
    for ($i=0; $i<$zakres;$i++){
        $fib_r[]= fibonacci_r($i);
    }
    $stop_r = microtime(true);
    $czas_r = $stop_r - $start_r;
    echo "Czas wykonania iteracyjnie:" . number_format($czas_i, 5) . " sekund </br>";
    echo "Czas wykonania rekurencyjnie:" . number_format( $czas_r, 5 ) ."sekund </br>";
    $roznica = $czas_r - $czas_i;
    echo "roznica pomiedzy czasami wynosi: ". number_format($roznica, 5) ."</br>";
    if ($czas_r>$czas_i) {
        echo "szybsza byla funkcja iteracyjna </br>";
    } elseif ($czas_i>$czas_r){
        echo "szybsza byla funkcja rekurencyjna </br>";
    }
}
