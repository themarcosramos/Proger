<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Gestor */

$this->title = 'Novo Gestor';
$this->params['breadcrumbs'][] = ['label' => 'Gestor', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gestor-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
