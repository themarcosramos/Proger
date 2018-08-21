<?php

use yii\helpers\Html;
use yii\grid\GridView;
?>

<h3> Financiamentos: </h3>


<?php
    $GLOBALS['controller'] = &$controller;
    $GLOBALS['novo'] = &$novo;

    echo GridView::widget([
        'dataProvider' => $query,
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'headerOptions' => ['style'=>'text-align:center; width: 50px;'],
                'contentOptions'=>['align' => 'center']
            ],       
            [
                'header'=> 'Financiadora',
                'value'=>'idFinanciadora0.nome',
                'headerOptions' => ['style'=>'text-align:center; width: 100px;'],
                'contentOptions'=>['align' => 'center']
            ],
    
            [
                'header'=> 'Edital',
                'attribute'=> 'edital',
                'headerOptions' => ['style'=>'text-align:center;  width: 100px;'],
                'contentOptions'=>['align' => 'center']
            ],
                        
            [
                'attribute'=> 'valorAprovado',
                'headerOptions' => ['style'=>'text-align:center;  width: 100px;'],
                'contentOptions'=>['align' => 'center']
            ],
            [
                'attribute'=> 'dataInicio',
                'format'=>['date','dd/MM/yyyy'],
                'headerOptions' => ['style'=>'text-align:center;  width: 100px;'],
                'contentOptions'=>['align' => 'center']
            ],
            [
                'attribute'=> 'dataFim',
                'format'=>['date','dd/MM/yyyy'],
                'headerOptions' => ['style'=>'text-align:center;  width: 100px;'],
                'contentOptions'=>['align' => 'center']
            ],          
            [
                'class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['style'=>'text-align:center;  width: 50px;'],
                'contentOptions'=>['align' => 'center'],
                'template' => ' {update} {delete}',
                'buttons' =>[
                    'update' => function ($url, $model) {
                        return Html::a('<span title="Alterar" class="glyphicon glyphicon-pencil"></span>', $url, 
                        ['title' => Yii::t('app', 'Update'),]); 
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                            'title' => Yii::t('app', 'Delete'),
                            'data' => [
                                'confirm' => 'Você tem certeza que deseja excluir este item?',
                                'method' => 'post',
                            ],
                        ]);                   
                    },
                ],
                'urlCreator' => function ($action, $model, $key, $index) {
                    global $controller, $novo;
                    if ($action === 'update') {
                        $url = Yii::$app->urlManager->createUrl($controller.'/update-financiamento').'&n='.$novo.'&id='.$model->id;
                        return $url;
                    }
                    if ($action === 'delete') {
                        $url = Yii::$app->urlManager->createUrl($controller.'/delete-financiamento').'&n='.$novo.'&id='.$model->id;
                        return $url;
                    }
                }
            ],
        ],
    ]);
?>
