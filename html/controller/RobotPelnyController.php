<?php
class RobotPelnyController extends baseController {
    //WYSWIETLENIE ZAWRTOSCI ROBOTA Z ZAMOWIENIEM
    public function index() {
        $this->ograniczDostepTylkoDlaZalogowanegoUzytkownika();
        $narzedzia = array();
        $ilosci = array();
        $calk_ilosc = 0;
        $waga = 0;
        if (isset($_SESSION['RobotPelny']) && isset($_SESSION['calkowita_ilosc']) && isset($_SESSION['waga'])) {
            $db = $this->registry->db;
            foreach ($_SESSION['RobotPelny'] as $idNarzedzia => $ilosc) {
                $narzedzie = $db::getNarzedzieById($idNarzedzia);
                $waga = $_SESSION['waga'];
                $calk_ilosc = $_SESSION['calkowita_ilosc'];
                $narzedzia[] = $narzedzie;
                $ilosci[] = $ilosc;
            }
        }
        $this->registry->template->narzedzia = $narzedzia;
        $this->registry->template->ilosci = $ilosci;
        $this->registry->template->calkowita_ilosc = $calk_ilosc;
        $this->registry->template->wartosc = $waga;
        $this->registry->template->show('RobotPelny/RobotPelny_index');
    }

    //ODSWIEZENIE ZAWARTOSCI ZAMOWIENIA NA ROBOCIE(PRZELICZENIE ILOSCI ORAZ WAGI )
    private function refreshShoppingCart() {
        $calkowita_ilosc = 0;
        $waga = 0;
        if (isset($_SESSION['RobotPelny']) && isset($_SESSION['calkowita_ilosc']) && isset($_SESSION['waga'])) {
            $db = $this->registry->db;
            foreach ($_SESSION['RobotPelny'] as $idNarzedzia => $ilosc) {
                $narzedzie = $db::getNarzedzieById($idNarzedzia);
                $calkowita_ilosc += $ilosc;
                $waga += $ilosc * $narzedzie->getWaga();
            }
        }
        $_SESSION['calkowita_ilosc'] = $calkowita_ilosc;
        $_SESSION['waga'] = $waga;
    }

    //DODANIE NARZEDZIA DO ROBOTA LADUNKOWEGO
    public function add() {
        $this->ograniczDostepTylkoDlaZalogowanegoUzytkownika();
        $idNarzedzia = $this->registry->id;
        if (!isset($_SESSION['RobotPelny']) || !isset($_SESSION['calkowita_ilosc']) || !isset($_SESSION['waga'])) {
            $_SESSION['RobotPelny'] = array();
            $_SESSION['calkowita_ilosc'] = 0;
            $_SESSION['waga'] = 0;
        }
        if (isset($_SESSION['RobotPelny'][$idNarzedzia])) {
            $_SESSION['RobotPelny'][$idNarzedzia] ++;
        } else {
            $_SESSION['RobotPelny'][$idNarzedzia] = 1;
        }
        $this->refreshShoppingCart();
        $location = '/' . APP_ROOT . '/RobotPelny';
        header("Location: $location");
    }

    //EDYCJA ZAWRTOSCI ZALADOWANEGO ROBOTA
    public function edit() {
        $this->ograniczDostepTylkoDlaZalogowanegoUzytkownika();
        if (isset($_SESSION['RobotPelny'])) {
            foreach ($_SESSION['RobotPelny'] as $idNarzedzia => $ilosc) {
                if (isset($_POST[$idNarzedzia])) {
                    var_dump($_POST);
                    $nowaIlosc = $_POST[$idNarzedzia];
                    if ($nowaIlosc < 0)
                        continue;
                    if ($nowaIlosc == 0) {
                        unset($_SESSION['RobotPelny'][$idNarzedzia]);
                    } else {
                        $_SESSION['RobotPelny'][$idNarzedzia] = $nowaIlosc;
                    }
                }
            }
            $this->refreshShoppingCart();
        }
        $location = '/' . APP_ROOT . '/RobotPelny';
        header("Location: $location");
    }

    //USUNIECIE NARZEDZIA Z ZALADOWANEGO ROBOTA
    public function delete() {
        $this->ograniczDostepTylkoDlaZalogowanegoUzytkownika();
        $idNarzedzia = $this->registry->id;

        if (isset($_SESSION['RobotPelny'][$idNarzedzia])) {
            unset($_SESSION['RobotPelny'][$idNarzedzia]);
            $this->refreshShoppingCart();
        }
        $location = '/' . APP_ROOT . '/RobotPelny';
        header("Location: $location");
    }
}
?>