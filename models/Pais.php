<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pais".
 *
 * @property integer $id
 * @property string $nome
 * @property string $sigla
 *
 * @property Estado[] $estados
 * @property Instituicao[] $instituicaos
 */
class Pais extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pais';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nome'], 'required'],
            [['nome', 'sigla'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nome' => 'Nome',
            'sigla' => 'Sigla',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstados()
    {
        return $this->hasMany(Estado::className(), ['idPais' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstituicaos()
    {
        return $this->hasMany(Instituicao::className(), ['idPais' => 'id']);
    }


    public static function dropdown() { 
 
       $models = static::find()->orderBy('nome')->all(); 
       $dropdown = null; 
 
       foreach ($models as $model) { 
           $dropdown[$model->id] = $model->nome; 
       } 
 
       return $dropdown; 
   } 

}
