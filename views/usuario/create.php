<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\GruposUsuario;

/* @var $this yii\web\View */
/* @var $model app\models\Usuario */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Novo Usuário';
$this->params['breadcrumbs'][] = ['label' => 'Configurações', 'url' => ['site/configuracoes']];
$this->params['breadcrumbs'][] = ['label' => 'Usuários', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<script language="javascript">

    window.onload = function(){
        consultaEmail();
    }   
	 /** 
	  *A função a seguir chama uma action no controller de UsuarioController,
	  * onde realizar uma busca no banco de dados, Para verificar se o e-mail
	  * inserido pelo usuário já foi cadastrado anteriormente, caso tem sido 
	  * não deixará Usuário realizar o cadastro com o e-mail em questão.
	  */

    function consultaEmail(){
        if($('#usuario-email').val().length != 0){
            $("#inputError").empty();              
            var request = $.ajax({       //Manda a requisição para a este endereço (controller/action)
                url: "<?= Yii::$app->urlManager->createUrl('usuario/consulta-email'); ?>",
                data: "email="+$("#usuario-email").val(), //Pega o e-mail que foi inserido pelo usuário 
                type: 'POST',
            }); 
            
            request.done(function(msg) { //requisição feita com sucesso
                console.log(msg)

                if(msg == -1){
                   alert('Já existe usuário cadastrado com este e-mail ');  
                   document.getElementById('usuario-email').value=''; // Limpa o campo                  
                   $("#usuario-email").focus();
                }              
            });
            request.fail(function(jqXHR, textStatus) { //requisição fracassada
                console.log("Request failed: " + textStatus);
                $("#inputError").html('Request failed:');
                
            });     
        }
        }
     
</script>

<div class="well">

	<h1><?= Html::encode($this->title) ?></h1> 

    <hr style="height:1px; border:none; background-color:#D0D0D0; margin-top: 10px; margin-bottom: 15px;" />

    <?php $form = ActiveForm::begin(); ?>

    <div style="conteudo">

		<div class="row">
			<div class="col-md-3">
				<?= $form->field($model, 'nameGrupo')->dropDownList(ArrayHelper::map(GruposUsuario::findAll(), 'name', 'descricao'), ['prompt' => '---- Selecione um Grupo ----'])->label('Grupo: ');  ?>
			</div>
		</div>

		<div class="row">
			<div class="col-md-4">
				<?= $form->field($model, 'nome')->textInput(['maxlength' => 100])->label('Nome: ') ?>
			</div>
		</div>

		<div class="row">
			<div class="col-md-2">
				<?= $form->field($model, 'login')->textInput(['maxlength' => 15])->label('Login: ')->hint('Máximo: 15 caracteres') ?>
			</div>
		</div>

		<div class="row">
			<div class="col-md-2">
				<?= $form->field($model, 'situacao')->dropDownList([1 => 'Ativo', 0 => 'Inativo'])->label('Situação: ');  ?>
			</div>
		</div>

		<div class="row">
			<div class="col-md-3">
				<?= $form->field($model, 'senha')->passwordInput(['maxlength' => 10])->label('Senha: ')->hint('Máximo: 10 caracteres') ?>
			</div>
		</div>

		<div class="row">
			<div class="col-md-3">
				<?= $form->field($model, 'repeat_password')->passwordInput(['maxlength' => 10])->label('Confirmação de senha: ') ?>
			</div>
		</div>

		<div class="row">
			<div class="col-md-3">
				<?= $form->field($model, 'email')->textInput(['maxlength' => 100,'onBlur'=>'js:consultaEmail();'])->label('Email: ') ?>
			</div>
			<div class="help-block" align="left" id="inputError" >
             </div>
		</div>

		<div class="panel panel-default">
        <div class="panel-heading"><b>Setor de Gestão</b></div>
        <div class="panel-body">
          
          <?php
              $gestores = ArrayHelper::map($gestores, 'id', 'nome');
          ?>
          <div class="checkbox">
            <?= $form->field($model, 'gestores')->checkBoxList($gestores, ['template'=>'{input} <p>{label}</p>', 'separator'=>'</br>'])->label(false); ?>
          </div>

        </div>
      </div>


		
			
	</div>

	<div class="form-group" align="right" style="margin: 20px">
		<?= Html::submitButton('Cadastrar', ['class' => 'btn btn-success']) ?>
	</div>

    <?php ActiveForm::end(); ?>

</div>
