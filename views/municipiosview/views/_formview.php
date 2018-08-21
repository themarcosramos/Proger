<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use \yii\helpers\ArrayHelper;
use app\models\Estado;
use app\models\MunicipiosAbrangidos;
$pessoa= new \app\models\Pessoa();

?>

<div class="resolucao-form">
   <?php $form = ActiveForm::begin(); ?>

   <div class="row" style="width:52.5%">         
        <div class="col-sm-3 col-md-6">             
            <?php
                $estado = ArrayHelper::map(Estado::find()->where(['ativo' => 1])->all(), 'id', 'nome');
                echo $form->field($pessoa, 'idEstado')->dropDownList(
                    $estado,
                    [
                        'prompt'=>'Selecione um estado',
                        'onchange'=>'$.get( "'.Url::toRoute('/integrante/cidade').'", { id: $(this).val()}).done(function(data) 
                            {
                                $( "#'.Html::getInputId($model, 'idCidade').'" ).html( data );
                            });',
                        'load'=>'$.get( "'.Url::toRoute('/integrante/cidade').'", { id: $(this).val()}).done(function(data) 
                        {
                            $( "#'.Html::getInputId($model, 'idCidade').'" ).html( data );
                        });',
                    ]
                ); 
            ?>
        </div>
        <div class="col-sm-3 col-md-6">
            <?= $form->field($model , 'idCidade')->dropDownList(['prompt'=>'Selecione um estado primeiro']) ?>             
        </div>
      
    </div>
    <div class="form-group">
        <?= Html::submitButton('Adicionar Município', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    

    
 </div>