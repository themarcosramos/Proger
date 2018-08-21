<?php
use yii\helpers\Html;
?>
<div class="stepwizard">
    <div class="stepwizard-row">
        <div class="stepwizard-step">            
            <a href="?r=<?=$action?>&s=1&n=<?=$novo?>&idmodel=<?=$idmodel?>">
            <button type="button" class="btn btn-<?=($index==1)?'primary':'default'?> btn-circle" <?= ($novo)? 'disabled':'' ?>>1</button>
            </a><p>Informações Gerais</p>
        </div>
        <div class="stepwizard-step">
            <a href="?r=<?=$action?>&s=2&n=<?=$novo?>&idmodel=<?=$idmodel?>">
            <button type="button" class="btn btn-<?=($index==2)?'primary':'default'?> btn-circle" <?= ($novo)? 'disabled':'' ?>>2</button>
            </a><p>Integrantes</p>
        </div>
        <div class="stepwizard-step">
            <a href="?r=<?=$action?>&s=3&n=<?=$novo?>&idmodel=<?=$idmodel?>">
            <button type="button" class="btn btn-<?=($index==3)?'primary':'default'?> btn-circle" <?= ($novo)? 'disabled':'' ?>>3</button>
            </a><p>Relatórios</p>
        </div>
        <div class="stepwizard-step">
            <a href="?r=<?=$action?>&s=4&n=<?=$novo?>&idmodel=<?=$idmodel?>">
            <button type="button" class="btn btn-<?=($index==4)?'primary':'default'?> btn-circle" <?= ($novo)? 'disabled':'' ?>>4</button>
            </a><p>Financiamentos</p>
        </div>
         <div class="stepwizard-step">
            <a href="?r=<?=$action?>&s=5&n=<?=$novo?>&idmodel=<?=$idmodel?>">
            <button type="button" class="btn btn-<?=($index==5)?'primary':'default'?> btn-circle" <?= ($novo)? 'disabled':'' ?>>5</button>
            </a><p>Outras informações</p>
        </div>
    </div>
</div>