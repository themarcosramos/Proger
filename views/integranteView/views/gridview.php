<?php

use yii\helpers\Html;
use yii\grid\GridView;
?>

<h3>Integrantes</h3>
<?php
    $GLOBALS['controller'] = &$controller;
    $GLOBALS['novo'] = &$novo;
    //$controller e $novo são usados na formação da url dos botoes de update e delete 
    echo GridView::widget([
        'dataProvider' => $query,
        'filterModel' => $searchModel,
        'columns' => [   
            [
                'class' => 'yii\grid\SerialColumn',
                'headerOptions' => ['style'=>'text-align:center; width: 50px;'],
                'contentOptions'=>['align' => 'center']
            ], 
            [
                'attribute' => 'matricula',
                'headerOptions' => ['style'=>'text-align:center; width: 100px;'],
                'contentOptions'=>['align' => 'center']
            ],

            [
                'attribute'=> 'idPessoa',
                'value'=>'idPessoa0.nome',
                'headerOptions' => ['style'=>'text-align:center;'],
                'contentOptions'=>['align' => 'center']
            ],
            
            [
                'attribute'=> 'idTipoFuncao',
                'value'=>'idTipoFuncao0.descricao',
                'headerOptions' => ['style'=>'text-align:center; '],
                'contentOptions'=>['align' => 'center']
            ],

            [
                'attribute' => 'dataInicio',
                'format'=>['date','dd/MM/yyyy'],
                'headerOptions' => ['style'=>'text-align:center;'],
                'contentOptions'=>['align' => 'center']
            ],

            [
                'attribute' => 'dataFim',
                'format'=>['date','dd/MM/yyyy'],
                'headerOptions' => ['style'=>'text-align:center;'],
                'contentOptions'=>['align' => 'center']
            ],

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
                'headerOptions' => ['style'=>'text-align:center; width: 100px;'],
                'contentOptions'=>['align' => 'center']
            ],

            //['class' => 'yii\grid\ActionColumn'],
            [
                'class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['style'=>'text-align:center; '],
                'contentOptions'=>['align' => 'center'],
                'template' => ' {view} ',
                'urlCreator' => function ($action, $model, $key, $index) {
                    global $controller, $novo;
                    if ($action === 'view') {
                        $url = Yii::$app->urlManager->createUrl($controller.'/view-integrante').'&n='.$novo.'&id='.$model->id; // your own url generation logic
                        return $url;
                    }
                }
            ],
        ]
    ]); 
?>