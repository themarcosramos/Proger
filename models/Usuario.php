<?php

namespace app\models;

use Yii;

use yii\rbac\DbManager;


/**
 * This is the model class for table "Usuario".
 *
 * @property integer $idUsuario
 * @property string $nameGrupo
 * @property string $nome
 * @property string $senha
 * @property string $login
 * @property integer $situacao
 * @property string $email
 * @property string $verification_code
 * @property integer $trocar_senha
 *
 * @property UsuarioGestor[] $usuarioGestors
 */
class Usuario extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{

    private $idTabela = 11;

    // holds the password confirmation word
    public $repeat_password;
 
    //will hold the encrypted password for update actions.
    public $initialPassword;

    /**
     * @inheritdoc
     */


    public $gestores;
    public static function tableName()
    {
        return 'Usuario';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nameGrupo', 'nome', 'senha', 'login', 'situacao', 'email', 'verification_code'], 'required'],
            [['nameGrupo', 'nome', 'senha', 'login', 'email', 'verification_code'], 'string'],
            [['situacao', 'trocar_senha'], 'integer'],
            [['email'], 'email'],
            [['repeat_password'], 'required', 'message' => 'Confirme sua senha.', 'on' => ['cadastro', 'redefinirSenha']],
            [['senha, repeat_password'], 'required', 'on'=>['cadastro', 'redefinirSenha']],
            ['repeat_password', 'compare', 'compareAttribute'=>'senha', 'message'=>"As senhas não correspondem.", 'on'=>['cadastro','redefinirSenha']],
            ['login', 'unique', 'message' => 'Este login já está sendo utilizado. Por favor, insira um novo login.'],
        ];
    }

    public function scenarios()
    {
        return [
            'cadastro' => ['nome', 'login', 'senha', 'nameGrupo', 'repeat_password', 'situacao','gestores', 'email', 'verification_code'],
            'update' => ['nome', 'login', 'nameGrupo', 'situacao','gestores','email'],
            'redefinirSenha' => ['senha', 'repeat_password'],
            'recoverpass' => ['verification_code'],
            'resetpass' => ['senha', 'repeat_password'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idUsuario' => 'Id Usuario',
            'nameGrupo' => 'Name Grupo',
            'nome' => 'Nome',
            'senha' => 'Senha',
            'login' => 'Login',
            'situacao' => 'Situacao',
            'email' => 'E-mail',
            'verification_code' => 'Verification Code',
            'trocar_senha' => 'Trocar Senha',
        ];
    }

       
    public static function findByUsername($username)
    {
    	return Usuario::find()->where(['login' => $username])->one();
    }
   

    public function getGrupo()
    {
        //return $this->hasOne(GruposUsuario::className(), ['idGrupo' => 'idGrupo']);
        return GruposUsuario::findOne($this->nameGrupo);
    }

       
    //Implementação dos métodos da interface IdentityInterface
    
    public function validatePassword($password)
    {
        
        return $this->senha === md5($password);

    }
    
    public static function findIdentity($id)
    {
    	return static::findOne($id);
    }
    
    public static function findIdentityByAccessToken($token, $type = null)
    {
    	return static::findOne(['access_token' => $token]);
    }
    
    public function getId()
    {
    	return $this->idUsuario;
    }

    public function getSituacao(){

        switch ($this->situacao) {
            case 1:
                return 'Ativo';
                break;

            case 0:
                return 'Inativo';
                break;
        }

    }
    
    public function getAuthKey()
    {
    	return $this->auth_key;
    }
    
    public function validateAuthKey($authKey)
    {
    	return $this->getAuthKey() === $authKey;
    }

    public function beforeSave($insert) {

        if($this->scenario == 'redefinirSenha' || $this->scenario == 'cadastro' || $this->scenario == 'recoverpass' || $this->scenario == 'resetpass'){
            if(isset($this->senha)){
                $this->senha = md5($this->senha);
            }
        }

        else if($this->scenario == 'update'){
            $this->senha = $this->initialPassword; 
        }
            
        return parent::beforeSave($insert);
    }

    public function beforeUpdate($insert) {

        if(isset($this->senha)){
            $this->senha = md5($this->senha);
        } 
            
        return parent::beforeSave($insert);
    }

    public function afterFind()
    {
        //reset the password to null because we don't want the hash to be shown.
        $this->initialPassword = $this->senha;
        //$this->senha = null;
 
        parent::afterFind();
    }

    public static function dropdown() {

        $models = static::find()->orderBy('login')->all();

        foreach ($models as $model) {
            $dropdown[$model->idUsuario] = $model->login;
        }

        return $dropdown;
    }

    public function afterSave($insert, $changedAttributes) {

        //Adicionar usuário nos assignments

        //Remove a anterior
        $auth = new DbManager();
        $auth->revokeAll($this->idUsuario);

        //Adiciona a nova
        $role = $auth->getRole($this->nameGrupo);
        $auth->assign($role, $this->idUsuario);

        //Exclui os setores gestores vinculados ao usuario
        $connection = \Yii::$app->db;
        $connection->createCommand('DELETE FROM usuarioGestor where idUsuario = '.$this->idUsuario)->execute();

        //Adiciona os setores gestores
        if($this->gestores){
            foreach ($this->gestores as $key => $value) {
                    $usuarioGestor = new UsuarioGestor();
                    $usuarioGestor->idUsuario = $this->getId();
                    $usuarioGestor->idGestor = $value;
                    $usuarioGestor->save();
            }
        }


        /*  ID - AÇÃO:
            ----------------
            1 - CADASTRO
            2 - ATUALIZAÇÃO
        */
        /*
        $log = new \app\models\TabelaLog;
        $log->idTabela =  $this->idTabela;
        $log->detalhes = 'ID: '.$this->idUsuario. ' | Nome: '.$this->nome;
        

        if($insert){ //se a consulta foi de inserção (INSERT)

            $log->idAcao = 1;

        }

        else { //se a consulta foi de atualização (UPDATE)

            $log->idAcao = 2;

        }

        $log->save();
        */
            
        return parent::afterSave($insert, $changedAttributes);
    }

    public function afterDelete(){

        //Remove todas as permissões dadas ao usuário
        $auth = new DbManager();
        $auth->revokeAll($this->idUsuario);

        /*  ID - AÇÃO:
            ----------------
            3 - EXCLUSÃO
        */

        $log = new \app\models\TabelaLog;
        $log->idTabela =  $this->idTabela;
        $log->detalhes = 'ID: '.$this->idUsuario. ' | Nome: '.$this->nome;
        $log->idAcao = 3;
        $log->save();

    }
}
