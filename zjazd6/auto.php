<?php
class noweAuto {
    private $model;
    private $cenaEuro;
    private $kursEuroPln;

    public function __construct($model, $cenaEuro, $kursEuroPln)
    {
        $this->model = $model;
        $this->cenaEuro = $cenaEuro;
        $this->kursEuroPln = $kursEuroPln;
    }
    public function getModel()
    {
        return $this->model;
    }
    public function setModel($model): void
    {
        $this->model = $model;
    }
    public function getCenaEuro()
    {
        return $this->cenaEuro;
    }
    public function setCenaEuro($cenaEuro): void
    {
        $this->cenaEuro = $cenaEuro;
    }
    public function getKursEuroPln()
    {
        return $this->kursEuroPln;
    }
    public function setKursEuroPln($kursEuroPln): void
    {
        $this->kursEuroPln = $kursEuroPln;
    }

    public function obliczCene(){
        return $this->cenaEuro * $this->kursEuroPln;
    }
}
class AutoZDotatkami extends noweAuto {
    private $alarm;
    private $radio;
    private $klimatyzacja;

    public function __construct($model, $cenaEuro, $kursEuroPln, $alarm, $radio, $klimatyzacja) {
        parent::__construct($model, $cenaEuro, $kursEuroPln);
        $this->alarm = $alarm;
        $this->radio = $radio;
        $this->klimatyzacja = $klimatyzacja;
    }

    /**
     * @return mixed
     */
    public function getAlarm()
    {
        return $this->alarm;
    }

    /**
     * @param mixed $alarm
     */
    public function setAlarm($alarm): void
    {
        $this->alarm = $alarm;
    }

    /**
     * @return mixed
     */
    public function getRadio()
    {
        return $this->radio;
    }

    /**
     * @param mixed $radio
     */
    public function setRadio($radio): void
    {
        $this->radio = $radio;
    }

    /**
     * @return mixed
     */
    public function getKlimatyzacja()
    {
        return $this->klimatyzacja;
    }

    /**
     * @param mixed $klimatyzacja
     */
    public function setKlimatyzacja($klimatyzacja): void
    {
        $this->klimatyzacja = $klimatyzacja;
    }
    public function obliczCene(){
        $cenaEuroZDodatkami = $this->getCenaEuro() + $this->alarm + $this->radio + $this->klimatyzacja;
        return $cenaEuroZDodatkami * $this->getKursEuroPln();
    }
}

class Ubezpieczenie extends AutoZDodatkami
{
    private $procentowaWartoscUbezpieczenia;
    private $liczbaLat;

    public function __construct($model, $cenaEuro, $kursEuroPln, $alarm, $radio, $klimatyzacja, $procentowaWartoscUbezpieczenia, $liczbaLat)
    {
        parent::__construct($model, $cenaEuro, $kursEuroPln, $alarm, $radio, $klimatyzacja);
        $this->procentowaWartoscUbezpieczenia = $procentowaWartoscUbezpieczenia;
        $this->liczbaLat = $liczbaLat;
    }

    public function getProcentowaWartoscUbezpieczenia()
    {
        return $this->procentowaWartoscUbezpieczenia;
    }

    public function setProcentowaWartoscUbezpieczenia($procentowaWartoscUbezpieczenia)
    {
        $this->procentowaWartoscUbezpieczenia = $procentowaWartoscUbezpieczenia;
    }

    public function getLiczbaLat()
    {
        return $this->liczbaLat;
    }

    public function setLiczbaLat($liczbaLat)
    {
        $this->liczbaLat = $liczbaLat;
    }

    public function obliczCene()
    {
        $wartoscSamochodu = parent::obliczCene();
        $wartoscUbezpieczenia = $this->procentowaWartoscUbezpieczenia * ($wartoscSamochodu * ((100 - $this->liczbaLat) / 100));
        return $wartoscUbezpieczenia;
    }
}
