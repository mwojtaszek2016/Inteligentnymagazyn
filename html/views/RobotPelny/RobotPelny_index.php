<h1>Załadowany robot</h1>
<form method="POST" action="/<?= APP_ROOT ?>/RobotPelny/edit">
<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <tr><th>Nazwa</th><th>Waga</th><th>Ilość</th><th>Usuń</th>  </tr>                  
        <?php
        for ($i = 0; $i < count($narzedzia); $i++) {
            echo '<tr>';
            echo '<td>' . $narzedzia[$i]->getNazwa() . '</td>';
            echo '<td>' . $narzedzia[$i]->getWaga() . '</td>';
            echo '<td> <input class="form-control" type="text" name="'. $narzedzia[$i]->getIdNarzedzia() .'" value="'. $ilosci[$i] .'"/></td>';
            echo '<td><a href="RobotPelny/delete/' . $narzedzia[$i]->getIdNarzedzia() . '">Usuń</a></td>';
            echo '</tr>';
        }
        ?>
    </table>
</div>
<button class="btn btn-default" >Zapisz zmiany</button> <br />
<a href="/<?= APP_ROOT ?>/narzedzie">Kontynuuj kompletowanie zasobów</a>  <br />
<a href="zamowienie/add">Do narzędziowni</a>
</form>