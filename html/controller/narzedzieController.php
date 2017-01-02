<?php

class narzedzieController extends baseController {

    public function index() {
        //$this->ograniczDostepTylkoDlaAdmina();
        $db = $this->registry->db;
        $results = $db::getNarzedzieList();
        $narzedzia = array();
        foreach ($results as $row) {
            $narzedzie = new Narzedzia();
            $narzedzie->setIdNarzedzia($row['id_narzedzia']);
            $narzedzie->setNazwa($row['nazwa']);
            $narzedzie->setWaga($row['waga']);
            $narzedzie->setOpis($row['opis']);
            $narzedzie->setIdKategorii($row['id_kategorii']);
            $kategoria = $db::getKategoriaById($row['id_kategorii']);
            $narzedzie->setKategoria($kategoria);
            $narzedzia[] = $narzedzie;
        }
        $kategorie = array();
        $results = $db::getKategoriaList();
        foreach ($results as $row) {
            $kategoria = new Kategoria();
            $kategoria->setIdKategorii($row['id_kategorii']);
            $kategoria->setNazwa($row['nazwa']);
            $kategorie[] = $kategoria;
        }
        $this->registry->template->narzedzia = $narzedzia;
        $this->registry->template->kategorie = $kategorie;
        $this->registry->template->show('narzedzie/narzedzie_index');
    }



    public function add() {
        $this->ograniczDostepTylkoDlaAdmina();
        $error = "";
        $success = "";
        $db = $this->registry->db;
        $kategorieList = $db::getKategoriaList();
        $this->registry->template->kategorie = $kategorieList;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nazwa = trim($_POST['nazwa']);
            if (empty($nazwa)) {
                $error .= 'Uzupełnij pole nazwa <br />';
            }
            $waga = trim($_POST['waga']);
            if (empty($waga)) {
                $error .= 'Uzupełnij pole waga <br />';
            }
            $idKategorii = $_POST['kategoria'];
            if (empty($idKategorii)) {
                $error .= 'Wybierz pole kategoria <br />';
            }
            $opis = trim($_POST['opis']);
            if (empty($error)) {
                $narzedzia = new Narzedzia();
                $narzedzia->setNazwa($nazwa);
                $narzedzia->setWaga($waga);
                $narzedzia->setIdKategorii($idKategorii);
                $narzedzia->setOpis($opis);
                if ($db::addNarzedzie($narzedzia)) {
                    $success .= 'Dodano narzedzie <br />';
                } else {
                    $error .= 'Dodanie narzedzia nie powiodło się <br />';
                }
            }

            $this->registry->template->error = $error;
            $this->registry->template->success = $success;
        }

        $this->registry->template->show('narzedzie/narzedzie_add');
    }

    public function edit() {
        $this->ograniczDostepTylkoDlaAdmina();
        $error = "";
        $success = "";
        $db = $this->registry->db;
        $kategorieList = $db::getKategoriaList();
        $this->registry->template->kategorieAll = $kategorieList;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = trim($_POST['id']);
            if (empty($id)) {
                $error .= 'Błąd <br />';
            }
            $nazwa = trim($_POST['nazwa']);
            if (empty($nazwa)) {
                $error .= 'Uzupełnij pole nazwa <br />';
            }
            $waga = trim($_POST['waga']);
            if (empty($waga)) {
                $error .= 'Uzupełnij pole waga <br />';
            }
            $idKategorii = $_POST['kategoria'];
            if (empty($idKategorii)) {
                $error .= 'Wybierz pole kategoria <br />';
            }
            $opis = trim($_POST['opis']);
            if (empty($error)) {
                $narzedzie = new Narzedzia();
                $narzedzie->setIdNarzedzia($id);
                $narzedzie->setNazwa($nazwa);
                $narzedzie->setWaga($waga);
                $narzedzie->setIdKategorii($idKategorii);
                $narzedzie->setOpis($opis);
                if ($db::updateNarzedzie($narzedzie)) {
                    $success .= 'Edycja zakończona pomyślnie <br />';
                } else {
                    $error .= 'Edycja nie powiodła się <br />';
                }
            }
            $this->registry->template->error = $error;
            $this->registry->template->success = $success;
            $this->registry->template->show('narzedzie/narzedzie_action_result');
        } else {
            $id = $this->registry->id;
            $narzedzie = $db::getNarzedzietById($id);
            $this->registry->template->model = $narzedzie;
            $this->registry->template->show('narzedzie/narzedzie_edit');
        }
    }

    public function delete() {
        $this->ograniczDostepTylkoDlaAdmina();
        $db = $this->registry->db;
        $error = "";
        $success = "";
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['delete'])) {
                $id = trim($_POST['id']);
                $narzedzie = $db::getNarzedzietById($id);
                if ($db::deleteNarzedzie($narzedzie)) {
                    $success .= 'Usunięto narzedzie <br />';
                } else {
                    $error .= 'Usuwanie nie powiodło się <br />';
                }
            } else {
                $location = '/' . APP_ROOT . '/narzedzie';
                header("Location: $location");
            }
            $this->registry->template->error = $error;
            $this->registry->template->success = $success;
            $this->registry->template->show('narzedzie/narzedzie_action_result');
        } else {
            $id = $this->registry->id;
            $narzedzie = $db::getNarzedzieById($id);
            $this->registry->template->model = $narzedzie;
            $this->registry->template->show('narzedzie/narzedzie_delete');
        }
    }

}

?>