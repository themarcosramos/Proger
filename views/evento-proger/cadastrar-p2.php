
<?php

use yii\helpers\Html;
use app\widgets\fluxo;
use app\views\integrante\integranteWidget;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use app\models\TipoVinculo;
use app\models\TipoFuncao;
use app\models\Instituicao;
use app\models\Setor;
use app\models\Curso; 
use app\models\Cidade; 
use app\models\Estado; 
use app\models\Pessoa; 
use app\models\Integrante; 
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\Pessoa */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Evento: '.$nome
?>

<h1>Evento <?= $nome?></h1>

<?= Fluxo::widget(['index'=>2, 'novo'=>$novo, 'action'=>'evento-proger/cadastrar', 'idmodel'=>$idmodel]); ?>

<!-- Se formType == 1, renderiza o gridview de integrantes relaconado ao projeto, caso contrario nao renderiza nada -->
<?= !$formType? IntegranteWidget::widget(['type'=>'gridview','controller'=>'evento-proger','idmodel'=>$idmodel, 'idTipoProger'=>$integrante->idTipoProger, 'novo'=>$novo]):''?>

<div class="well"> 
    <!-- Aqui é decidido qual form será renderizado -->
    <?php 
        if($formType)
            echo IntegranteWidget::widget(['pessoa'=>$pessoa]); 
        else
            echo IntegranteWidget::widget(['integrante'=>$integrante, 'controller'=>'evento-proger', 'updateIntegrante'=>$updateIntegrante, 'cpf'=>$cpf,'idmodel'=>$idmodel, 'novo'=>$novo, ]); 
    ?>
    <!-- Botoes de voltar e avancar so aparecem se o formType for 0 -->
    <div class="form-group" style="display:<?= $formType? 'none': 'block'?>">           
         <a href="?r=evento-proger/cadastrar&n=<?= $novo?>&s=1&idmodel=<?php echo $idmodel?>"><button class="btn btn-warning">Voltar(Etapa 1)</button></a>
  
        
         <?=(\app\models\Integrante::find()->where(['idProger'=>$idmodel, 'idTipoProger'=>$integrante->idTipoProger])->all()!=null)? Html::a(Html::button ('Avançar (Etapa 3)', ['class' => 'btn btn-warning','title'=>"Esta ação não salva dados, certifique-se de salvar os dados antes de prosseguir"]), ['/evento-proger/cadastrar','n'=>$novo, 's'=>3,'idmodel'=>$idmodel]):''?>

    </div>
    <!-- Botão cancelar só surge se o formType = 1 -->
    <div class="form-group" style="display:<?= $formType? 'block': 'none'?>">  
        <a href="?r=evento-proger/cadastrar&n=<?= $novo?>&s=2&idmodel=<?php echo $idmodel?>"><button class="btn btn-warning">Cancelar</button></a>
    </div>
</div>
<div>    
    <?= Html::a('Ver Eventos', ['/evento-proger/index'],['class'=>'btn btn-info  btn']) ?>
</div>