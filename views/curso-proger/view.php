<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\helpers\Url;
use app\widgets\fluxo;
use app\models\Setor;
use app\models\Situacao;
use app\models\TipoEncargo;
use app\models\AreaAtuacao;
use app\models\TipoProger;
use app\models\Gestor;
use app\models\Pessoa;

$this->registerJs("$(function() {
    $('#popupModal').click(function(e) {
      e.preventDefault();
      $('#modal').modal('show').find('.modal-content')
      .load($(this).attr('href'));
    });
 });");

/* @var $this yii\web\View */
/* @var $model app\models\CursoProger */

$this->title = $nomeCurso;
$this->params['breadcrumbs'][] = ['label' => 'Cursos', 'url' => ['index']];
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
        <?php echo Html::a('<i class="fa glyphicon glyphicon-hand-up"></i> Gerar Relatório', ['/mpdf/curso', 'id' => $idmodel], [
    'class'=>'btn btn-danger', 
    'target'=>'_blank', 
    'data-toggle'=>'tooltip', 
    'title'=>'Gerar Relatório'
]); ?>
    </p>

    <?= Fluxo::widget(['index'=>$salto, 'novo'=>false, 'action'=>'curso-proger/view', 'idmodel'=>$idmodel]); ?>


    <!-- visualização das informações do curso -->
    <?= ($salto == 1)?DetailView::widget([
        'model' => $model,
        'template' => '<tr><th style="text-align: left; width: 15%">{label}</th><td>{value}</td></tr>',        
        'attributes' => [
            //'id',
            [
                'attribute'=> 'nome',
            ],
            [
                'attribute' => 'idTipoEncargo',
                'value' => TipoEncargo::findOne($model->idTipoEncargo)->nome,
            ],
            [
                'attribute'=> 'descricao',
            ],
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
            'cargaHoraria',
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
            //'idTipoProger',
            [
                'attribute' => 'idTipoProger',
                'value' => function($model) {
                    if($model->idTipoProger == true){
                   return TipoProger::findOne($model->idTipoProger)->nome;
                }else{

                    return '';
                }
            }
            ], 
            //'idProger',
            /*[
                'attribute' => 'idProger',
                'label' => 'Situação',
                'value' => Situacao::findOne($model->idProger)->nome,
            ],*/
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
        $n=0;$size=sizeof($model);
        echo "<br><b>$size integrantes</b><br><br>";
        foreach($model as &$integrante){
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
        'dataProvider' => $model,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            [
                'header'=>'Plan Info',
                'value'=> function($model)
                { 
                    global $obj;
                    $obj = $model;
                    return  Html::a(Yii::t('app', ' '), ['nada','id'=>$model->id], ['class' => 'glyphicon glyphicon-eye-open', 'id' => 'popupModal']);      
                },
                 'format' => 'raw'
            ],
        ],
    ])
    
:''?>
<div >
<?php 

Modal::begin([
    'id'     => "modal",
    'header' => '<h3>Assign Farmers to other Farm Mitra</h3>',
    'toggleButton' => false,
]);
global $obj;
switch ($salto) {
    case 3:
        echo "<div><h1>Deu certo!</h1></div>";
        echo DetailView::widget([
            'model' => $obj,
            'attributes' => [
                'populacaoAtingida',
                'dataInicio',
                'dataFim',
                [
                    'attribute' => 'urlArquivo',
                    'value' => $obj->getFileName(),
                ],
            ],
        ]);
        break;
    
    default:
        # code...
        break;
}
Modal::end();
?>
</div>

<!-- visualização das informações dos financiamentos -->
<?= ($salto == 4)?GridView::widget([
        'dataProvider' => $model,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
        ],
    ]):''?>

<!-- visualização das informações das resoluções e municipios abrangidos -->
<?php 
    if($salto == 5){
        echo GridView::widget([
            'dataProvider' => $model1,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'id',
            ],
        ]);
        echo GridView::widget([
            'dataProvider' => $model2,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'id',
            ],
        ]);
    }
?>

</div>


</div>
