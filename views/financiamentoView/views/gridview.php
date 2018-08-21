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
                    'template' => ' {view} ',
                    'urlCreator' => function ($action, $model, $key, $index) {
                        global $controller, $novo;
                        if ($action === 'view') {
                            $url = Yii::$app->urlManager->createUrl($controller.'/view-financiamento').'&n='.$novo.'&id='.$model->id; // your own url generation logic
                            return $url;
                        }
                    }
            ],
        ],
    ]);
?>
