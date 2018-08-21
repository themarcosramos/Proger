<?php

use yii\helpers\Html;
use app\widgets\fluxo;
use yii\data\ActiveDataProvider;
use app\models\ProgramaProger;
use app\models\Gestor;
use app\models\Financiadora;
use app\models\Financiamento;
use yii\grid\GridView;
use app\views\financiamentoView\financiamentoViewWidget;


/* @var $this yii\web\View */
/* @var $model app\models\ProjetoProger */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Evento: '.$nome;

/*  tela de  cadastro da 4 etapa  do fluxo */
?>
<h1>Evento <?= $nome?></h1>

<?= Fluxo::widget(['index'=>4, 'novo'=>$novo, 'action'=>'evento-proger/view', 'idmodel'=>$idmodel]); // nesta linha vai carrega o fluxo de forma generica ?>

<div class="well"> 
    <?= financiamentoViewWidget::widget(['type'=>'gridview','controller'=>'evento-proger','idmodel'=>$idmodel, 'idTipoProger'=>$model->idTipoProger, 'novo'=>$novo]); // nesta linha vai carrega de forma generica a gridview com os financiamento já cadastrados ?>
       

    <?= financiamentoViewWidget::widget(['model'=>$model]);// nesta linha vai carregar o formulario de cadastro de financiamento  ?>
    <div class="form-group">             
        <a href="?r=evento-proger/view&n=<?= $novo?>&s=3&idmodel=<?php echo $idmodel?>"><button class="btn btn-warning">Voltar(Etapa 3) </button></a>   
        
        <?=Html::a(Html::button ('Avançar (Etapa 5)', ['class' => 'btn btn-warning']), ['/evento-proger/view','n'=>$novo, 's'=>5,'idmodel'=>$idmodel])?>

    </div>
</div>  
<div>
    <?= Html::a('Ver Eventos', ['/evento-proger/index'],['class'=>'btn btn-info  btn']) ?>
</div>
