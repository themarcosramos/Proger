<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\SubArea;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\EspecialidadeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Especialidade';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="especialidade-index">

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
            //'nome',
            [
                'attribute' =>'nome', 
                'headerOptions' => ['style'=>'text-align:center; width: 300px;'],
                'contentOptions'=>['align' => 'center']
            ],
            //'codigo',
            [
                'attribute' =>'codigo', 
                'headerOptions' => ['style'=>'text-align:center; width: 300px;'],
                'contentOptions'=>['align' => 'center']
            ],
            
            //'idSubArea',
            [
                'attribute' => 'idSubArea',
                'label' => 'Subárea',
                'filter' => SubArea::dropdown(),
                'value' => function($model, $index, $dataColumn) {
                    $dropdown = SubArea::dropdown();
                    return $dropdown[$model->idSubArea];
                },
                'headerOptions' => ['style'=>'text-align:center; width: 300px;'],
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
