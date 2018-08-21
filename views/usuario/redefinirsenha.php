<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\GruposUsuario;
use yii\bootstrap\Button;

/* @var $this yii\web\View */
/* @var $model app\models\Usuario */

$this->title = 'Redefinir Senha';
$this->params['breadcrumbs'][] = ['label' => 'Configurações', 'url' => ['site/configuracoes']];
$this->params['breadcrumbs'][] = ['label' => 'Usuários', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Editar Usuário', 'url' => ['update', 'id' => $model->idUsuario]];
$this->params['breadcrumbs'][] = $this->title;

$model->senha = null;

?>			

<div class="well">

	<h1><?= Html::encode($this->title) ?></h1>

    <hr style="height:1px; border:none; background-color:#D0D0D0; margin-top: 10px; margin-bottom: 15px;" />

    <?php $form = ActiveForm::begin([
    	'options' => ['class' => 'form-horizontal'],
    ]); ?>

    <div class="alert alert-info">
    	<b>Usuário: </b> <?= $model->nome ?>
    </div>

	<div style="width: 400px; margin-left: 80px">
		
		<div class="row">
			<div class="col-lg-6">
				<?= $form->field($model, 'senha')->passwordInput(['maxlength' => 10])->label('Digite a nova senha: ')->hint('Máximo: 10 caracteres') ?>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-6">
				<?= $form->field($model, 'repeat_password')->passwordInput(['maxlength' => 10])->label('Confirmação de senha: ') ?>
			</div>
		</div>
	</div>

	<div class="form-group" align="right" style="margin: 20px">
		<?= Html::submitButton('Salvar', ['class' => 'btn btn-success']) ?>
	</div>

    <?php ActiveForm::end(); ?>

</div>