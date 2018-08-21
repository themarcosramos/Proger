<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TipoVinculo */

$this->title = 'Novo Vínculo';
$this->params['breadcrumbs'][] = ['label' => 'Vínculos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipo-vinculo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
