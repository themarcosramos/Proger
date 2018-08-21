<?php
//conteudo referencia: http://jquery-manual.blogspot.com.br/2015/02/yii-framework-2-user-recuperar-password.html

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Recuperar Senha';
?>
 
<h3><?= $msg ?></h3>
 
<h1>Recuperar Senha</h1>
<?php $form = ActiveForm::begin([
    'method' => 'post',
    'enableClientValidation' => true,
]);
?>
 
<div class="form-group">
 <?= $form->field($model, "email")->textInput(['maxlength' =>100,'style' =>'width: 50%' ]) ?>  
</div>
 
<?= Html::submitButton("Recuperar Senha", ["class" => "btn btn-primary"]) ?>
 
<?php $form->end() ?>
