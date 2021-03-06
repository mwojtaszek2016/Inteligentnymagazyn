<h1>Lista zamówień</h1>
<br />

<div class="table-responsive">
<table class="table table-bordered table-hover">
    <tr>
        <th>
            Id
        </th>
        <th>
            Narzędzia
        </th>
        <th>
            Waga
        </th>
        <th>
            Data zamówienia
        </th>
        <th>
            Data realizacji
        </th>
         <th>
            Stanowisko
        </th>
        <th>
            Uwagi
        </th>
         <th>
            Status
        </th>

    </tr>
    <?php
    foreach ($zamowienia as $zamowienie) {
        echo '<tr>';
        echo '<td>' . $zamowienie->getIdZamowienia() . '</td>';
        echo '<td><div class="table-responsive"><table class="table table-bordered">'
        . '<tr><th>Nazwa</th><th>Waga</th><th>Ilość</th></tr>';
        foreach ($zamowienie->getNarzedzia() as $narzedzieZamowienie) {
            echo '<tr>';
            echo '<td>' . $narzedzieZamowienie->getNarzedzie()->getNazwa() . '</td>';
            echo '<td>' . $narzedzieZamowienie->getNarzedzie()->getWaga() . '</td>';
            echo '<td>' . $narzedzieZamowienie->getIlosc() . '</td>';
            echo '</tr>';
        }
        echo '</table></div></td>';
        echo '<td>' . $zamowienie->getWaga() . '</td>';
        echo '<td>' . $zamowienie->getDataZamowienia() . '</td>';
        echo '<td>' . $zamowienie->getDataRealizacji() . '</td>';
        echo '<td>' . $zamowienie->getStanowisko() . '</td>';
        echo '<td>' . $zamowienie->getUwagi() . '</td>';
         echo '<td>' . $zamowienie->getStatus() . '</td>';
        echo '</tr>';
    }
    ?>
</table>
</div>

