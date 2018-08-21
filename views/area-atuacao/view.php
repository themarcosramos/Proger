<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\GrandeArea;

/* @var $this yii\web\View */
/* @var $model app\models\AreaAtuacao */

$this->title = $model->nome;
$this->params['breadcrumbs'][] = ['label' => 'Área Atuação', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="area-atuacao-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Atualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
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
            //'id',
            'nome',
            'codigo',
            //'ativo',
            [            
                'attribute' => 'ativo',                
                'value' => $model->getAtivo(),
            ],
            //'idGrandeArea',
            [
                'attribute' => 'idGrandeArea',
                'label' => 'Grande Área',
                'value' => GrandeArea::findOne($model->idGrandeArea)->nome,
            ],
        ],
    ]) ?>

</div>
