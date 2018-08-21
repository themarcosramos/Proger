<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Gestor;
use kartik\widgets\DatePicker;
use app\models\Setor;
use app\models\Situacao;
use app\models\AreaAtuacao;
use app\models\TipoProger;


/* @var $this yii\web\View */
/* @var $searchModel app\models\search\CursoProgerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Curso Proger';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="curso-proger-index">

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
                'attribute' => 'nome',
                //'label' => 'Situação',
                'headerOptions' => ['style'=>'text-align:center; width: 180px;'],
                'contentOptions'=>['align' => 'center']
            ],
            //'descricao',
            [
                'attribute' => 'descricao',
                //'label' => 'Descricao',
                'headerOptions' => ['style'=>'text-align:center;'],
                'contentOptions'=>['align' => 'center']
            ],
            //'idSituacao',
            [
                'attribute' => 'idSituacao',
                'filter' => Situacao::dropdown(),
                'value' => function($model, $index, $dataColumn) {
                    $dropdown = Situacao::dropdown();
                    return $dropdown[$model->idSituacao];
                },
                'headerOptions' => ['style'=>'text-align:center; width: 120px;'],
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
                'headerOptions' => ['style'=>'text-align:center; width: 250px;'],
                'contentOptions'=>['align' => 'center']
            ],
            // 'idSetor',
            // 'interdepartamental',
            /*[
                'attribute' => 'interdepartamental',
                'format' => 'raw',
                'label' => 'Interdepartamental',
                'filter' => [1 => 'Sim', 0 => 'Não'],
                'value' => function($model, $index, $dataColumn) {
                    switch($model->interdepartamental){
                        case 1: return  '<p class="label label-success">Sim</p>';
                        case 0: return '<p class="label label-danger">Não</p>';
                    }
                },
                'headerOptions' => ['style'=>'text-align:center;'],
                'contentOptions'=>['align' => 'center']
            ],*/
            // 'interinstitucional',
            /*[
                'attribute' => 'interinstitucional',
                'format' => 'raw',
                'label' => 'Interinstitucional',
                'filter' => [1 => 'Sim', 0 => 'Não'],
                'value' => function($model, $index, $dataColumn) {
                    switch($model->interinstitucional){
                        case 1: return  '<p class="label label-success">Sim</p>';
                        case 0: return '<p class="label label-danger">Não</p>';
                    }
                },
                'headerOptions' => ['style'=>'text-align:center; '],
                'contentOptions'=>['align' => 'center']
            ],*/

           /* [
                'attribute' => 'cargaHoraria',
                //'label' => 'Carga Horaria',
                'headerOptions' => ['style'=>'text-align:center; width: 150px; '],
                'contentOptions'=>['align' => 'center']
            ],*/

            //'dataInicio',
            //'dataFim',
            // 'observacoes',
            // 'idTipoProger',
            [
                'attribute' => 'idTipoProger',
                'filter' => TipoProger::dropdown(),
                'value' => function($model, $index, $dataColumn) {
                    if($model->idTipoProger == true){
                    $dropdown = TipoProger::dropdown();
                    return $dropdown[$model->idTipoProger];
                    }else{
                        return '';
                    }
                },
                'headerOptions' => ['style'=>'text-align:center; width: 180px;'],
                'contentOptions'=>['align' => 'center']
            ],
            // 'idProger',
            // 'idGestor',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'headerOptions' => ['style'=>'text-align:center; width: 80px'],
                'contentOptions'=>['align' => 'center'],               
                'urlCreator' => function ($action, $model, $key, $index) {
                    if ($action === 'view') {
                        $url = Yii::$app->urlManager->createUrl('curso-proger/view').'&s=1&idmodel='.$model->id; 
                        return $url;
                    }
                    if ($action === 'update') {
                        $url = Yii::$app->urlManager->createUrl('curso-proger/cadastrar').'&n=0&s=1&idmodel='.$model->id;
                        return $url;
                    }
                    if ($action === 'delete') {
                        $url = Yii::$app->urlManager->createUrl('curso-proger/delete').'&id='.$model->id;
                        return $url;
                    }
                }
            ],
        ],
    ]); 

?>

</div>
</div>
