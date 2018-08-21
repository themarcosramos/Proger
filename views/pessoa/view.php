<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\Button;
use app\models\Integrante;
use app\models\TipoProger;
use app\models\ProgramaProger;
use app\models\ProjetoProger;
use app\models\CursoProger;
use app\models\EventoProger;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Pessoa */

$this->title = $model->nome;
$this->params['breadcrumbs'][] = ['label' => 'Pessoas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

    <h1><?= Html::encode($this->title) ?></h1>

    <hr style="height:1px; border:none; background-color:#D0D0D0; margin-top: 10px; margin-bottom: 15px;" />

    


<div class="well">

    <p>   


    <?= Html::a('Atualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>    
  
    </p>  
   
    <div class="row"> 
        <div class=" col-sm-3 col-md-5">
     
        <?= DetailView::widget([
        'model' => $model,
        'template' => '<tr><th style="text-align: right; width: 2%">{label}</th><td>{value}</td></tr>',
        'attributes' => [
            //'id',
            [
                'attribute'=> 'nome',
                'label' => 'Nome:',
                'contentOptions'=>['align' => 'center']
            ],
            [
                'attribute'=> 'cpf',
                'label' => 'CPF:',
                'contentOptions'=>['align' => 'center']
            ],
            [
                'attribute'=> 'rg',
                'label' => 'RG:',
                'contentOptions'=>['align' => 'center']
            ],
            [
                'attribute'=> 'email',
                'label' => 'Email:',
                'contentOptions'=>['align' => 'center']
            ],
            [
                'attribute'=> 'telefone',
                'label' => 'Telefone:',
                'contentOptions'=>['align' => 'center']
            ],
            [
                'attribute'=> 'celular',
                'label' => 'Celular:',
                'contentOptions'=>['align' => 'center']
            ],
            [
                'attribute'=> 'cep',
                'label' => 'CEP:',
                'contentOptions'=>['align' => 'center']
            ],
            [
                'attribute'=> 'rua',
                'label' => 'Rua:',
                'contentOptions'=>['align' => 'center']
            ],
            [
                'attribute'=> 'numero',
                'label' => 'Número:',
                'contentOptions'=>['align' => 'center']
            ],
            [
                'attribute'=> 'bairro',
                'label' => 'Bairro:',
                'contentOptions'=>['align' => 'center']
            ],            
            [
                'attribute' => 'idCidade0.nome',
                'label' => 'Cidade:',
                'contentOptions'=>['align' => 'center']
            ],
            [
                'attribute' => 'idEstado0.nome',
                'label' => 'Estado:',
                'contentOptions'=>['align' => 'center']
            ],
        ],
    ]) ?>
    </div>
    
    <div class=" col-sm-3 col-md-7">
        <h3>  Vínculos: </h3>
            <?php

               
                $integrantes = new ActiveDataProvider([
                        'query' => Integrante::find()->where([ 'idPessoa'=> $model->id]),
                        'pagination' => ['pageSize' => 3],
                        ]);
               
                
                echo GridView::widget([
                'dataProvider' => $integrantes,
                'columns' => [
               // ['class' => 'yii\grid\SerialColumn'],
               
            [
                'attribute'=> 'id',
                'headerOptions' => ['style'=>'text-align:center; width: 20px;'],
                'contentOptions'=>['align' => 'center']
            ],

           
            [
                'attribute'=> 'idTipoProger',
                'value'=>'idTipoProger0.nome',
                'headerOptions' => ['style'=>'text-align:center; width: 20px;'],
                'contentOptions'=>['align' => 'center']
            ],

            [
                'attribute'=> 'idProger',
                'label'=> 'Proger',
                'value' => function($integrantes, $index, $dataColumn) {
                  
                    switch($integrantes->idTipoProger){

                        case 1: $proger = ProgramaProger::find()->where(['id'=> $integrantes->idProger])->one();                    
                        
                          return $proger->nome;

                        case 2: $proger = ProjetoProger::find()->where(['id'=> $integrantes->idProger])->one();                    
                         
                          return $proger->nome;

                        case 3: $proger = CursoProger::find()->where(['id'=> $integrantes->idProger])->one();                    
                           
                          return $proger->nome;

                        case 4: $proger = EventoProger::find()->where(['id'=> $integrantes->idProger])->one();                    
                            
                          return $proger->nome;
                       
                    }
                },                          
                'headerOptions' => ['style'=>'text-align:center; width: 100px;'],
                'contentOptions'=>['align' => 'center']
            ],

            [
                'attribute' => 'dataInicio',
                'format'=>['date','dd/MM/yyyy'],
                'headerOptions' => ['style'=>'text-align:center;'],
                'contentOptions'=>['align' => 'center']
            ],

            [
                'attribute' => 'dataFim',
                'format'=>['date','dd/MM/yyyy'],
                'headerOptions' => ['style'=>'text-align:center;'],
                'contentOptions'=>['align' => 'center']
            ],


            [            
                'attribute' => 'ativo',
                'format' => 'raw',                
                'value' => function($integrantes, $index, $dataColumn) {
                    switch($integrantes->ativo){
                        case 1: return '<p class="label label-success">Sim</p>';
                        case 0: return '<p class="label label-danger">Não</p>';
                    }
                },
                'headerOptions' => ['style'=>'text-align:center; width: 100px;'],
                'contentOptions'=>['align' => 'center']
            ],

                       
            /*[

             'class' => 'yii\grid\ActionColumn',
             'headerOptions' => ['style'=>'text-align:center; width: 100px;'],
             'contentOptions'=>['align' => 'center'],
             'template' => '  {link}',     
            
        ],*/

                ],
        ]) ?>
            
        
    </div>  
    </div>
   
    

</div> 


    
    
 

