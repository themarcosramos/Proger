<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

$this->title = 'Recuperar Senha';

include("../Connections/config.php");

//pega a variavel via post
$login = $_POST['login'];
//busca no db o usuario com o email 
$result = ArrayHelper::map(Usuario::find()->where(['login' => $login]))->one(); 
//conta quantos tem

//se tiver  + de 1 cadastrado
if($result->count() =='1'){ 
	$rowemail = $result->login;
	$rowsenha = $result->senha;

		
	//enviar um email para variavel email juntamente com a variável senha;
	$mensage ="Você solicitou a recuperação de senhha confira seu dados.";
	$mensage .="E-mail= " . $rowemail;
	$mensage .="Senha:" . $rowsenha;
	//mail('$rowemail', "PROGER, recuperação de senha", $mensage);
	echo"<script>alert(Sua senha foi enviada para o e-mail indicado.),window.open('recuperar_senha_enviado.php','_self')</script>";

}else{	
	echo"<script>alert('E-mail não cadastrado em nosso sistema'),window.open('recuperar_senha.php','_self')</script>";	
}


?>