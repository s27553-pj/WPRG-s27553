<?php
$owoce = array("jablko", "banan", "pomarancza");
for ($i = 0; $i < count($owoce); $i++) {
    $odwrot = '';
    for ($j = strlen($owoce[$i]) - 1; $j >= 0; $j--) {
        $odwrot .= $owoce[$i][$j];
    }
    echo $odwrot . "\n";
    if ($owoce[$i][0] === 'p' || $owoce[$i][0] === 'P') {
        echo $owoce[$i] . " zaczyna się na literę p \n";
    }
}
?>
