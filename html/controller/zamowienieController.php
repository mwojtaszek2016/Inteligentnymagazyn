<?php
class zamowienieController extends baseController {
    //POBRANIE I WYSWIETLENIE LISTY WSZYSTKICH ZAMOWIEN (DLA ADMINA)
    public function index() {
        $this->ograniczDostepTylkoDlaAdmina();
        $db = $this->registry->db;
        $results = $db::getZamowienieList();
        $zamowienia = array();
        foreach ($results as $row) {
            $zamowienie = new Zamowienie();
            $zamowienie->setIdZamowienia($row['id_zamowienia']);
            $zamowienie->setIdOperatora($row['id_operatora']);
            $zamowienie->setStanowisko($row['stanowisko']);
            $zamowienie->setUwagi($row['uwagi_dodatkowe']);
            $narzedzia = $db::getNarzedziaZamowienia($row['id_zamowienia']);
            $zamowienie->setNarzedzia($narzedzia);
            $waga = 0.0;
            foreach ($narzedzia as $narzedzie) {
                $waga += $narzedzie->getIlosc() * $narzedzie->getNarzedzie()->getWaga();
            }
            $zamowienie->setWaga($waga);
            $zamowienie->setDataZamowienia($row['data_zamowienia']);
            $zamowienie->setDataRealizacji($row['data_realizacji']);
            $zamowienie->setStatus($row['status']);
            $zamowienia[] = $zamowienie;
        }
        $this->registry->template->zamowienia = $zamowienia;
        $this->registry->template->show('zamowienie/zamowienie_index');
    }

    //POBANIE I WYSWIETLENIE ZAMOWIEN ZALOGOWANEGO ZWYKLEGO UZYTKOWNIKA
    public function moje_zamowienia() {
        $this->ograniczDostepTylkoDlaZalogowanegoUzytkownika();
        $db = $this->registry->db;
        $login = $_SESSION['user'];
        $user = $db::getUserByLogin($login);
        $results = $db::getZamowienieUserList($user->getId());
        $zamowienia = array();
        foreach ($results as $row) {
            $zamowienie = new Zamowienie();
            $zamowienie->setIdZamowienia($row['id_zamowienia']);
            $zamowienie->setIdOperatora($row['id_operatora']);
            $zamowienie->setStanowisko($row['stanowisko']);
            $zamowienie->setUwagi($row['uwagi_dodatkowe']);
            $narzedzia = $db::getNarzedziaZamowienia($row['id_zamowienia']);
            $zamowienie->setNarzedzia($narzedzia);
            $waga = 0.0;
            foreach ($narzedzia as $narzedzie) {
                $waga += $narzedzie->getIlosc() * $narzedzie->getNarzedzie()->getWaga();
            }
            $zamowienie->setWaga($waga);
            $zamowienie->setDataZamowienia($row['data_zamowienia']);
            $zamowienie->setDataRealizacji($row['data_realizacji']);
            $zamowienie->setStatus($row['status']);
            $zamowienia[] = $zamowienie;
        }
        $this->registry->template->zamowienia = $zamowienia;
        $this->registry->template->show('zamowienie/zamowienie_indexUser');
    }

    //DODANIE NOWEGO ZAMOWIENIA
    public function add() {
        $this->ograniczDostepTylkoDlaZalogowanegoUzytkownika();
        $error = "";
        $success = "";
        $db = $this->registry->db;
        $narzedzia = array();
        $ilosci = array();
        if (isset($_SESSION['PelenRobot'])) {          
            foreach ($_SESSION['PelenRobot'] as $idNarzedzia => $ilosc) {
                $narzedzie = $db::getNarzedzieById($idNarzedzia);
                $narzedzia[] = $narzedzie;
                $ilosci[] = $ilosc;
            }
            $user = $db::getUserByLogin($_SESSION['user']);
            $stanowisko = $user->getStanowisko();
            $this->registry->template->stanowisko = $stanowisko;
            $this->registry->template->narzedzia = $narzedzia;
            $this->registry->template->ilosci = $ilosci;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $stanowisko = trim($_POST['stanowisko']);
            if (empty($stanowisko)) {
                $error .= 'Uzupełnij pole stanowisko <br />';
            }
            $uwagi = trim($_POST['uwagi']);

            if (empty($error)) {
                for ($i = 0; $i < count($narzedzia); $i++) {
                    $p = $narzedzia[$i];
                    $il = $ilosci[$i];
                    $NarzedzieZamowienia = new NarzedzieZamowienia();
                    $NarzedzieZamowienia->setIlosc($il);
                    $NarzedzieZamowienia->setNarzedzia($p);
                    $NarzedzieZamowienia->setIdNarzedzia($p->getIdNarzedzia());
                    $narzedziaZ[] = $narzedzieZamowienia;
                }

                $zamowienie = new Zamowienie();
                $zamowienie->setNarzedzia($narzedziaZ);
                $waga = 0.0;
                foreach ($narzedziaZ as $p) {
                    $waga += $p->getNarzedzie()->getWaga() * $p->getIlosc();
                }
                $zamowienie->setWaga($waga);
                $zamowienie->setStatus("nowe");
                $zamowienie->setUwagi($uwagi);
                $zamowienie->setStanowisko($stanowisko);
                $user = $db::getUserByLogin($_SESSION['user']);
                $userId = $user->getId();
                $zamowienie->setIdOperatora($userId);
                if ($db::addZamowienie($zamowienie)) {
                    $success .= 'Dodano zamowienie <br />';
                    unset($_SESSION['RobotPelny']);
                    unset($_SESSION['calkowita_waga']);
                    unset($_SESSION['waga']);
                } else {
                    $error .= 'Dodanie zamowienia nie powiodło się <br />';
                }
            }
            $this->registry->template->success = $success;
            $this->registry->template->error = $error;
        }
        $this->registry->template->show('zamowienie/zamowienie_add');
    }

    //USUNIECIE ZAMOWIENIA
    public function delete() {
        $this->ograniczDostepTylkoDlaAdmina();
        $db = $this->registry->db;
        $error = "";
        $success = "";
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['delete'])) {
                $id = trim($_POST['id']);
                $zamowienie = $db::getZamowienieById($id);
                if ($db::deleteZamowienie($zamowienie)) {
                    $success .= 'Usunięto zamówienie <br />';
                } else {
                    $error .= 'Usuwanie nie powiodło się <br />';
                }
            } else {
                $location = '/' . APP_ROOT . '/zamowienie';
                header("Location: $location");
            }
            $this->registry->template->error = $error;
            $this->registry->template->success = $success;
            $this->registry->template->show('zamowienie/zamowienie_action_result');
        } else {
            $id = $this->registry->id;
            $zamowienie = $db::getZamowienieById($id);
            $this->registry->template->model = $zamowienie;
            $this->registry->template->show('zamowienie/zamowienie_delete');
        }
    }

    //ZREALIZOWANIE (WYSLANIE) ZAMOWIENIA
    public function realize() {
        $this->ograniczDostepTylkoDlaAdmina();
        $db = $this->registry->db;
        $error = "";
        $success = "";
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['realize'])) {
                $id = trim($_POST['id']);
                $zamowienie = $db::getZamowienieById($id);
                $zamowienie->setStatus("Zrealizowane");
                if ($db::realizeZamowienie($zamowienie)) {
                    $success .= 'Wysłano zamówienie <br />';
                } else {
                    $error .= 'Realizacja nie powiodła się <br />';
                }
            } else {
                $location = '/' . APP_ROOT . '/zamowienie';
                header("Location: $location");
            }
            $this->registry->template->error = $error;
            $this->registry->template->success = $success;
            $this->registry->template->show('zamowienie/zamowienie_action_result');
        } else {
            $id = $this->registry->id;
            $zamowienie = $db::getZamowienieById($id);
            $this->registry->template->model = $zamowienie;
            $this->registry->template->show('zamowienie/zamowienie_realize');
        }} } ?>