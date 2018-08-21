<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Setor */

$this->title = $model->sigla;
$this->params['breadcrumbs'][] = ['label' => 'Setor', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="setor-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Atualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Excluir', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Você tem certeza que deseja excluir este item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'nome',
            'sigla',
           // 'ativo',
             [
                'attribute' => 'situacao',
                'value' => $model->getSituacao(),
                'label' => 'Situação',
            ], 
        ],
    ]) ?>

</div>
