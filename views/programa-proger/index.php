<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Setor;
use app\models\Situacao;
use app\models\AreaAtuacao;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\ProgramaProgerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Programa Proger';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="programa-proger-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <hr style="height:1px; border:none; background-color:#D0D0D0; margin-top: 10px; margin-bottom: 15px;" />

    <p>
    <?= Html::a('Novo', ['cadastrar','s'=>1, 'novo'=>true], ['class' => 'btn btn-success']) ?>
    </p>

<div class=" well">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            
            //'nome',
            [
                'attribute' =>'nome', 
                'headerOptions' => ['style'=>'text-align:center; width: 180px'],
                'contentOptions'=>['align' => 'center']
            ],
            //'descricao',
            [
                'attribute' => 'descricao',
                //'label' => 'Descricao',
                'headerOptions' => ['style'=>'text-align:center; width: 300px'],
                
            ],
            //'idSituacao',
            [
                'attribute' => 'idSituacao',
                'filter' => Situacao::dropdown(),
                'value' => function($model, $index, $dataColumn) {
                    $dropdown = Situacao::dropdown();
                    return $dropdown[$model->idSituacao];
                },
                'headerOptions' => ['style'=>'text-align:center; width: 100px'],
                'contentOptions'=>['align' => 'center']
            ],
            //'idAreaAtuacao',
            [
                'attribute' => 'idAreaAtuacao',
                'filter' => AreaAtuacao::dropdown(),
                'value' => function($model, $index, $dataColumn) {
                    $dropdown = AreaAtuacao::dropdown();
                    return $dropdown[$model->idAreaAtuacao];
                },
                'headerOptions' => ['style'=>'text-align:center; width: 250px'],
                'contentOptions'=>['align' => 'center']
            ],
            //'idSetor',
            /*[
                'attribute' => 'idSetor',
                'filter' => Setor::dropdown(),
                'value' => function($model, $index, $dataColumn) {
                    $dropdown = Setor::dropdown();
                    return $dropdown[$model->idSetor];
                },
                'headerOptions' => ['style'=>'text-align:center; width: 180px'],
                'contentOptions'=>['align' => 'center']
            ],*/
            // 'idPrograma',
            //'interdepartamental',
            [            
                'attribute' => 'interdepartamental',
                'format' => 'raw',
                'filter' => [1 => 'Sim', 0 => 'Não'],
                'value' => function($model, $index, $dataColumn) {
                    switch($model->interdepartamental){
                        case 1: return  '<p class="label label-success">Sim</p>';
                        case 0: return '<p class="label label-danger">Não</p>';
                    }
                },
                'headerOptions' => ['style'=>'text-align:center;'],
                'contentOptions'=>['align' => 'center']
            ],
            //'interinstitucional',
            [
                'attribute' => 'interinstitucional',
                'format' => 'raw',
                'filter' => [1 => 'Sim', 0 => 'Não'],
                'value' => function($model, $index, $dataColumn) {
                    switch($model->interinstitucional){
                        case 1: return  '<p class="label label-success">Sim</p>';
                        case 0: return '<p class="label label-danger">Não</p>';
                    }
                },
                'headerOptions' => ['style'=>'text-align:center;'],
                'contentOptions'=>['align' => 'center']
            ],
            // 'dataInicio',
            // 'dataFim',
            // 'observacoes',
            // 'idGestor',

            //['class' => 'yii\grid\ActionColumn'],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'headerOptions' => ['style'=>'text-align:center; width: 80px'],
                'contentOptions'=>['align' => 'center'],                
                'urlCreator' => function ($action, $model, $key, $index)  {
                    if ($action === 'view') {
                        $url = Yii::$app->urlManager->createUrl('programa-proger/view').'&s=1&idmodel='.$model->id; 
                        return $url;
                    }
                    if ($action === 'update') {
                        $url = Yii::$app->urlManager->createUrl('programa-proger/cadastrar').'&n=0&s=1&idmodel='.$model->id;
                        return $url;
                    }
                    if ($action === 'delete') {
                        $url = Yii::$app->urlManager->createUrl('programa-proger/delete').'&id='.$model->id;
                        return $url;
                    }
                }
            ],
        ],
    ]); ?>
</div>
</div>
