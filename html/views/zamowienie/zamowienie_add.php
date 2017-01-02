<h1>Dodaj zamówienie</h1>
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
?>

<form method="POST" action="/<?= APP_ROOT ?>/zamowienie/add">
    <div class="form-group">
        <label>Stanowisko </label>
        <input type="text" name="stanowisko" class="form-control" /> 
 <!--value="?= $stanowisko ?>"-->
    </div>
    <div class="form-group">
        <label>Uwagi </label>
        <input type="text" name="uwagi" class="form-control"/> 
    </div>

    <div class="form-group">
        <label>Narzędzia</label>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <tr>
                    <td>
                        Ilość
                    </td>  
                    <td>
                        Nazwa
                    </td>
                    <td>
                        Waga
                    </td>
                    <td>
                        Kategoria
                    </td>
                </tr>
                <?php
                for ($i = 0; $i < count($narzedzia); $i++) {
                    echo '<tr>';
                    echo '<td>' . $ilosci[$i] . '</td>';
                    echo '<td>' . $narzedzia[$i]->getNazwa() . '</td>';
                    echo '<td>' . $narzedzia[$i]->getWaga() . '</td>';
                    echo '<td>' . $narzedzia[$i]->getKategoria()->getNazwa() . '</td>';
                    echo '</tr>';
                }
                ?>
            </table>
            
             </div>
    </div>
    <!-- -->

    <button type="submit" class="btn btn-default">Zamów</button>

</form>