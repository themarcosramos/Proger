<?php
use yii\helpers\Html;
use \yii\helpers\ArrayHelper;
use kartik\money\MaskMoney;
use yii\helpers\Url;
use app\models\Financiadora;
use app\models\Edital;
use app\widgets\fluxo;
use kartik\widgets\ActiveForm;
use kartik\field\FieldRange;
use kartik\datecontrol\DateControl;

/* @var $this yii\web\View */
/* @var $model app\models\Financiamento */
/* @var $form yii\widgets\ActiveForm */

?>

<h3>Novo Financiamento </h3>
<br/>
<div class="row" > 

    <?php $form = ActiveForm::begin(); ?>

    <div class="col-sm-4 col-md-12" > 

      <?= $form->field($model, 'idFinanciadora')->dropDownList(ArrayHelper::map(Financiadora::find()->orderBy('nome')->where(['ativo' => 1])->all(),'id','nome'),['prompt'=>'Selecione  uma financiadora','style' =>'width: 50%']); //Através desta linha de código vai aparecer para usuário selecionar qual é a financiadora  ?>
        
      <?= $form->field($model, 'edital')->textInput(['maxlength' =>100,'style' =>'width: 50%' ]) // Através das linhas de código anteriores permite com que o usuário tenha uma caixa de texto para colocar o edital do financiamento. ?>
        
      <div class="form-group", style ="width: 20%">
            <?=$form->field($model, 'valorAprovado')->widget(MaskMoney::classname(), [
                'pluginOptions' => [
                'prefix' => 'R$ ',
                //'suffix' => ' c',
                'affixesStay' => true,
                'thousands' => '.',
                'decimal' => ',',
                'precision' => 2, 
                'allowZero' => false,
                'allowNegative' => false,
                ]
            ]);
            // Através das linhas de código a cima faz com que o usuário, possa inserir o valor que foi aprovado, forma monetária. ?>
       </div>
          
               
     <?php $model->ativo ?>
                <?= //$form->field($model, 'ativo')->textInput()     
                $form->field($model, 'ativo')->radioList(array('1'=>'Sim','0'=>'Não'));
     ?>
    
    <div style ="width: 50%">               
                <?php
                    
                     echo FieldRange::widget([
                        'form' => $form,
                        'model' => $model,
                        'label' => 'Duração',
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
               //Através das linhas de código a cima faz com o usuário, possa inserir a data de início e fim formado assim o período do financiamento .  ?>
        </div> 
         <br/>
         <br/>
            <?= $form->field($model, 'observacao')
            ->textArea(['maxlength' =>500 ,'style' =>'width: 50%']) // Através das linhas de código anteriores permite com que o usuário tenha uma caixa de texto para colocar uma observação em relação ao financiamento. ?>
        
          <div class="form-group">
          
              <?= Html::submitButton($model->isNewRecord ? 'Salvar' : 'Atualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary' ,'size' => '100px']) ?>
         </div>

    </div> 

    <?php ActiveForm::end(); ?>
    
</div>
