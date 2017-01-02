<br><br>
<h1>Edytuj robota</h1>
<br>
<?php
if (!empty($error)) {  ?>
    <div class="alert alert-danger" role="alert">
        <?= $error ?>
    </div>
    <?php } else if (!empty($success)) {   ?>
    <div class="alert alert-success" role="alert">
    <?= $success ?>
    </div>
    <?php }
$nazwa = "";
$id = "";
if (!empty($model)) {
    $nazwa = $model->getNazwa();
    $id = $model->getIdRobota(); } ?>
<form method="POST" action="/<?= APP_ROOT ?>/roboty/edit">
    
    <div class="form-group">
        <label>Nazwa </label> <br>
        <input class="form-control" type="text" name="nazwa" value="<?= $nazwa ?>" />
    </div>
    <center>
    <input type="hidden" name="id" value="<?= $id ?>" />
    <br>
    <button class="btn btn-default" type="submit">Zapisz</button><br /><br>
    </center>
</form>
<br><br><br>
<center>
<a href="/<?=APP_ROOT?>/roboty">Powrót do listy robotów</a>
</center>