<?php
function czy_pierwsza($n){
    if($n<2)
    {
        return false;
    }
    for($i=2; $i*$i<=$n;$i++){
        if($n%$i==0) {
            return false;
        }
    }
    return true;
}
$zakres_start=0;
$zakres_koniec=30;
    for($i=$zakres_start;$i<$zakres_koniec;$i++){
        if(czy_pierwsza($i)){
            echo "$i\n";
        }
    }
