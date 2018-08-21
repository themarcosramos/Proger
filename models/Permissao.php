<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\AuthItem;
use yii\helpers\ArrayHelper;

class Permissao extends Model
{

    public $name;
    public $descricao;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'descricao'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Nome',
            'descricao' => 'Descrição',
        ];
    }

    public static function dropdown() {

        //$models = $this->findAll(); //a linha abaixo foi colocada pq ficava dando erro nesse model aqui, pegamos o modelo de outro model sem erro.
        $models = static::find()->orderBy('nome')->all();

        foreach ($models as $model) {
            $dropdown[$model->name] = $model->descricao;
        }

        return $dropdown;
    }

    //Retorna todos as permissoes
    public static function findAll(){

        $permissoes = ArrayHelper::map(AuthItem::find()->where(['type' => '2'])->orderBy('CAST(description AS VARCHAR(500))')->all(), 'name', 'description');

        foreach ($permissoes as $key => $value) {
            //$permissoes[$key] = ['name' => $key, 'descricao' => $value];
            $p[$key] = $value;
        }

        return $p;

    }

    //Encontra uma permissão
    public function findOne($name){

        if($item = AuthItem::findOne($name)){

            $permissao = new Permissao();
            $permissao->name = $item->name;
            $permissao->descricao = $item->description;

            return $permissao;

        }

        else{

            return null;

        }

    }

    public static function findPermissionsByGroup($groupName){

        $permissoes = AuthItemChild::find()->where(['parent' => $groupName])->all();

        $p = null;

        foreach ($permissoes as $key => $value) {

            //var_dump($value->childAuthItem);
            //die();

            $p[$value->child] = $value->childAuthItem['description'];
        }

        return $p;

    }

}
