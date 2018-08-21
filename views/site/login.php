<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

$this->title = 'Login';

?>

<style>
    #logo > img {
        width: auto;
        max-width:420px;
    }   
</style>

<div id="logo" align="center" style="margin-bottom: 20px; margin-top: 50px;">
    <?php echo '<img src ="' . Yii::$app->request->baseUrl . '/images/logo_invertido.png" />' ?>
</div>

<div id="geral" class="well" align="center" style="margin: 0 auto; width: 40%;">
    
    <h1><?= Html::encode($this->title) ?></h1>
    
    <br>
    
    <?php 
        $form = ActiveForm::begin([
            'layout' => 'horizontal',
            'fieldConfig' => [
                'horizontalCssClasses' => [
                    'wrapper' => 'col-sm-8',
                ],
            ],
        ]); 

    ?>
    
    <?= $form->field($model, 'username')->label('Usuário:'); ?>
    <?= $form->field($model, 'password')->passwordInput()->label('Senha:') ?>
    
    <div class="form-group"> 
         <?= Html::submitButton('Entrar', ['class' => 'btn btn-primary', 'name' => 'login-button', 'style' => 'width: 40%']) ?>
    </div> 
    <?php ActiveForm::end(); ?>
    
 </div>
 <div id="logo" align="center" style="margin-bottom: 20px; margin-top: 20px;">
    <?= Html::a('Esqueceu a senha?', ['/site/recoverpass']) ?>
</div>
