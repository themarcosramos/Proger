<?php
 
namespace app\models;
use Yii;
use yii\base\model;
 
class FormRecoverPass extends model{
 
    public $email;
     
    public function rules()
    {
        return [
            ['email', 'required', 'message' => 'Campo requerido'],
            ['email', 'match', 'pattern' => "/^.{5,100}$/", 'message' => 'Mínimo 5 e máximo 100 caracteres'],
            ['email', 'email', 'message' => 'Formato inválido'],
        ];
    }
}