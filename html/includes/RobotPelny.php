<?php
if (isset($_SESSION['RobotPelny']) && isset($_SESSION['calkowita_ilosc']) && isset($_SESSION['waga'])) {
    ?> 
    <h3>Załadowany robot z zasobem magazynu</h3>
    <p>Ilość produktów na robocie: <?= $_SESSION['calkowita_ilosc'] ?> </p>
    <p>Waga: <?= $_SESSION['waga'] ?> </p>
    <p><a href="/<?= APP_ROOT ?>/RobotPelny">Przejdź do załadowanego robota</a></p>
    <?php 
}

