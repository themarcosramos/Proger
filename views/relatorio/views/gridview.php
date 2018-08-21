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
                'template' => '{download} {update} {delete}',
                'buttons' =>[
                    'download' => function ($url, $model) {
                        return Html::a('<span title="Baixar" class="glyphicon glyphicon-save"></span>', $url, 
                        ['title' => Yii::t('app', 'Download'),]); 
                    },
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
                    if ($action === 'download') {
                        $url = Yii::$app->urlManager->createUrl($controller.'/download-relatorio').'&idproger='.$model->idProger.'&filename='.$model->getFileNameRand(); // your own url generation logic
                        return $url;
                    }else
                    if ($action === 'update') {
                        $url = Yii::$app->urlManager->createUrl($controller.'/update-relatorio').'&n='.$novo.'&id='.$model->id; // your own url generation logic
                        return $url;
                    }else
                    if ($action === 'delete') {
                        $url = Yii::$app->urlManager->createUrl($controller.'/delete-relatorio').'&n='.$novo.'&id='.$model->id; // your own url generation logic
                        return $url;
                    }
                }
            ],
        ],
    ]);
?>