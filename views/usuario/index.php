<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\GruposUsuario;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel app\models\search\UsuarioSearch */

$this->title = 'Usuários';
$this->params['breadcrumbs'][] = ['label' => 'Segurança', 'url' => ['usuario/index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="well">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php  //echo $this->render('_search', ['model' => $searchModel]); ?>

    <hr style="height:1px; border:none; background-color:#D0D0D0; margin-top: 10px; margin-bottom: 15px;" />

    <?php if(Yii::$app->user->can('gerenciar-usuario')){ ?>
        <p style="margin-bottom: 20px;">
            <?= Html::a('Novo Usuário', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    <?php } ?>

    <!-- Aqui é  exibido uma mensagem caso a tentativa de exclusão de um usuário não tenha ocorrido-->
    <?php if(Yii::$app->session->hasFlash('erro')):?>
        <div class="alert-danger alert fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <?= Yii::$app->session->getFlash('erro'); ?>
        </div>
    <?php endif; ?>

    <div class="well">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                //['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute' => 'idUsuario',
                    'headerOptions' => ['style'=>'text-align:center'],
                    'contentOptions'=>['align' => 'center', 'style'=>'width: 80px;'],
                ],
                [
                    'attribute' => 'nome',
                    'headerOptions' => ['style'=>'text-align:center'],
                    'contentOptions'=>['align' => 'center', 'style'=>'width: 350px;'],
                ],
                [
                    'attribute' => 'login',
                    'headerOptions' => ['style'=>'text-align:center'],
                    'contentOptions'=>['align' => 'center', 'style'=>'width: 250px;'],
                ],
                [
                    'attribute' => 'nameGrupo',
                    'label' => 'Grupo',
                    'filter' => GruposUsuario::dropdown(),
                    'value' => function($model, $index, $dataColumn) {
                        $dropdown = GruposUsuario::dropdown();
                        return $dropdown[$model->nameGrupo];
                    },
                    'headerOptions' => ['style'=>'text-align:center'],
                    'contentOptions'=>['align' => 'center', 'style'=>'width: 280px;'],
                ],

                [
                    'attribute' => 'situacao',
                    'format' => 'raw',
                    'filter' => [1 => 'Ativo', 0 => 'Inativo'],
                    'value' => function($model, $index, $dataColumn) {
                        switch($model->situacao){
                            case 1: return  '<p class="label label-success">Ativo</p>';
                            case 0: return '<p class="label label-default">Inativo</p>';
                        }
                    },
                    'headerOptions' => ['style'=>'text-align:center'],
                    'contentOptions'=>['align' => 'center', 'style'=>'width: 130px;']
                ],

                ['class' => 'yii\grid\ActionColumn', 
                    'contentOptions'=> [
                        'align' => 'center',
                        'style'=>'width: 100px;',
                    ],
                    'template' => '{view} {update}',
                    'buttons' => [
                        'update' => function ($url, $model) {
                            return Yii::$app->user->can('gerenciar-usuario') === true ? Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, ['title' => 'Editar']) : '';
                        },
                        'view' => function ($url, $model) {
                            return Yii::$app->user->can('gerenciar-usuario') === true ? Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, ['title' => 'Visualizar']) : '';
                        }
                    ],
                ],
            ],
        ]); ?>
    </div>

</div>

