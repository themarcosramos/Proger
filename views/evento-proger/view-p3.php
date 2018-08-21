<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \yii\helpers\ArrayHelper;
use kartik\widgets\DatePicker;
use yii\helpers\Url;
use app\models\Edicao;
use yii\bootstrap\Alert;
use app\widgets\fluxo;
use app\views\relatorioView\relatorioViewWidget;

$this->title = 'Evento: '.$nome;
?>

<h1>Evento <?= $nome?></h1>
<?= fluxo::widget(['index'=>3, 'novo'=>$novo, 'action'=>'evento-proger/view', 'idmodel'=>$idmodel]); ?>
<!-- gridview de relatorios -->
<div class="well">
    <?= relatorioViewWidget::widget(['type'=>'gridview','controller'=>'evento-proger','idmodel'=>$idmodel, 'idTipoProger'=>$model->idTipoProger, 'novo'=>$novo]); ?>


    <div class="form-group">           
        <a href="?r=evento-proger/view&n=<?= $novo?>&s=2&idmodel=<?php echo $idmodel?>"><button class="btn btn-warning">Voltar(Etapa 2)</button></a>
       
        <?= Html::a(Html::button ('Avançar (Etapa 4)', ['class' => 'btn btn-warning']), ['/evento-proger/view','n'=>$novo, 's'=>4,'idmodel'=>$idmodel])?>

    </div>
</div>
<div>
    <?= Html::a('Ver Eventos', ['/evento-proger/index'],['class'=>'btn btn-info  btn']) ?>
</div>