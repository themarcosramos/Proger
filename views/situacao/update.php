<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Situacao */

$this->title = 'Atualizar Situação: ' . $model->nome;
$this->params['breadcrumbs'][] = ['label' => 'Situação', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nome, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Atualizar';
?>
<div class="situacao-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
