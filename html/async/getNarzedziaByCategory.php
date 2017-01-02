<?php
include '../application/database.class.php';
include '../model/Narzedzia.class.php';
include '../model/Kategoria.class.php';
$db = Database::getInstance();
$idKategorii = $_GET['kategoria'];
if ($idKategorii == "Wszystkie") {
    $results = $db::getNarzedzieList();
} else {
    $results = $db::getNarzedzieListByCategory($idKategorii);
}
$response = "<tr><th>Nazwa</th><th>Waga</th><th>Kategoria</th><th>Opis</th><th>Dodaj do Robota</th></tr>";                                  
foreach ($results as $row) {
    $kategoria = $db::getKategoriaById($row['id_kategorii']);
    $response .= '<tr>';
    $response .= '<td>' . $row['nazwa'] . "</td>";
    $response .= '<td>' . $row['waga'] . "</td>";
    $response .= '<td>' . $kategoria->getNazwa() . "</td>";
    $response .= '<td>' . $row['opis'] . "</td>";
    $response .= "<td>" . '<a href="RobotPelny/add/' . $row['id_narzedzia'] . '">Dodaj do Robota</a></td>';
    $response .= "</tr>";
}
echo $response;


