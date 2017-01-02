<?php

class Narzedzia {

    private $idNarzedzia;
    private $nazwa;
    private $idKategorii;
    private $opis;
    private $kategoria;
    private $waga;


    public function getKategoria() {
        return $this->kategoria;
    }

    public function setKategoria($kategoria) {
        $this->kategoria = $kategoria;
    }

    public function getIdNarzedzia() {
        return $this->idNarzedzia;
    }

    public function getNazwa() {
        return $this->nazwa;
    }

    
    public function getIdKategorii() {
        return $this->idKategorii;
    }

     public function getWaga() {
        return $this->waga;
    }
   
    public function getOpis() {
        return $this->opis;
    }

    public function setIdNarzedzia($idNarzedzia) {
        $this->idNarzedzia = $idNarzedzia;
    }

    public function setNazwa($nazwa) {
        $this->nazwa = $nazwa;
    }

    public function setIdKategorii($idKategorii) {
        $this->idKategorii = $idKategorii;
    }

     public function setWaga($waga) {
        $this->waga = $waga;
    }
    public function setOpis($opis) {
        $this->opis = $opis;
    }

}

?>