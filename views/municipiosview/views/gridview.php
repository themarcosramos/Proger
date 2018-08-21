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
        ],
    ]);
 ?>  