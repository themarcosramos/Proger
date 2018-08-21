<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Setor */

$this->title = 'Atualizar Setor: ' . $model->sigla;
$this->params['breadcrumbs'][] = ['label' => 'Setor', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->sigla, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Atualizar';
?>
<div class="setor-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
