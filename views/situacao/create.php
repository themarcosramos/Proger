<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Situacao */

$this->title = 'Nova Situação';
$this->params['breadcrumbs'][] = ['label' => 'Situação', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="situacao-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
