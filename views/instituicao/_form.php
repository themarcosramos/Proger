<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \yii\helpers\ArrayHelper;
use app\models\pais;

/* @var $this yii\web\View */
/* @var $model app\models\Instituicao */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="instituicao-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'instituicao')->textInput(['maxlength' =>100,'style' =>'width: 50%' ]) ?>
    <?= $form->field($model, 'sigla')->textInput(['maxlength' =>10,'style' =>'width: 15%' ]) ?>    

    <?= 
    //$form->field($model, 'idPais')->textInput();
    $form->field($model, 'idPais')->dropDownList(ArrayHelper::map(pais::find()->orderBy('nome')->all(),'id','nome'),['style' =>'width: 30%'],['prompt'=>'']); 

    ?>
     <?php $model->isNewRecord ? $model->ativo = 1: $model->ativo = $model->ativo ;  ?>
    <?=
    // $form->field($model, 'ativo')->textInput()
     $form->field($model, 'ativo')->radioList(array('1'=>'Sim',0=>'Não'));
     ?>

    

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Salvar' : 'Atualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
