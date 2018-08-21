<?php

use yii\helpers\Html;
use yii\grid\GridView;
?>

<h3> Municípios Abrangidos: </h3>

<?php
    $GLOBALS['controller'] = &$controller;
    $GLOBALS['novo'] = &$novo;

    echo GridView::widget([
        'dataProvider' => $query,
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'headerOptions' => ['style'=>'text-align:center; width: 40px;'],
                'contentOptions'=>['align' => 'center']
            ],
            [
                'header'=> 'Cidade',
                'value'=> 'idCidade0.nome',
                'headerOptions' => ['style'=>'text-align:center;'],
                'contentOptions'=>['align' => 'center']
            ],
            [
                'header'=> 'Estado',
                'value'=> 'idCidade0.idEstado0.nome',
                'headerOptions' => ['style'=>'text-align:center;'],
                'contentOptions'=>['align' => 'center']
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['style'=>'text-align:center;  width: 60px;'],
                'contentOptions'=>['align' => 'center'],
                'template' => '{delete}',
                'buttons' =>[
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
                    if ($action === 'delete') {
                        $url = Yii::$app->urlManager->createUrl($controller.'/delete-municipio').'&n='.$novo.'&id='.$model->id; // your own url generation logic
                        return $url;
                    }
                }
            ],
        ],
    ]);
 ?>  