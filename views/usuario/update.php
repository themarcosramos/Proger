<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\GruposUsuario;

/* @var $this yii\web\View */
/* @var $model app\models\Usuario */

$this->title = 'Editar Usuário';
$this->params['breadcrumbs'][] = ['label' => 'Configurações', 'url' => ['site/configuracoes']];
$this->params['breadcrumbs'][] = ['label' => 'Usuários', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>


<div class="well">


    <h1><?= Html::encode($this->title) ?></h1>

    <hr style="height:1px; border:none; background-color:#D0D0D0; margin-top: 10px; margin-bottom: 15px;" />

	<?php $form = ActiveForm::begin(); 
	 $request = Yii::$app->request;
	 $alerta = $request->get('alerta');
      
	  if($alerta == true){
		  echo  "<script> alert('Já existe usuário cadastrado com este e-mail');</script>";
	  }?>

    <div class="conteudo">

		<div class="row">
			<div class="col-lg-8">
				<?= $form->field($model, 'nameGrupo')->dropDownList(ArrayHelper::map(GruposUsuario::findAll(), 'name', 'descricao'), ['prompt' => '---- Selecione um Grupo ----'])->label('Grupo: ');  ?>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-10">
				<?= $form->field($model, 'nome')->textInput(['maxlength' => 100])->label('Nome: ') ?>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-6">
				<?= $form->field($model, 'login')->textInput(['maxlength' => 15])->label('Login: ')->hint('Máximo: 15 caracteres') ?>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-6">
				<?= $form->field($model, 'email')->textInput(['maxlength' => 100])->label('email: ')->hint('Máximo: 100 caracteres') ?>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-4">
				<?= $form->field($model, 'situacao')->dropDownList([1 => 'Ativo', 0 => 'Inativo'])->label('Situação: ');  ?>
			</div>
		</div>


		<div class="panel panel-default">
	      <div class="panel-heading"><b>Setor de gestão</b></div>
	      <div class="panel-body">

	      	<?php

	      		if($model->gestores){

		      		foreach ($model->gestores as $key => $value) {
		      			$lista[] = $value;
		      		}
		      		$model->gestores = $lista;

	      		}

	      	?>
	      	<?php
              $todosGestores = ArrayHelper::map($todosGestores, 'id', 'nome');
          ?>
	      	<div class="checkbox">
	        	<?= $form->field($model, 'gestores')->checkBoxList($todosGestores, ['template'=>'{input} <p>{label}</p>', 'separator'=>'</br>'])->label(false); 
	        	?>
	        </div>
	        
	      </div>
	    </div>


		<div class="row">
			<?= Html::a('Redefinir Senha', ['redefinirsenha', 'id' => $model->idUsuario], ['class' => 'btn btn-danger']) ?>
		</div>
	
	</div>

	<div class="form-group" align="right" style="margin: 20px">
		<?= Html::submitButton('Salvar', ['class' => 'btn btn-success']) ?>
	</div>

    <?php ActiveForm::end(); ?>

</div>
