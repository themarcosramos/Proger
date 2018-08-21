<?php

use yii\helpers\Html;
use yii\grid\GridView;


/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Grupos de Usuário';
$this->params['breadcrumbs'][] = ['label' => 'Segurança', 'url' => ['grupos-usuario/index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="well">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php  //echo $this->render('_search', ['model' => $searchModel]); ?>

    <hr style="height:1px; border:none; background-color:#D0D0D0; margin-top: 10px; margin-bottom: 15px;" />

    <?php if(Yii::$app->user->can('gerenciar-usuario')){ ?>
        <p style="margin-bottom: 20px;">
            <?= Html::a('Novo Grupo', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    <?php } ?>

    <div class="well">

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'columns' => [
                //['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute' => 'name',
                    'label' => 'ID',
                    'headerOptions' => ['style'=>'text-align:center; width: 150px;'],
                    'contentOptions'=>['align' => 'center'],
                ],
                [
                    'attribute' => 'descricao',
                    'label' => 'Nome',
                    'headerOptions' => ['style'=>'text-align:center'],
                    'contentOptions'=>['align' => 'center'],
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
