<?php
namespace app\controllers;


use Yii;
use yii\web\Controller;
use yii\rbac\DbManager;
use yii\rbac\Rule;


class AutorizacaoController extends Controller
{

	public function actionIniciar()
   	{
       $auth = Yii::$app->authManager;       

        // adciona a permissão "Gerenciar Usuario"
       /*$gerenciaCadastros = $auth->createPermission('gerenciar-cadastros');
       $gerenciaCadastros->description = 'Gerenciar Cadastros';
       $auth->add($gerenciaCadastros);
		*/

       	$rule = new \app\rbac\PertenceSetorRule;
		$auth->add($rule);

       	$updateOwnPost = $auth->createPermission('updateOwnPost');
		$updateOwnPost->description = 'Update own post';
		$updateOwnPost->ruleName = $rule->name;
		$auth->add($updateOwnPost);
    }


}

?>