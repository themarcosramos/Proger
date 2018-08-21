<?php
use \kartik\datecontrol\Module;

return [
    'adminEmail' => '', //necessita de um email
    'title' => 'PROGER',
    'enderecoSistema' => 'localhost/proger/web/',
    'caminhoRelatorio' =>'relatorios/',  // caminho onde vai salvar os relatórios,após o update do arquivo no sistema.
    
    // configurações de formato para exibir cada atributo de data     
    'displaySettings' => [
    Module::FORMAT_DATE => 'dd/MM/yyyy',
    Module::FORMAT_TIME => 'hh:mm:ss a',
    Module::FORMAT_DATETIME => 'dd/MM/yyyy hh:mm:ss a',
    ],
    
    // configurações de formato para salvar cada atributo de data
    'saveSettings' => [
    Module::FORMAT_DATE => 'php:d-m-Y',
    Module::FORMAT_TIME => 'php:H:i:s',
    Module::FORMAT_DATETIME => 'php:Y-m-d H:i:s',
    ],
];
