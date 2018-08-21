<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\SubArea */

$this->title = 'Subárea';
$this->params['breadcrumbs'][] = ['label' => 'Subárea', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sub-area-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
