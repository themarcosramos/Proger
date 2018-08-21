<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Pais;

/* @var $this yii\web\View */
/* @var $model app\models\Estado */

$this->title = $model->nome;
$this->params['breadcrumbs'][] = ['label' => 'Estados', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="estado-view">

    <h1><?= Html::encode($this->title) ?></h1>

     <p>
        <?= Html::a('Atualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Excluir', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Você tem certeza que deseja excluir este item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
           // 'id',
            'nome',
            'sigla',
            //'idPais',
            [
                'attribute' => 'idPais',
                'value' => Pais::findOne($model->idPais)->nome,
            ], 
            [            
                'attribute' => 'ativo',                
                'value' => $model->getAtivo(),
            ],        
        ],
    ]) ?>

</div>
