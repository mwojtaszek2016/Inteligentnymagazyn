<?php
class Robot {
    //atrybuty
    private $idRobota;
    private $nazwa;
    //pobierz ID
    public function getIdRobota() {
        return $this->idRobota;
    }
    //pobierz nazwę
    public function getNazwa() {
        return $this->nazwa;
    }
    //ustaw ID
    public function setIdRobota($idRobota) {
        $this->idRobota = $idRobota;
    }
    //ustaw nazwę
    public function setNazwa($nazwa) {
        $this->nazwa = $nazwa;
    }
}
?>