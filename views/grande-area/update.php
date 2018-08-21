<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\GrandeArea */

$this->title = 'Atualizar Grande Área: '.$model->nome ;
$this->params['breadcrumbs'][] = ['label' => 'Grande Área', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nome, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Atualizar';
?>
<div class="grande-area-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
