<h1>Lista robotów </h1>
<br />
<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <tr>
            <th>Id</th><th>Nazwa robota</th><th>Edytuj</th><th>Usuń</th>                                                               
        </tr>
        <?php
        foreach ($results as $row) {
            echo '<tr>';
            echo '<td>' . $row['id_robota'] . '</td>';
            echo '<td>' . $row['nazwa'] . '</td>';
            echo '<td><a href="roboty/edit/' . $row['id_robota'] . '">Edytuj</a></td>';
            echo '<td><a href="roboty/delete/' . $row['id_robota'] . '">Usuń</a></td>';
            echo '</tr>';
        }
        ?>
    </table>

</div>
<a href="roboty/add">Dodaj</a>
