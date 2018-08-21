<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Setor */

$this->title = 'Novo Setor';
$this->params['breadcrumbs'][] = ['label' => 'Setor', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="setor-create">

    <h1><?= Html::encode($this->title) ?></h1>    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
