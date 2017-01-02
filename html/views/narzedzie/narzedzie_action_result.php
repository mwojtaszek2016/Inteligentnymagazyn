<?php
if (!empty($error)) {
    ?>
    <div class="alert alert-danger" role="alert">
        <?= $error ?>
    </div>
    <?php
} else if (!empty($success)) {
    ?>
    <div class="alert alert-success" role="alert">
        <?= $success ?>
    </div>

    <?php
}
?><br><br>
<a href="/<?= APP_ROOT ?>/narzedzie">Powrót do listy narzedzi</a>
