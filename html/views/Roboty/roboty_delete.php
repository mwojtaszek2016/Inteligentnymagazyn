<br><br>
<h1>Usuń robota</h1>
<?php
$nazwa = "";
$id = "";
if (!empty($model)) {
    $nazwa = $model->getNazwa();
    $id = $model->getIdRobota();
}
?> 
<center>
<br>
<h3>Czy na pewno chcesz usunąć robota: <b><?=$nazwa?></b>?</h3>
<br>

<form method="POST" action="/<?= APP_ROOT ?>/roboty/delete">
   
        <input type="hidden" name="id" value="<?=$id?>"/>
        <button class="btn btn-default" type="submit" name="cancel" >Anuluj</button><br /><br>
    <button class="btn btn-default"  type="submit" name="delete"> Usuń</button><br />
    </center>
</form>
<br><br><br>
<center>
<a href="/<?=APP_ROOT?>/roboty">Powrót do listy robotów</a>
</center>