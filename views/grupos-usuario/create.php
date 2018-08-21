<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\rbac\DbManager;


/* @var $this yii\web\View */
/* @var $model app\models\GruposUsuario */

$this->title = 'Novo Grupo de Usuário';
$this->params['breadcrumbs'][] = ['label' => 'Configurações', 'url' => ['site/configuracoes']];
$this->params['breadcrumbs'][] = ['label' => 'Grupos de Usuário', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="well">

    <h1><?= Html::encode($this->title) ?></h1>

    <hr style="height:1px; border:none; background-color:#D0D0D0; margin-top: 10px; margin-bottom: 15px;" />

    <?php $form = ActiveForm::begin(['id' => 'form-create-grupousuario']); ?>

    <div class="conteudo">
      
  		<div class="row">
  			<div class="col-lg-8">
  	    		<?= $form->field($model, 'descricao')->textInput()->label('Nome: ') ?>
  			</div>
  		</div>

      <div class="panel panel-default">
        <div class="panel-heading"><b>Permissões</b></div>
        <div class="panel-body">
          
          <?php
              $authItems = ArrayHelper::map($authItems, 'name', 'description');
          ?>
          <div class="checkbox">
            <?= $form->field($model, 'permissoes')->checkBoxList($authItems, ['template'=>'{input} <p>{label}</p>', 'separator'=>'</br>'])->label(false); ?>
          </div>

        </div>
      </div>

	</div>

	<div class="form-group" align="right" style="margin: 20px">
		<?= Html::submitButton('Cadastrar', ['class' => 'btn btn-success']) ?>
	</div>

    <?php ActiveForm::end(); ?>

</div>
