<?php

use yii\helpers\Html;
use app\widgets\fluxo;
use yii\helpers\Url;
use app\views\resolucaoproger\resolucaoWidget;
use app\views\municipios\municipiosAbrangidosWidget;
/* @var $this yii\web\View */
/* @var $model app\models\Resolucao */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Evento: '.$nome;
?>
<script language="javascript"> 
  function finalizado(){
    alert ('cadastro realizado com sucesso!');

}

</script>

<h1>Evento <?= $nome?></h1>
<?= Fluxo::widget(['index'=>5, 'novo'=>$novo, 'action'=>'evento-proger/cadastrar', 'idmodel'=>$idmodel]); ?>
<!-- gridview de resolucaoProger -->

<div>


<!-- renderiza a gridview de municipios abrangidos e campos de cidade e estado se nao for um novo projeto -->
<div style="width:50%">
    <?= municipiosAbrangidosWidget::widget(['type'=>'gridview','controller'=>'evento-proger','idmodel'=>$idmodel, 'idTipoProger'=>$tipoProger, 'novo'=>$novo]) ?>
</div>

<div class="well">    
    <?= municipiosAbrangidosWidget::widget(['model'=> $municipio])?>

    <div class="form-group">           
         <a href="?r=evento-proger/cadastrar&n=<?= $novo?>&s=4&idmodel=<?php echo $idmodel?>"><button class="btn btn-warning">Voltar(Etapa 4)</button></a>
        

         <?= Html::a(Html::button('Concluir', ['class' => 'btn btn-warning','onclick'=>'js:finalizado();']), ['/evento-proger/index'])?>
    </div>
</div>
    <?= Html::a('Ver Eventos', ['/evento-proger/index'],['class'=>'btn btn-info  btn']) ?>