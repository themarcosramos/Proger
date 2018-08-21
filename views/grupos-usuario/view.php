<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use app\models\AuthItemChild;

/* @var $this yii\web\View */
/* @var $model app\models\GruposUsuario */
/* @var $searchModel app\models\search\MovimentoSemCotasSearch */

$this->title = $model->descricao;
$this->params['breadcrumbs'][] = ['label' => 'Segurança', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Grupos de Usuário', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="well">

    <h1><?= Html::encode($this->title) ?></h1>

    <hr style="height:1px; border:none; background-color:#D0D0D0; margin-top: 10px; margin-bottom: 15px;" />

    <?php if(Yii::$app->user->can('editar-grupodeusuario')){ ?>
        <p>
            <?= Html::a('Editar', ['update', 'id' => $model->name], ['class' => 'btn btn-primary']) ?>
        </p>
    <?php } ?>

    <?= DetailView::widget([
        'model' => $model,
        'template' => '<tr><th style="text-align: right; width: 15%">{label}</th><td>{value}</td></tr>',
        'attributes' => [
            'name',
            'descricao',
        ],
    ]) ?>

    <label>Permissões: </label>

    <?php 

        $childs = AuthItemChild::find()->where(['parent' => $model->name])->all();

        $permissoes = null;

        foreach ($childs as $key => $value) {

            $permissoes[$key] = ['name' => $value->childAuthItem['name'], 'descricao' => $value->childAuthItem['description']];

        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => $permissoes,
            'sort' => [
                'attributes' => ['name', 'descricao'],
            ],
            'key' => 'name',
            'pagination' => [
                'pageSize' => 40,
            ],
        ]);

        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                //['class' => 'yii\grid\SerialColumn'],
                /*[
                    'attribute' => 'name',
                    'label' => 'ID',
                    'headerOptions' => ['style'=>'text-align:center'],
                    'contentOptions'=>['align' => 'center', 'style'=>'width: 300px;'],
                ],*/
                [
                    'attribute' => 'descricao',
                    'label' => 'Permissões',
                    'headerOptions' => ['style'=>'text-align:center'],
                    'contentOptions'=>['align' => 'left', 'style'=>'width: 650px;'],
                ],

            ],
        ]);

    ?>

</div>
