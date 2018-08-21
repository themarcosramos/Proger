<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TipoVinculo */

$this->title = 'Atualizar Vínculo: ' . $model->descricao;
$this->params['breadcrumbs'][] = ['label' => 'Vínculos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->descricao, 'url' => ['view', 'descricao' => $model->descricao]];
$this->params['breadcrumbs'][] = 'Atualizar';
?>
<div class="tipo-vinculo-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
