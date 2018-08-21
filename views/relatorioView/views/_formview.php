<?php

use yii\helpers\Html;
use \yii\helpers\ArrayHelper;
use kartik\widgets\FileInput;
use kartik\widgets\ActiveForm;
use kartik\field\FieldRange;
use kartik\datecontrol\DateControl;

/* @var $this yii\web\View */
/* @var $model app\models\Relatorio */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="resolucao-form">
    <h3>Novo Relatório</h3>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'populacaoAtingida')->textInput(['maxlength' =>4,'style' =>'width: 50%', 'placeholder'=>'Apenas números']) ?>

    <div style ="width: 50%">
    <?php
                    
                    echo FieldRange::widget([
                       'form' => $form,
                       'model' => $model,
                       'label' => 'Périodo',
                       'separator' => 'até',
                       'attribute1' => 'dataInicio',
                       'attribute2' => 'dataFim',                  
                       'type' => FieldRange::INPUT_WIDGET,
                       'widgetClass' => DateControl::classname(),
                       'widgetOptions1'=>[
                        'displayFormat'=>'dd/MM/yyyy',
                    ],
                    'widgetOptions2'=>[
                        'displayFormat'=>'dd/MM/yyyy'
                    ],
                      
                   ]);
        ?>
    </div>
    
    <?= $form->field($model, 'dataEntregaRelatorio', ['options' => ['style' =>'width: 20%']])->widget(DateControl::classname(), [        
        'displayFormat'=>'dd/MM/yyyy',
    ]);?>

    <!-- documentação fileinput kartik http://demos.krajee.com/widget-details/fileinput -->
    <?= $form->field($model, 'file', ['options' => ['style' =>'width: 50%']])->widget(FileInput::classname(), [
        'options' => ['accept' => '.pdf*'],
        'pluginOptions' => [
            //'initialPreview'=>[
                //Yii::$app->basePath.'/web/'.Yii::$app->params['caminhoRelatorio'].$model->idTipoProger.$model->idProger.'/'.$model->getFileNameRand(),
            //],
            'initialPreviewAsData'=>true,
            'initialCaption'=>$model->isNewRecord ?'Selecione um arquivo...':$model->getFileName(),
            'msgPlaceholder'=>'Selecione um arquivo...',
            'showUpload' => false,
            'showCancel' => false,
            'browseLabel' => 'Inserir arquivo',
            'removeLabel' => '',
        ]
    ]); ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Salvar' : 'Atualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>

</div>
