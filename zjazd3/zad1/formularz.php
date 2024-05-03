<?php

if(isset($_GET['data'])) {
    $data = $_GET['data'];
    function dzien_tygodnia($data)
    {
        $numer_dnia = date('N', strtotime($data));
        $nazwy_dni = array('poniedziałek', 'wtorek', 'środa', 'czwartek', 'piątek', 'sobota', 'niedziela');
        return $nazwy_dni[$numer_dnia - 1];

    }

    echo "<p> uzytkownik urodził się w dniu: " . dzien_tygodnia($data);
    function ukonczone_lata($data)
    {
        $rok_urodzenia=date('Y',strtotime($data));
        $aktualny_rok=date('Y');

        $wiek = $aktualny_rok - $rok_urodzenia;
        return $wiek;
    }
    echo "<p> uzytkownik ma " . ukonczone_lata($data) . "lat </p>";
    function ilosc_dni($data)
    {
        $aktualny_dzien=date('j');
        $aktualny_miesiac=date('n');
        $aktualny_rok=date('Y');
        $dzien_urodzenia =date('j', strtotime($data));
        $miesiac_urodzenia =date('n', strtotime($data));
        $rok_nastepnych_urodzin = $aktualny_rok;
        if ($miesiac_urodzenia == $aktualny_miesiac && $dzien_urodzenia == $aktualny_dzien) {
            return 0;
        }
        if ($miesiac_urodzenia < $aktualny_miesiac || ($miesiac_urodzenia == $aktualny_miesiac && $dzien_urodzenia < $aktualny_dzien)) {
            $rok_nastepnych_urodzin = $aktualny_rok + 1;
        }
        $czas1 =  mktime(0,0,0,$aktualny_miesiac,$aktualny_dzien,$aktualny_rok);
        $czas2 = mktime(0,0,0,$miesiac_urodzenia,$dzien_urodzenia,$rok_nastepnych_urodzin);
        $czas = ceil(abs(($czas2 - $czas1) / 86400));
        return $czas;
    }
    echo "<p> Do twoich urodzin pozostalo: " . ilosc_dni($data) . "dni</p>";
}

else{
    echo "nie podano daty";
}
?>