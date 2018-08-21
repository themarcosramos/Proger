<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\grid\GridView;
use app\widgets\fluxo;
use app\models\Situacao;
use app\models\TipoEncargo;
use app\models\AreaAtuacao;
use app\models\Setor;
use app\models\Gestor;
use app\models\Pessoa;
use app\models\ProgramaProger;

/* @var $this yii\web\View */
/* @var $query app\models\ProjetoProger */

$this->title = $nomeProjeto;
$this->params['breadcrumbs'][] = ['label' => 'Projetos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$GLOBALS['obj'] = '';
?>
<div class="projeto-proger-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Atualizar', ['cadastrar', 'idmodel' => $idmodel,'s'=>1, 'novo'=>false], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Excluir', ['delete', 'id' => $idmodel], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Você tem certeza que deseja excluir este item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= Fluxo::widget(['index'=>$salto, 'novo'=>false, 'action'=>'projeto-proger/view', 'idmodel'=>$idmodel]); ?>

<!-- visualização das informações do projeto -->
    <?= ($salto == 1)?DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'nome',
            [
                'attribute' => 'idTipoEncargo',
                'value' => TipoEncargo::findOne($model->idTipoEncargo)->nome,
            ],
            'descricao',
            //'idSituacao',
            [
                'attribute' => 'idSituacao',
                'value' => Situacao::findOne($model->idSituacao)->nome,
            ],
            //'idAreaAtuacao',
            [
                'attribute' => 'idAreaAtuacao',
                'value' => AreaAtuacao::findOne($model->idAreaAtuacao)->nome,
            ],
            //'idSetor',
            [
                'attribute' => 'idSetor',
                'value' => Setor::findOne($model->idSetor)->nome,
            ],
            //'idPrograma',
            [
                'attribute' => 'idPrograma',
                'value' => (isset($model->idPrograma))?ProgramaProger::findOne($model->idPrograma)->nome: 'Não vinculado à nenhum programa.',
            ],
            //'interdepartamental',
            [            
                'attribute' => 'interdepartamental',                
                'value' => $model->getInterdepartamental(),                
            ],
            //'interinstitucional',
            [            
                'attribute' => 'interinstitucional',                
                'value' => $model->getInterinstitucional(),                
            ],
            //'dataInicio',
            [
                'attribute' => 'dataInicio',
                'value' => date_format(date_create($model->dataInicio), 'd/m/Y'),
            ],
            //'dataFim',
            [
                'attribute' => 'dataFim',
                'value' => date_format(date_create($model->dataFim), 'd/m/Y'),
            ],
            'observacoes',
            //'idGestor',
            [
                'attribute' => 'idGestor',
                'value' => Gestor::findOne($model->idGestor)->nome,
            ],
        ],
    ]):''?>

<!-- visualização das informações dos integrantes -->
<?php 
    if($salto == 2){
        $n=0;$size=sizeof($query);
        echo "<br><b>$size integrantes</b><br><br>";
        foreach($query as &$integrante){
            $n++;
            echo "<b>Integrante $n</b>";
            echo DetailView::widget([
                'model' => $integrante,
                'attributes' => [
                    [
                        'attribute' => 'idPessoa',
                        'value' => Pessoa::findOne($integrante->idPessoa)->nome,
                    ],
                    [
                        'label' => 'E-mail',
                        'value' => Pessoa::findOne($integrante->idPessoa)->email,
                    ],
                    'matricula',
                    'dataInicio',
                    'dataFim',
                    'cargaHoraria',
                ],
            ]);
        }
    }
?>

<!-- visualização das informações dos relatórios -->
<?= ($salto == 3)?GridView::widget([
        'dataProvider' => $query,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'populacaoAtingida',
            'dataEntregaRelatorio',
            'urlArquivo',
            [
                'label'=>'Detalhes',  
                'headerOptions' => ['style'=>'text-align:center;  width: 20px;'],         
                'contentOptions' => ['style'=>'text-align:center;'],  
                'format' => 'raw',
                'value'=> function($model){ 
                    return  Html::button('', ['value'=>Url::toRoute(['projeto-proger/detail-view', 'id'=>$model->id,'s'=>3]), 'class' => 'glyphicon glyphicon-eye-open', 'id' => 'modalButton']);      
                },
            ],
        ],
    ])
    
:''?>

<!-- visualização das informações dos financiamentos -->
<?= ($salto == 4)?GridView::widget([
        'dataProvider' => $query,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
        ],
    ]):''?>

<!-- visualização das informações das resoluções e municipios abrangidos -->
    <?php 
    if($salto == 5){
        echo GridView::widget([
            'dataProvider' => $query1,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'id',
            ],
        ]);
        echo GridView::widget([
            'dataProvider' => $query2,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'id',
            ],
        ]);
    }
    ?>
    <div >
    <?php 
        Modal::begin([
            'id'     => 'modal',
            'header' => '<h3>Detalhes</h3>',
            'size' => 'modal-lg'
        ]);
        echo "<div id='modalContent'></div>";
        Modal::end();
    ?>
    </div>
</div>
