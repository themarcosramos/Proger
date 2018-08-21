<?php

use yii\widgets\DetailView;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Relatorio */
/* @var $form yii\widgets\ActiveForm */

?>
<div class="well">
    <p>
    <?php Modal::begin([
        'headerOptions' => ['id' => 'modalHeader'],
        'id' => 'modal',
        'size' => 'modal-lg',
        //keeps from closing modal with esc key or by clicking out of the modal.
        // user must click cancel or X to close
        'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE],
        'header' => '<h2>Relatório: '.$model->getFileName().'</h2>',
    ]);?>

    <?= ?>

    <? Modal::end(); ?>
    </p>

</div>