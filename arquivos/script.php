<?php

$auth = new yii\rbac\DbManager;

$gerenciaFinanciamento = $auth->createPermission('gerenciar-financiamento');
$gerenciaFinanciamento->description = 'Gerenciar Financiamento';
$auth->add($gerenciaFinanciamento);



// adciona a role "gerente" e da a esta role a permissão "gerenciaFinanciamento"
$gerente = $auth->createRole('gerente');
$auth->add($gerente);
$auth->addChild($gerente, $gerenciaFinanciamento);

// adciona a role "admin" e da a esta role a permissão "updatePost"
// bem como as permissões da role "gerente"

$admin = $auth->createRole('admin');
$auth->add($admin);
//$auth->addChild($admin, $updatePost);
$auth->addChild($admin, $gerente);

// Atribui roles para usuários. 1 and 2 são IDs retornados por IdentityInterface::getId()
// normalmente implementado no seu model User.
$auth->assign($gerente, 0);
//$auth->assign($admin, 1);
