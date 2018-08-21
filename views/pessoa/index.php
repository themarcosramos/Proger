<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Integrante;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\PessoaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = 'Pessoas';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="pessoa-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

   
    <p>
        <?= Html::a('Novo', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="well">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            //'id',
            [
                'attribute' => 'nome',
                'headerOptions' => ['style'=>'text-align:center; width: 250px;'],
                'contentOptions'=>['align' => 'center']
            ],
            [
                'attribute' => 'cpf',
                'headerOptions' => ['style'=>'text-align:center; width: 170px;'],
                'contentOptions'=>['align' => 'center']
            ],
            [
                'attribute' => 'rg',
                'headerOptions' => ['style'=>'text-align:center; width: 170px;'],
                'contentOptions'=>['align' => 'center']
            ],
            [
                'attribute' => 'email',
                'headerOptions' => ['style'=>'text-align:center; width: 180px;'],
                'contentOptions'=>['align' => 'center']
            ],
            [
                'attribute' => 'telefone',
                'headerOptions' => ['style'=>'text-align:center; width: 140px;'],
                'contentOptions'=>['align' => 'center']
            ],
            // 'celular',
            // 'cep',
            // 'rua',
            // 'numero',
            // 'bairro',
            // 'idCidade',
            // 'idEstado',

             [
                'class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['style'=>'text-align:center;  width: 100px;'],
                'contentOptions'=>['align' => 'center'],
                'template' => ' {view} {update} ',
                'buttons' =>[                                      
                    'delete' => function ($url, $model) {
                        $Pessoa = Integrante::find()->where(['idPessoa'=>$model->id])->one();                        
                        if (isset($Pessoa)){
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                'title' => Yii::t('app', 'Delete'),
                                'data' => [
                                    'confirm' => 'Esta pessoa possui vínculo de integrante, tem certeza que deseja inativar?',
                                    'method' => 'post',
                                ],
                            ]); 
                        }else{
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                'title' => Yii::t('app', 'Delete'),
                                'data' => [
                                    'confirm' => 'Você tem certeza que deseja excluir este item?',
                                    'method' => 'post',
                                ],
                            ]); 
                        }                  
                    },
                ],
                'urlCreator' => function ($action, $model, $key, $index) {
                    if ($action === 'view') {
                        $url = Yii::$app->urlManager->createUrl('pessoa/view').'&id='.$model->id; // your own url generation logic
                        return $url;
                    }
                    if ($action === 'update') {
                        $url = Yii::$app->urlManager->createUrl('pessoa/update').'&id='.$model->id; // your own url generation logic
                        return $url;
                    }
                    if ($action === 'delete') {
                        $url = Yii::$app->urlManager->createUrl('pessoa/delete').'&id='.$model->id; // your own url generation logic
                        return $url;
                    }
                }
            ],
        ],
    ]); ?>
    </div>
</div>

