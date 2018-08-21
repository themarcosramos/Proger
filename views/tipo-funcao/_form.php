<?php 

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\tipoFuncao */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tipo-funcao-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'descricao')->textInput(['maxlength' =>50,'style' =>'width: 50%' ]) ?>
    <?php $model->isNewRecord ? $model->ativo = 1: $model->ativo = $model->ativo ;  ?>
    
    <?= //$form->field($model, 'ativo')->textInput() 
    $form->field($model, 'ativo')->radioList(array('1'=>'Sim',0=>'Não')); 
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Salvar' : 'Atualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
