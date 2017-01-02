<h1>Edytuj narzedzie</h1>
<?php
$nazwa = "";
$waga = "";
$opis = "";
$kategorie = array();
$id = "";

if (!empty($model)) {
    $id = $model->getIdNarzedzia();
    $nazwa = $model->getNazwa();
    $waga = $model->getWaga();
    $opis = $model->getOpis();
    $kategoriaNarzedzia = $model->getKategoria();
}
?>

<form method="POST" action="/<?= APP_ROOT ?>/narzedzie/edit">
    <div class="form-group">
        <label>Nazwa </label>
        <input class="form-control" type="text" name="nazwa" value="<?= $nazwa ?>" /> 
        <input type="hidden" name="id" value="<?= $id ?>" />
    </div>
    <div class="form-group">
        <label>Waga </label>
        <input class="form-control" type="text" name="waga"  value="<?= $waga ?>"/> 
    </div>
    <div class="form-group">
        <label>Kategoria</label>
        <select name="kategoria" class="form-control">
            <?php
            foreach ($kategorieAll as $kategoria) {
                if ($kategoria['id_kategorii'] == $kategoriaNarzedzia->getIdKategorii()) {
                    echo '<option value="' . $kategoria['id_kategorii'] . '" selected>' . $kategoria['nazwa'] . '</option>';
                } else {
                    echo '<option value="' . $kategoria['id_kategorii'] . '" >' . $kategoria['nazwa'] . '</option>';
                }
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label>Opis </label>
        <input class="form-control" type="text" name="opis" value="<?= $opis ?>"/> 
    </div>
    <br><br>
    <center>
    <button type="submit"  class="btn btn-default" >Zapisz</button> 
</form>

<a href="/<?= APP_ROOT ?>/narzedzie">Powrót do listy narzedzi</a>
</center>