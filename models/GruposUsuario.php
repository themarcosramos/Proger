<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\rbac\DbManager;
use app\models\AuthItemChild;
use app\models\AuthItem;
use app\models\Permissao;
use yii\helpers\ArrayHelper;

class GruposUsuario extends Model
{

    public $name;
    public $descricao;
    public $permissoes;

    private $idTabela = 12;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['descricao'], 'required'],
            [['permissoes'], 'required', 'message' => 'Adicione pelo menos 1 permissão ao grupo'],
            [['descricao'], 'string'],
            //[['descricao'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'ID',
            'descricao' => 'Nome',
            'permissoes' => 'Permissões',
        ];
    }

    public static function dropdown() {

        $auth = new DbManager;
        $grupos = $auth->getRoles();

        foreach ($grupos as $key => $value) {
            $dropdown[$key] = $value->description;
        }

        return $dropdown;
    }

    //Retorna todos os grupos cadastrados
    public static function findAll(){

        $auth = new DbManager;

        foreach ($auth->getRoles() as $key => $value) {
            $grupos[$key] = ['name' => $key, 'descricao' => $value->description];
        }

        return $grupos;

        //return AuthItem::find()->all();

    }

    public static function findOne($name){

        if($item = AuthItem::findOne($name)){

            $grupo = new GruposUsuario();
            $grupo->name = $item->name;
            $grupo->descricao = $item->description;
            $grupo->permissoes = $grupo->getPermissoes();
            //$this->permissoes = ArrayHelper::map(AuthItemChild::find()->where(['parent' => $this->name])->all(), 'name', 'description');
            return $grupo;

        }

        else{

            return null;

        }

    }

    //Deleta o grupo
    public function delete(){

        $grupo = AuthItem::find()->where(['name' => $this->name])->all();

        if($grupo->delete()){
            return true;
        }
        else{
            return false;
        }

    }

    //Salva um NOVO grupo
    public function save(){

        if ($this->validate()) {

            //Salva o grupo
            $grupo =  new AuthItem();
            $grupo->type = 1;
            $grupo->name = $this->cleanName();
            $grupo->description = $this->descricao;

            //Adiciona as permissões ao grupo
            if($grupo->save()){

                $auth = new DbManager();
                $role = $auth->getRole($grupo->name);
            
                foreach ($this->permissoes as $key => $value) {

                    $permission = $auth->getPermission($value);

                    $auth->addChild($role, $permission);

                }

                return true;
            }

            else{

                return false;

            }    

        }

        else{

            $errors = $model->errors;
            return false;
        }

    }

    //Atualiza um grupo EXISTENTE
    public function update(){

        if ($this->validate()) {

            //Atualiza o nome do grupo
            //$grupo = AuthItem::findOne($this->name); //VERIFICAR COMO FAZER ISSO

            //Apaga todas as associações ao grupo
            AuthItemChild::deleteAll(['parent' => $this->name]);

            //Adiciona de as permissoes atualizadas
            foreach ($this->permissoes as $value) {

                $permissao = new AuthItemChild();
                $permissao->parent = $this->name;
                $permissao->child = $value;
                $permissao->save();

           }

            /*
            $log = new \app\models\TabelaLog;
            $log->idTabela =  $this->idTabela;
            $log->detalhes = 'Grupo: '.$this->descricao;
            $log->idAcao = 2;
            $log->save();
            */
            
            return true;

        }

        else{

            return false;
            
        }


    }

    //Pega todas as permissões do grupo
    public function getPermissoes(){

        //return ArrayHelper::map(AuthItemChild::find()->where(['parent' => $this->name])->all(), 'parent', 'child');
        //return AuthItemChild::find()->where(['parent' => $this->name])->all();

        return Permissao::findPermissionsByGroup($this->name);

    }

    function cleanName() {
  
        $string = $this->descricao;

        $string = strtolower($string);

        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

        return preg_replace( '/[`^~\'"]/', null, iconv('UTF-8', 'ASCII//TRANSLIT', $string)); // Removes special chars.

    }

    public function afterSave($insert, $changedAttributes) {

        /*  ID - AÇÃO:
            ----------------
            1 - CADASTRO
            2 - ATUALIZAÇÃO
        */

        $log = new \app\models\TabelaLog;
        $log->idTabela =  $this->idTabela;
        $log->detalhes = 'Grupo: '.$this->descricao;

        if($insert){ //se a consulta foi de inserção (INSERT)

            $log->idAcao = 1;
            
        }

        else { //se a consulta foi de atualização (UPDATE)

            $log->idAcao = 2;

        }

        $log->save();
            
        return parent::afterSave($insert, $changedAttributes);
    }

    public function afterDelete(){

        /*  ID - AÇÃO:
            ----------------
            3 - EXCLUSÃO
        */

        $log = new \app\models\TabelaLog;
        $log->idTabela =  $this->idTabela;
        $log->detalhes = 'Grupo: '.$this->descricao;
        $log->idAcao = 3;
        $log->save();

    }

}
