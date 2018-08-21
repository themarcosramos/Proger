<?php

use yii\helpers\Html;
use app\widgets\fluxo;
use app\views\financiamento\financiamentoWidget;
use yii\data\ActiveDataProvider;
use app\models\ProgramaProger;
use app\models\Gestor;
use app\models\Financiadora;
use app\models\Financiamento;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\ProjetoProger */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Projeto: '.$nome;

/*  tela de  cadastro da 4 etapa  do fluxo */
?>
<h1>Projeto <?= $nome?></h1>

<?= Fluxo::widget(['index'=>4, 'novo'=>$novo, 'action'=>'projeto-proger/cadastrar', 'idmodel'=>$idmodel]); // nesta linha vai carrega o fluxo de forma generica ?>

<?= financiamentoWidget::widget(['type'=>'gridview','controller'=>'projeto-proger','idmodel'=>$idmodel, 'idTipoProger'=>$model->idTipoProger, 'novo'=>$novo]); // nesta linha vai carrega de forma generica a gridview com os financiamento já cadastrados ?>
       
<div class="well"> 
    <?= financiamentoWidget::widget(['model'=>$model]);// nesta linha vai carregar o formulario de cadastro de financiamento  ?>
    <div class="form-group">             
        <a href="?r=projeto-proger/cadastrar&n=<?= $novo?>&s=3&idmodel=<?php echo $idmodel?>"><button class="btn btn-warning">Voltar(Etapa 3) </button></a>   
    
        <?=Html::a(Html::button ('Avançar (Etapa 5)', ['class' => 'btn btn-warning','title'=>"Esta ação não salva dados, certifique-se de salvar os dados antes de prosseguir"]), ['/projeto-proger/cadastrar','n'=>$novo, 's'=>5,'idmodel'=>$idmodel])?>

    </div>
</div>  
<div>
    <?= Html::a('Ver Projetos', ['/projeto-proger/index'],['class'=>'btn btn-info  btn']) ?>
</div>
