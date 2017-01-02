<?php
?><br><br>

<h1>Lista narzędzi</h1>
<br />

<?php
  global $isAdmin;
if (!$isAdmin) {
    ?>
    <!-- WYBÓR KATEGORII -->
    <div class="form-group">
        <label>Wybierz kategorię</label>
        <select id="kategoria" name="kategoria" class="form-control">
            <option value="Wszystkie">Wszystkie</option>
            <?php
            foreach ($kategorie as $kategoria) {
                echo '<option value="' . $kategoria->getIdKategorii() . '">' . $kategoria->getNazwa() . '</option>';
            }
            ?>
        </select>
        <br />
    </div>
    <?php
}
?>


<div class="table-responsive">
    <table id="narzedzia" class="table table-bordered table-hover">

            <tr><th>Nazwa</th><th>Waga</th><th>Kategoria</th><th>Opis</th><th>Przypisz do robota</th> 
                <?php
                if ($isAdmin) {
                    ?>
                    <th>Edytuj</th><th>Usuń</th>
                    <?php
                }
                ?>
            </tr>
            <?php
            foreach ($narzedzia as $narzedzie) {
                echo '<tr>';
                echo '<td>' . $narzedzie->getNazwa() . '</td>';
                echo '<td>' . $narzedzie->getWaga() . '</td>';
                echo '<td>' . $narzedzie->getKategoria()->getNazwa() . '</td>';
                echo '<td>' . $narzedzie->getOpis() . '</td>';
                echo '<td><a href="RobotPelny/add/' . $narzedzie->getIdNarzedzia() . '">Dodaj do robota</a></td>';
                if ($isAdmin) {
                    echo '<td><a href="narzedzie/edit/' . $narzedzie->getIdNarzedzia() . '">Edytuj</a></td>';
                    echo '<td><a href="narzedzie/delete/' . $narzedzie->getIdNarzedzia() . '">Usuń</a></td>';
                }
                echo '</tr>';
            }
            ?>
    </table>
</div>
<br />
<?php
if ($isAdmin) {
    ?>
<center><br><br>
<a href="narzedzie/add">Dodaj</a><br><br>
</center><br><br>
    <?php
}
?>
<center>
    <a href="/<?= APP_ROOT ?>/narzedzie">Powrót do listy narzedzi</a>
</center>
  
 <!--SKRYPT JQUERY - ŻĄDANIE AJAX -->
<script>
    $("#kategoria").change(function () {
        var kat = $("#kategoria option:selected").val();
        $.ajax({
            url: 'html/async/getNarzedziaByCategory.php',
            type: 'GET',
            data: {kategoria: kat},
            dataType : "html",
            contentType: 'application/html; charset=utf-8',
            success: function (response) {
                
                $("#narzedzia").html(response);
            },
            error: function () {
                alert("error");
            }
        });
    })
</script>
