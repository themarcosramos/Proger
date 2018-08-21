<?php
 
namespace app\models;
use Yii;
use yii\base\model;
 
class FormResetPass extends model{
 
 //public $email;
 public $password;
 public $password_repeat;
 public $verification_code;
 public $recover;
     
    public function rules()
    {
        return [
            [['password', 'password_repeat'], 'required', 'message' => 'Campo requerido'],
            //['email', 'match', 'pattern' => "/^.{5,100}$/", 'message' => 'Mínimo 5 e máximo 100 caracteres'],
            //['email', 'email', 'message' => 'Formato inválido'],
            ['password', 'match', 'pattern' => "/^.{6,32}$/", 'message' => 'Mínimo 6 e máximo 32 caracteres'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => 'As senhas não coincidem'],
        ];
    }

    public function attributeLabels()
    {
        return [
          //  'email' => 'Email',
            'password' => 'Nova Senha',
            'password_repeat' => 'Repetir Nova Senha',
         //   'verification_code' => 'Código de Verificação Enviado por email',
          
        ];
    }
}
