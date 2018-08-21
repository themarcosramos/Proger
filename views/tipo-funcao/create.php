<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\tipoFuncao */

$this->title = 'Novo Tipo de Função';
$this->params['breadcrumbs'][] = ['label' => 'Tipo de Função', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipo-funcao-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
