<?php
//namespace app\console;
namespace app\commands;
//namespace app\controllers;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
   public function actionInit()
   {
       $auth = Yii::$app->authManager;

       

        // adciona a permissão "Gerenciar Usuario"
       $gerenciaUsuario = $auth->createPermission('teste');
       $gerenciaUsuario->description = 'Teste';
       $auth->add($gerenciaUsuario);

       /*
        // adciona a permissão "Cadastros Básicos"
       $cadastrosBasicos = $auth->createPermission('gerenciamento-cadastros-basicos');
       $cadastrosBasicos->description = 'Gerenciar Cadastros Básicos';
       $auth->add($cadastrosBasicos);

        // adciona a permissão "Cadastros Avançados"
       $cadastrosAvançados = $auth->createPermission('gerenciamento-cadastros-avançados');
       $cadastrosAvançados->description = 'Gerenciar Cadastros Avançados';
       $auth->add($cadastrosAvançados);
        

       // adciona a role "gerente" e da a esta role as permissões criadas acima
       $gerente = $auth->createRole('gerente');
       $gerente->description = 'Gerente';
       $auth->add($gerente);  
      
       $auth->addChild($gerente, $cadastrosBasicos);
       $auth->addChild($gerente, $cadastrosAvançados);

         

       // adciona a role "admin" e da a esta role a permissão "gerenciaUsuario" e tudo que gerente faz e que secretario faz
             
       $admin = $auth->createRole('admin');

       $admin->description = 'Administrador do Sistema';
       $auth->add($admin);     
       $auth->addChild($admin, $gerenciaUsuario); 
       $auth->addChild($admin, $gerente);      

       // Atribui roles para usuários. 1 and 2 são IDs retornados por IdentityInterface::getId()
       // normalmente implementado no seu model User.
       
       $auth->assign($admin, 1);
       $auth->assign($gerente, 2);     */
       
   }
}