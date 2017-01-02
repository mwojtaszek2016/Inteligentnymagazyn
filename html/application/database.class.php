<?php
Class Database {

    private static $db;

    public static function getInstance() {
        if (!self::$db) {
            self::$db = new PDO('mysql:host=localhost;dbname=inteligentnymagazyn;charset=utf8', 'root', '');
            return new Database();
        }
    }


    //użytkownicy
    //dodanie użytkownika
    public static function addUser($user) {
        $stmt = self::$db->prepare("INSERT INTO uzytkownik(imie,nazwisko,stanowisko,telefon,email,login,haslo) "
                . "VALUES(:imie,:nazwisko,:stanowisko,:telefon,:email,:login,:haslo)");
        $stmt->execute(array(
            ':imie' => $user->getImie(), ':nazwisko' => $user->getNazwisko(), 
            ':stanowisko' => $user->getStanowisko(),
            ':telefon' => $user->getTelefon(), ':email' => $user->getEmail(),
            ':login' => $user->getLogin(), ':haslo' => sha1($user->getHaslo()))
        );
        $affected_rows = $stmt->rowCount();
        if ($affected_rows == 1) {
            return TRUE;
        }
        return FALSE;
    }
    //pobranie użytkownika po id
    public static function getUserByID($id) {
        $stmt = $db->prepare('SELECT * FROM uzytkownik WHERE id=?');
        $stmt->execute(array($id));
        if ($stmt->rowCount > 0) {
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $result = $results[0];
            $user = new Uzytkownik;
            $user->setId($result['id']);
            $user->setImie($result['imie']);
            $user->setNazwisko($result['nazwisko']);
            $user->setStanowisko($result['stanowisko']);
            $user->setTelefon($result['telefon']);
            $user->setEmail($result['email']);
            $user->setLogin($result['login']);
            $user->setHaslo($result['haslo']);
            $role = self::userRoles($result['login']);
            $user->setRole($role);
            return $user;
        }
    }
    //pobranie użytkownika po loginie i haśle
    public static function getUserByLoginAndPassword($login, $password) {
        $stmt = self::$db->prepare('SELECT * FROM uzytkownik WHERE login=? and haslo=?');
        $stmt->execute(array($login, sha1($password)));
        if ($stmt->rowCount() > 0) {
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $result = $results[0];
            $user = new Uzytkownik();
            $user->setId($result['id']);
            $user->setImie($result['imie']);
            $user->setNazwisko($result['nazwisko']);
            $user->setStanowisko($result['stanowisko']);
            $user->setTelefon($result['telefon']);
            $user->setEmail($result['email']);
            $user->setLogin($result['login']);
            $user->setHaslo($result['haslo']);
            $role = self::userRoles($result['login']);
            $user->setRole($role);
            return $user;
        }
    }
    //pobranie użytkownika o podanym loginie
    public static function getUserByLogin($login) {
        $stmt = self::$db->prepare('SELECT * FROM uzytkownik WHERE login=?');
        $stmt->execute(array($login));
        if ($stmt->rowCount() > 0) {
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $result = $results[0];
            $user = new Uzytkownik();
            $user->setId($result['id']);
            $user->setImie($result['imie']);
            $user->setNazwisko($result['nazwisko']);
            $user->setStanowisko($result['stanowisko']);
            $user->setTelefon($result['telefon']);
            $user->setEmail($result['email']);
            $user->setLogin($result['login']);
            $user->setHaslo($result['haslo']);
            $role = self::userRoles($result['login']);
            $user->setRole($role);
            return $user;
        }
    }
    //pobranie użytkownika o podanym mailu
    public static function getUserByEmail($email) {
        $stmt = self::$db->prepare('SELECT * FROM uzytkownik WHERE email=?');
        $stmt->execute(array($email));
        if ($stmt->rowCount() > 0) {
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $result = $results[0];
            $user = new Uzytkownik();
            $user->setId($result['id']);
            $user->setImie($result['imie']);
            $user->setNazwisko($result['nazwisko']);
            $user->setStanowisko($result['stanowisko']);
            $user->setTelefon($result['telefon']);
            $user->setEmail($result['email']);
            $user->setLogin($result['login']);
            $user->setHaslo($result['haslo']);
            $role = self::userRoles($result['login']);
            $user->setRole($role);
            return $user;
        }
    }

     //role
    //sprawdzenie, czy użytkownik posiada określoną rolę
    public static function isUserInRole($login, $role) {
        $userRoles = self::userRoles($login);
        return in_array($role, $userRoles);
    }
    //pobranie wszystkich roli użytkownika
    public static function userRoles($login) {
        $stmt = self::$db->prepare("SELECT r.name FROM uzytkownik u 	
		INNER JOIN users_roles ur on(u.id = ur.user_id)
		INNER JOIN roles r on(ur.role_id = r.id)
		WHERE	u.login = ?");
        $stmt->execute(array($login));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $roles = array();
        for ($i = 0; $i < count($result); $i++) {
            $roles[] = $result[$i]['name'];
        }
        return $roles;
    }

    /*
     * kategorie
     */
    //POBRANIE KATEGORII NA PODSTAWIE ID
    public static function getKategoriaById($id) {
        $stmt = self::$db->prepare('SELECT * FROM kategoria WHERE id_kategorii=?');
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0) {
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $result = $results[0];
            $kategoria = new Kategoria();
            $kategoria->setIdKategorii($result['id_kategorii']);
            $kategoria->setNazwa($result['nazwa']);
            return $kategoria;
        }
    }
    //DODANIE KATEGORII
    public static function addKategoria($kategoria) {
        $stmt = self::$db->prepare("INSERT INTO kategoria(nazwa) "
                . "VALUES(:nazwa)");
        $stmt->execute(array(':nazwa' => $kategoria->getNazwa()));
        $affected_rows = $stmt->rowCount();
        if ($affected_rows == 1) {
            return TRUE;
        }
        return FALSE;
    }
    //POBRANIE LISTY KATEGORII
    public static function getKategoriaList() {
        $stmt = self::$db->query('SELECT * FROM kategoria');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    //USUNIECIE KATEGORII
    public static function deleteKategoria($kategoria) {
        $stmt = self::$db->prepare('DELETE FROM kategoria WHERE id_kategorii=?');
        $stmt->execute(array($kategoria->getIdKategorii()));
        $affected_rows = $stmt->rowCount();
        if ($affected_rows == 1) {
            return TRUE;
        }
        return FALSE;
    }
    //EDYCJA KATEGORII
    public static function updateKategoria($kategoria) {
        $stmt = self::$db->prepare('UPDATE kategoria set nazwa=? WHERE id_kategorii=?');
        $stmt->execute(array($kategoria->getNazwa(), $kategoria->getIdKategorii()));
        $affected_rows = $stmt->rowCount();
        if ($affected_rows == 1) {
            return TRUE;
        }
        return FALSE;
    }

    /*
     * Narzedzia
     */

    public static function getNarzedzieById($id) {
        $stmt = self::$db->prepare('SELECT * FROM narzedzia p WHERE id_narzedzia=?');
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0) {
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $result = $results[0];
            $narzedzie = new Narzedzia();
            $narzedzie->setIdNarzedzia($result['id_narzedzia']);
            $narzedzie->setNazwa($result['nazwa']);
            $narzedzie->setIdKategorii($result['id_kategorii']);
            $narzedzie->setKategoria(self::getKategoriaById($result['id_kategorii']));
            $narzedzie->setWaga($result['waga']);
            $narzedzie->setOpis($result['opis']);
            return $narzedzie;
        }
    }

    public static function addNarzedzie($narzedzia) {
        $stmt = self::$db->prepare("INSERT INTO narzedzia(nazwa,waga,id_kategorii,opis) "
                . "VALUES(:nazwa , :waga, :id_kategorii, :opis)");
        $stmt->execute(array(
            ':nazwa' => $narzedzia->getNazwa(),
            ':id_kategorii' => $narzedzia->getIdKategorii(),
            ':waga' => $narzedzia->getWaga(),
            ':opis' => $narzedzia->getOpis()
        ));

        $affected_rows = $stmt->rowCount();
        if ($affected_rows == 1) {
            return TRUE;
        }
        return FALSE;
    }

    public static function getNarzedzieList() {
        $stmt = self::$db->query('SELECT * FROM narzedzia');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
     public static function getNarzedzieListByCategory($idKategorii) {
        $stmt = self::$db->prepare('SELECT * FROM narzedzia WHERE id_kategorii=?');
         $stmt->execute(array($idKategorii));
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function deleteNarzedzie($narzedzia) {
        $stmt = self::$db->prepare('DELETE FROM narzedzia WHERE id_narzedzia=?');
        $stmt->execute(array($narzedzia->getIdNarzedzia()));
        $affected_rows = $stmt->rowCount();
        if ($affected_rows == 1) {
            return TRUE;
        }
        return FALSE;
    }

    public static function updateNarzedzie($narzedzia) {
        try {
            self::$db->beginTransaction();
            $stmt = self::$db->prepare('UPDATE narzedzia set nazwa=:nazwa, waga=:waga, '
                    . 'id_kategorii=:id_kategorii,'
                    . 'opis=:opis WHERE id_narzedzia=:id');
            $stmt->execute(array(
                ':id' => $narzedzia->getIdNarzedzia(),
                ':nazwa' => $narzedzia->getNazwa(),
                ':id_kategorii' => $narzedzia->getIdKategorii(),
                ':opis' => $narzedzia->getOpis(),
                ':waga' => $narzedzia->getWaga()
            ));

            $affected_rows = $stmt->rowCount();
            if ($affected_rows == 1) {
                self::$db->commit();
                return TRUE;
            }
        } catch (Exception $ex) {
            echo $ex;
            self::$db->rollBack();
            return FALSE;
        }
    }

    /*
     * Zamówienia
     */

    public static function getZamowienieById($id) {
        $stmt = self::$db->prepare('SELECT * FROM zamowienie WHERE id_zamowienia=?');
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0) {
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $result = $results[0];
            $zamowienie = new Zamowienie();
            $zamowienie->setIdZamowienia($result['id_zamowienia']);

            $narzedziaZamowienia = self::getNarzedziaZamowienia($id);
            $zamowienie->setNarzedzia($narzedziaZamowienia);
            $waga = 0.0;
            foreach ($narzedziaZamowienia as $p) {
                $waga += $p->getNarzedzie()->getWaga() * $p->getIlosc();
            }
            $zamowienie->setWaga($waga);
            $zamowienie->setStanowisko($result['stanowisko']);
            $zamowienie->setDataRealizacji($result['data_realizacji']);
            $zamowienie->setDataZamowienia($result['data_zamowienia']);
            $zamowienie->setIdOperatora($result['id_operatora']);
            $zamowienie->setStatus($result['status']);
            $zamowienie->setUwagi($result['uwagi_dodatkowe']);
            return $zamowienie;
        }
    }

    public static function addZamowienie($zamowienie) {
        $stmt = self::$db->prepare("INSERT INTO zamowienie(id_operatora,stanowisko,uwagi_dodatkowe,status,data_zamowienia) "
                . "VALUES(:id_operatora, :stanowisko, :uwagi_dodatkowe, :status, now())");
        $stmt->execute(array(
            ':id_operatora' => $zamowienie->getIdOperatora(),
            ':stanowisko' => $zamowienie->getStanowisko(),
            ':uwagi_dodatkowe' => $zamowienie->getUwagi(),
            ':status' => $zamowienie->getStatus()
        ));

        $affected_rows = $stmt->rowCount();
        if ($affected_rows == 1) {
            $idZamowienia = self::$db->lastInsertId();
            if (!empty($idZamowienia)) {
                foreach ($zamowienie->getNarzedzia() as $narzedzie) {
                    $stmt = self::$db->prepare("INSERT INTO szczegoly_zamowienia(id_zamowienia, id_narzedzia,ilosc) "
                            . "VALUES(:id_zamowienia, :id_narzedzia , :ilosc)");
                    $stmt->execute(array(
                        ':id_narzedzia' => $narzedzie->getIdNarzedzia(),
                        ':id_zamowienia' => $idZamowienia,
                        ':ilosc' => $narzedzie->getIlosc()
                    ));
                }
                return TRUE;
            }
        }
        return FALSE;
    }

    public static function getZamowienieList() {
        $stmt = self::$db->query('SELECT * FROM zamowienie');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getZamowienieUserList($idUser) {
        $stmt = self::$db->prepare('SELECT * FROM zamowienie WHERE id_operatora=?');
        $stmt->execute(array($idUser));
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getNarzedziaZamowienia($idZamowienia) {
        $stmt = self::$db->prepare('SELECT * FROM szczegoly_zamowienia WHERE id_zamowienia=?');
        $stmt->execute(array($idZamowienia));
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $narzedzia = array();
        foreach ($results as $row) {
            $idNarzedzia = $row['id_narzedzia'];
            $narzedzie = self::getNarzedzieByIdById($idNarzedzia);
            $narzedzieZamowienia = new NarzedzieZamowienia();
            $narzedzieZamowienia->setIdNarzedzia($idNarzedzia);
            $narzedzieZamowienia->setIdZamowienia($idZamowienia);
            $narzedzieZamowienia->setIlosc($row['ilosc']);
            $narzedzieZamowienia->setNarzedzie($narzedzie);
            $narzedzia[] = $narzedzieZamowienia;
        }
        return $narzedzia;
    }

    public static function deleteZamowienie($zamowienie) {
        $stmt = self::$db->prepare('DELETE FROM zamowienie WHERE id_zamowienia=?');
        $stmt->execute(array($zamowienie->getIdZamowienia()));
        $affected_rows = $stmt->rowCount();
        if ($affected_rows == 1) {
            return TRUE;
        }
        return FALSE;
    }

    public static function payZamowienie($zamowienie) {
        $stmt = self::$db->prepare('UPDATE zamowienie SET status=? , data_zamowienia=now() WHERE id_zamowienia=?');
        $stmt->execute(array($zamowienie->getStatus(), $zamowienie->getIdZamowienia()));
        $affected_rows = $stmt->rowCount();
        if ($affected_rows == 1) {
            return TRUE;
        }
        return FALSE;
    }

    public static function realizeZamowienie($zamowienie) {
        $stmt = self::$db->prepare('UPDATE zamowienie SET data_realizacji=now() , status=? WHERE id_zamowienia=?');
        $stmt->execute(array($zamowienie->getStatus(), $zamowienie->getIdZamowienia()));

        $affected_rows = $stmt->rowCount();
        if ($affected_rows == 1) {
            return TRUE;
        }
        return FALSE;
    }

    
    /*
     * Roboty
     */
    //POBRANIE ROBOTA NA PODSTAWIE ID
    public static function getRobotById($id) {
        $stmt = self::$db->prepare('SELECT * FROM roboty WHERE id_robota=?');
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0) {
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $result = $results[0];
            $robot = new Robot();
            $robot->setIdRobota($result['id_robota']);
            $robot->setNazwa($result['nazwa']);
            return $robot;
        }
    }
    //DODANIE ROBOTA
    public static function addRobot($roboty) {
        $stmt = self::$db->prepare("INSERT INTO roboty(nazwa) "
                . "VALUES(:nazwa)");
        $stmt->execute(array(':nazwa' => $roboty->getNazwa()));
        $affected_rows = $stmt->rowCount();
        if ($affected_rows == 1) {
            return TRUE;
        }
        return FALSE;
    }
    //POBRANIE LISTY ROBOTÓW
    public static function getRobotList() {
        $stmt = self::$db->query('SELECT * FROM roboty');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    //USUNIECIE ROBOTA
    public static function deleteRobot($roboty) {
        $stmt = self::$db->prepare('DELETE FROM roboty WHERE id_robota=?');
        $stmt->execute(array($roboty->getIdRobota()));
        $affected_rows = $stmt->rowCount();
        if ($affected_rows == 1) {
            return TRUE;
        }
        return FALSE;
    }
    //EDYCJA ROBOTA
    public static function updateRobot($roboty) {
        $stmt = self::$db->prepare('UPDATE roboty set nazwa=? WHERE id_robota=?');
        $stmt->execute(array($roboty->getNazwa(), $roboty->getIdRobota()));
        $affected_rows = $stmt->rowCount();
        if ($affected_rows == 1) {
            return TRUE;
        }
        return FALSE;
    }

    
}

?>