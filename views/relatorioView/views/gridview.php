<?php

use yii\helpers\Html;
use yii\grid\GridView;
?>

<h3> Relatórios: </h3>

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
                'attribute'=> 'populacaoAtingida',
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
                'attribute'=> 'dataEntregaRelatorio',
                'format'=>['date','dd/MM/yyyy'],
                'headerOptions' => ['style'=>'text-align:center;  width: 100px;'],
                'contentOptions'=>['align' => 'center']
            ],
            [
                'attribute'=> 'urlArquivo',
                'value' => function($model, $index, $dataColumn) {
                    return $model->getFileName();
                },
                'headerOptions' => ['style'=>'text-align:center;  width: 100px;'],
                'contentOptions'=>['align' => 'center']
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['style'=>'text-align:center;  width: 50px;'],
                'contentOptions'=>['align' => 'center'],
                'template' => '{download}',
                'buttons' =>[
                    'download' => function ($url, $model) {
                        return Html::a('<span title="Baixar" class="glyphicon glyphicon-save"></span>', $url, 
                        ['title' => Yii::t('app', 'Download'),]); 
                    },
                ],
                'urlCreator' => function ($action, $model, $key, $index) {
                    global $controller, $novo;
                    if ($action === 'download') {
                        $url = Yii::$app->urlManager->createUrl($controller.'/download-relatorio').'&idproger='.$model->idProger.'&filename='.$model->getFileNameRand(); // your own url generation logic
                        return $url;
                    }
                }
            ],
        ],
    ]);
?>