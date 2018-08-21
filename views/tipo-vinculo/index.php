<?php

use yii\helpers\Html;
use yii\grid\GridView; 

/* @var $this yii\web\View */
/* @var $searchModel app\models\TipoVinculoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Vínculos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipo-vinculo-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Novo', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn',
            'headerOptions' => ['style'=>'text-align:center;'],
            'contentOptions'=>['align' => 'center']],

            //'id',
            //'descricao',
            [
                'attribute' => 'descricao',
                'headerOptions' => ['style'=>'text-align:center; width: 700px; '],
                'contentOptions'=>['align' => 'center']
            ],
            //'ativo',
            [
                'attribute' => 'ativo',
                'format' => 'raw',
                'filter' => [1 => 'Ativo', 0 => 'Inativo'],
                'value' => function($model, $index, $dataColumn) {
                    switch($model->ativo){
                        case 1: return  '<p class="label label-success">Ativo</p>';
                        case 0: return '<p class="label label-danger">Inativo</p>';
                    }
                },
                'headerOptions' => ['style'=>'text-align:center; width: 120px;'],
                'contentOptions'=>['align' => 'center']
            ],
            ['class' => 'yii\grid\ActionColumn',
            'headerOptions' => ['style'=>'text-align:center;'],
            'contentOptions'=>['align' => 'center']],
        ],
    ]); ?>
</div>
