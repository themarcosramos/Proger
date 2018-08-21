<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SubArea */

$this->title = 'Atualizar Subárea:'.$model->nome;
$this->params['breadcrumbs'][] = ['label' => 'Sub Areas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nome, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Atualizar';
?>
<div class="sub-area-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
