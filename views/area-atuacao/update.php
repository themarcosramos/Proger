<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AreaAtuacao */

$this->title = 'Atualizar Área de Atuação: '. $model->nome;
$this->params['breadcrumbs'][] = ['label' => 'Área de Atuação', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nome, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Atualizar';
?>
<div class="area-atuacao-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
