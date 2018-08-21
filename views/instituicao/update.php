<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Instituicao */

$this->title = 'Atualizar Instituição: ' . $model->sigla;
$this->params['breadcrumbs'][] = ['label' => 'Instituição', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->sigla, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="instituicao-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
