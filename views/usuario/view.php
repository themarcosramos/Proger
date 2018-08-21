<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\data\ArrayDataProvider;

/* @var $this yii\web\View */
/* @var $model app\models\Usuario */

$this->title = 'Usuário';
$this->params['breadcrumbs'][] = ['label' => 'Segurança', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Usuários', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->nome;
?>

<div class="well">

    <h1><?= Html::encode($this->title) ?></h1>

    <hr style="height:1px; border:none; background-color:#D0D0D0; margin-top: 10px; margin-bottom: 15px;" />

    <p>
        <?php if(Yii::$app->user->can('editar-usuario')){ ?>
            <?= Html::a('Editar', ['update', 'id' => $model->idUsuario], ['class' => 'btn btn-primary']) ?>
        <?php } ?>

        <?php if(Yii::$app->user->can('excluir-usuario')){ ?>
            <?= Html::a('Excluir', ['delete', 'id' => $model->idUsuario], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Tem certeza que deseja remover este usuário?',
                    'method' => 'post',
                ],
            ]) ?>
        <?php } ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'template' => '<tr><th style="text-align: right; width: 15%">{label}</th><td>{value}</td></tr>',
        'attributes' => [
            'idUsuario',
            [
                'attribute' => 'grupo.descricao',
                'label' => 'Grupo',
            ],
            'nome',
            'login',
            [
                'attribute' => 'situacao',
                'value' => $model->getSituacao(),
                'label' => 'Situação',
            ],
           
            [
                'attribute' => 'email',
                'label' => 'E-mail',
            ],

        ],
    ]) ?>


    <?php
       // var_dump($gestores);
       // die();
    ?>

    <?php
        $provider = new ArrayDataProvider([
        'allModels' => $gestores,
        'pagination' => [
            'pageSize' => 10,
        ],
        'sort' => [
            'attributes' => ['nome'],
        ],
    ]);
    ?>

    <label>Setores de Gestão: </label>

    <?= GridView::widget([
        'dataProvider' => $provider,
    ]) ?>

     





    

</div>
