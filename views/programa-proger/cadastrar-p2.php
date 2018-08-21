<?php
use yii\helpers\Html;
use app\views\integrante\integranteWidget;
use app\widgets\fluxo;

//Variaveis passadas pelo controller

/* @var $pessoa app\models\Pessoa  model*/
/* @var $integrante app\models\Integrante model */
/* @var $formType (int) indica qual view será renderizada. 1 para o form de pessoa, 0 para o gridview e form de integrante*/
/* @var $cpf (int) quando o controler passa formType 0, deve passar tb o cpf da pessoa*/
/* @var $idmodel (int) id do projeto */
/* @var $nome (string) nome do projeto */
/* @var $novo (boolean) true se for create, false se for update */

//actions que renderizam esta view:
//cadastrar
//create-pessoa

$this->title = 'Programa: '.$nome;
?>

<h1>Programa <?= $nome?></h1>

<?= Fluxo::widget(['index'=>2, 'novo'=>$novo, 'action'=>'programa-proger/cadastrar', 'idmodel'=>$idmodel]); ?>

<!-- Se formType == 1, renderiza o gridview de integrantes relaconado ao projeto, caso contrario nao renderiza nada -->
<?= !$formType? IntegranteWidget::widget(['type'=>'gridview','controller'=>'programa-proger','idmodel'=>$idmodel, 'idTipoProger'=>$integrante->idTipoProger, 'novo'=>$novo]):''?>

<div class="well"> 
    <!-- Aqui é decidido qual form será renderizado -->
    <?php 
        if($formType)
            echo IntegranteWidget::widget(['pessoa'=>$pessoa]); 
        else
            echo IntegranteWidget::widget(['integrante'=>$integrante, 'controller'=>'programa-proger', 'updateIntegrante'=>$updateIntegrante, 'cpf'=>$cpf,'idmodel'=>$idmodel, 'novo'=>$novo]); 
    ?>
    <!-- Botoes de voltar e avancar so aparecem se o formType for 0 -->
    
    <div class="form-group" style="display:<?= $formType? 'none': 'block'?>">           
         <a href="?r=programa-proger/cadastrar&n=<?= $novo?>&s=1&idmodel=<?php echo $idmodel?>"><button class="btn btn-warning">Voltar(Etapa 1)</button></a>
  
        
         <?=(\app\models\Integrante::find()->where(['idProger'=>$idmodel, 'idTipoProger'=>$integrante->idTipoProger])->all()!=null)? Html::a(Html::button ('Avançar (Etapa 3)', ['class' => 'btn btn-warning','title'=>"Esta ação não salva dados, certifique-se de salvar os dados antes de prosseguir"]), ['/programa-proger/cadastrar','n'=>$novo, 's'=>3,'idmodel'=>$idmodel]):''?>

    </div>
    <!-- Botão cancelar só surge se o formType = 1 -->
    <div class="form-group" style="display:<?= $formType? 'block': 'none'?>">  
        <a href="?r=programa-proger/cadastrar&n=<?= $novo?>&s=2&idmodel=<?php echo $idmodel?>"><button class="btn btn-warning">Cancelar</button></a>
    </div>
</div>
<div>    
    <?= Html::a('Ver Programa', ['/programa-proger/index'],['class'=>'btn btn-info  btn']) ?>
</div>