<?php

use yii\helpers\Html;
use app\widgets\fluxo;
use yii\helpers\Url;
use app\views\resolucaoproger\resolucaoWidget;
use app\views\municipios\municipiosAbrangidosWidget;

/* @var $this yii\web\View */
/* @var $model app\models\Resolucao */
/* @var $form yii\widgets\ActiveForm */


$this->title = 'Projeto: '.$nome;
?>

<script language="javascript"> 
  function finalizado(){
    alert ('cadastro realizado com sucesso!');

}

</script>

<h1>Projeto <?= $nome?></h1>
<?= Fluxo::widget(['index'=>5, 'novo'=>$novo, 'action'=>'projeto-proger/cadastrar', 'idmodel'=>$idmodel]); ?>
<!-- gridview de resolucaoProger -->

<div>

<!-- renderiza a gridview de municipios abrangidos e campos de cidade e estado se nao for um novo projeto -->
<div style="width:50%">
    <?= municipiosAbrangidosWidget::widget(['type'=>'gridview','controller'=>'projeto-proger','idmodel'=>$idmodel, 'idTipoProger'=>$tipoProger, 'novo'=>$novo]) ?>
</div>

<div class="well">    
    <?= municipiosAbrangidosWidget::widget(['model'=> $municipio])?>

    <div class="form-group">           
         <a href="?r=projeto-proger/cadastrar&n=<?= $novo?>&s=4&idmodel=<?php echo $idmodel?>"><button class="btn btn-warning">Voltar(Etapa 4)</button></a>
         
         <?= Html::a(Html::button('Concluir', ['class' => 'btn btn-warning','onclick'=>'js:finalizado();']), ['/projeto-proger/index'])?>
    </div>
</div>
    <?= Html::a('Ver Projetos', ['/projeto-proger/index'],['class'=>'btn btn-info  btn']) ?>