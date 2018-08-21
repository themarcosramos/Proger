<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\AreaAtuacao */

$this->title = 'Nova Área de Atuação';
$this->params['breadcrumbs'][] = ['label' => 'Área de Atuação', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="area-atuacao-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
