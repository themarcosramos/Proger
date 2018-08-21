<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Financiadora */

$this->title = 'Nova Financiadora';
$this->params['breadcrumbs'][] = ['label' => 'Financiadoras', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="financiadora-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
