<?php

class NarzedziaZamowienia {
    private $idZamowienia;
    private $idNarzedzia;
    private $ilosc;



    private $narzedzie;
    private $zamowienie;
    
    public function getIdZamowienia() {
        return $this->idZamowienia;
    }

    public function getIdNarzedzia() {
        return $this->idNarzedzia;
    }

    public function getIlosc() {
        return $this->ilosc;
    }


    public function getNarzedzie() {
        return $this->narzedzie;
    }

    public function getZamowienie() {
        return $this->zamowienie;
    }

    public function setIdZamowienia($idZamowienia) {
        $this->idZamowienia = $idZamowienia;
    }

    public function setIdNarzedzia($idNarzedzia) {
        $this->idNarzedzia = $idNarzedzia;
    }

    public function setIlosc($ilosc) {
        $this->ilosc = $ilosc;
    }


    public function setNarzedzie($narzedzie) {
        $this->narzedzie = $narzedzie;
    }

    public function setZamowienie($zamowienie) {
        $this->zamowienie = $zamowienie;
    }


    

}
