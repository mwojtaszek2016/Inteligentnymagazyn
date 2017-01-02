<?php
class RobotyController extends baseController {
    //LISTA ROBOTÓW
    public function index() {
        $this->ograniczDostepTylkoDlaAdmina();
        $db = $this->registry->db;
        $this->registry->template->results = $db::getRobotList();
        $this->registry->template->show('roboty/roboty_index');
    }
    //DODANIE NOWEGO ROBOTA
    public function add() {
        $this->ograniczDostepTylkoDlaAdmina();
        $error = "";
        $success = "";
        $db = $this->registry->db;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nazwa = trim($_POST['nazwa']);
            if (empty($nazwa)) {
                $error .= 'Uzupełnij pole nazwa <br />';
            }
            if (empty($error)) {
                $robot = new Robot();
                $robot->setNazwa($nazwa);
                if ($db::addRobot($robot)) {
                    $success .= 'Dodano robota <br />';
                } else {
                    $error .= 'Dodanie robota nie powiodło się <br />';
                }
            }
            $this->registry->template->error = $error;
            $this->registry->template->success = $success;
        }
        $this->registry->template->show('roboty/roboty_add');
    }
    //EDYCJA ROBOTA
    public function edit() {
        $this->ograniczDostepTylkoDlaAdmina();
        $error = "";
        $success = "";
        $db = $this->registry->db;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nazwa = trim($_POST['nazwa']);
            if (empty($nazwa)) {
                $error .= 'Uzupełnij pole nazwa <br />';
            }
            if (empty($error)) {
                $robot = new Robot();
                $id = trim($_POST['id']);
                $robot->setIdRobota($id);
                $robot->setNazwa($nazwa);
                if ($db::updateRobot($robot)) {
                    $success .= 'Edycja zakończona pomyślnie <br />';
                } else {
                    $error .= 'Edycja nie powiodła się <br />';
                }
            }
            $this->registry->template->success = $success;
            $this->registry->template->error = $error;
        } else {
            $id = $this->registry->id;

            $robot = $db::getRobotById($id);
            $this->registry->template->model = $robot;
        }
        $this->registry->template->show('roboty/roboty_edit');
    }
    //USUNIĘCIE ROBOTA
    public function delete() {
        $this->ograniczDostepTylkoDlaAdmina();
        $db = $this->registry->db;
        $error = "";
        $success = "";
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['delete'])) {
                $robot = new Robot();
                $id = trim($_POST['id']);
                $robot->setIdRobota($id);
                if ($db::deleteRobot($robot)) {
                    $success .= 'Usunięto robota <br />';
                } else {
                    $error .= 'Usuwanie nie powiodło się. Robot może być aktualnie używanydo transportu narzedzia. <br />';
                }
            } else {
                $location = '/' . APP_ROOT . '/roboty';
                header("Location: $location");
            }
            $this->registry->template->success = $success;
            $this->registry->template->error = $error;
            $this->registry->template->show('roboty/roboty_action_result');
        } else {
            $id = $this->registry->id;
            $robot = $db::getRobotById($id);
            $this->registry->template->model = $robot;
            $this->registry->template->show('roboty/roboty_delete');
        }
    }

}

?>