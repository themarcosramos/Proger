<?php

use yii\helpers\Html;
use app\widgets\fluxo;
use yii\helpers\Url;
use app\views\resolucaoproger\resolucaoWidget;
use app\views\municipiosview\municipiosAbrangidosViewWidget;
/* @var $this yii\web\View */
/* @var $model app\models\Resolucao */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Evento: '.$nome;
?>
</script>

<h1>Evento <?= $nome?></h1>
<?= Fluxo::widget(['index'=>5, 'novo'=>$novo, 'action'=>'evento-proger/view', 'idmodel'=>$idmodel]); ?>
<!-- gridview de resolucaoProger -->

<div>
<div class="well">  
<!-- renderiza a gridview de municipios abrangidos e campos de cidade e estado se nao for um novo projeto -->
    <div style="width:90%">
        <?= municipiosAbrangidosViewWidget::widget(['controller'=>'evento-proger','idmodel'=>$idmodel, 'idTipoProger'=>$tipoProger, 'novo'=>$novo]) ?>
    </div>

    <div class="form-group">           
         <a href="?r=evento-proger/view&n=<?= $novo?>&s=4&idmodel=<?php echo $idmodel?>"><button class="btn btn-warning">Voltar(Etapa 4)</button></a>
             
    </div>
</div>
    <?= Html::a('Ver Eventos', ['/evento-proger/index'],['class'=>'btn btn-info  btn']) ?>