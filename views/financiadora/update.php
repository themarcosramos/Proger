<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Financiadora */

$this->title = 'Atualizar Financiadora: ' . $model->sigla;
$this->params['breadcrumbs'][] = ['label' => 'Financiadoras', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->sigla, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Atualizar';
?>
<div class="financiadora-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
