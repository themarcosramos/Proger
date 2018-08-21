<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\GrandeArea */

$this->title = 'Nova Grande Área';
$this->params['breadcrumbs'][] = ['label' => 'Grande Área', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="grande-area-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
