<?php
function fibonacci($n){
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
$zakres=10;
$fib=fibonacci($zakres);
for($i=0;$i<count($fib);$i++){

    if($fib[$i]%2!=0){
        echo ($i+1). '. '. $fib[$i]."\n";
    }
}