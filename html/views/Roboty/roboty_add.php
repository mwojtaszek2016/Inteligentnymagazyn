<br><br>
<h1>Dodaj robota</h1>
<?php
if (!empty($error)) {
    ?>
    <div class="alert alert-danger" role="alert">
        <?= $error ?>
    </div>
    <?php }
else if (!empty($success)) {  ?> 
    <div class="alert alert-success" role="alert">
        <?= $success ?>
    </div>
    <?php } ?>
<form method="POST" action="/<?= APP_ROOT ?>/roboty/add">
    <div class="form-group">
        <br>
        <label>Nazwa robota </label>
    <input type="text" name="nazwa" class="form-control"/>  
    </div>
    <center><br>
    <button class="btn btn-default" type="submit">Dodaj</button>
    </center>
</form>
<br><br><br><br><br><br>
<center>
<a href="/<?=APP_ROOT?>/roboty">Powrót do listy robotów</a>
</center>