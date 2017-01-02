<?php

class Zamowienie {
	private $idZamowienia;
	private $idOperatora;
        private $waga;
	private $dataZamowienia;
	private $dataRealizacji;
	private $status;  //nowe, zaplacone, zrealizowane     
        private $narzedzia;
        private $stanowisko;
        private $uwagi;
        
        public function getWaga() {
            return $this->waga;
        }

        public function setWaga($waga) {
            $this->waga = $waga;
        }

                
        public function getStanowisko() {
            return $this->stanowisko;
        }

        public function getUwagi() {
            return $this->uwagi;
        }

        public function setStanowisko($stanowisko) {
            $this->stanowisko = $stanowisko;
        }

        public function setUwagi($uwagi) {
            $this->uwagi = $uwagi;
        }

                public function getIdZamowienia() {
            return $this->idZamowienia;
        }

        public function getIdOperatora() {
            return $this->idOperatora;
        }
        
        public function getDataZamowienia() {
            return $this->dataZamowienia;
        }

        public function getDataRealizacji() {
            return $this->dataRealizacji;
        }

        public function getStatus() {
            return $this->status;
        }

        public function getNarzedzia() {
            return $this->narzedzia;
        }

        public function setIdZamowienia($idZamowienia) {
            $this->idZamowienia = $idZamowienia;
        }

        public function setIdOperatora($idOperatora) {
            $this->idOperatora = $idOperatora;
        }

        public function setDataZamowienia($dataZamowienia) {
            $this->dataZamowienia = $dataZamowienia;
        }

        public function setDataRealizacji($dataRealizacji) {
            $this->dataRealizacji = $dataRealizacji;
        }

        public function setStatus($status) {
            $this->status = $status;
        }

        public function setNarzedzia($narzedzia) {
            $this->narzedzia = $narzedzia;
        }
}
?>