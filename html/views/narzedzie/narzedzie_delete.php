<br><br>
<h1>Usuń narzedzie</h1>
<?php

$nazwa = "";
$id = "";
if (!empty($model)) {
    $nazwa = $model->getNazwa();
    $id = $model->getIdNarzedzia();
}
?>
<h3>Czy na pewno chcesz usunąć narzędzie: <b><?=$nazwa?></b>?</h3>
<form method="POST" action="/<?= APP_ROOT ?>/narzedzie/delete">
    <input type="hidden" name="id" value="<?=$id?>"/>
    <br><br><center>
    <button class="btn btn-default" type="submit" name="cancel" >Anuluj</button> <br />
    <button class="btn btn-default" type="submit" name="delete" />Usuń</button>  
</form><br><br>
<a href="/<?= APP_ROOT ?>/narzedzie">Powrót do listy narzedzi</a>
</center>