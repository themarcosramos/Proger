<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tipoCurso".
 *
 * @property int $id
 * @property string $nome
 * @property int $ativo
 * @property CursoProger[] $cursoProgers
 */
class TipoCurso extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tipoCurso';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nome'], 'required'],
            [['nome'], 'string'],
            [['ativo'], 'integer'],
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
            'ativo' => 'Ativo',
        ];
    }

     /**
     * @return \yii\db\ActiveQuery
     */
    public function getCursoProgers()
    {
        return $this->hasMany(CursoProger::className(), ['idTipoCurso' => 'id']);
    }

    public static function dropdown() { 
 
        $models = static::find()->orderBy('nome')->all(); 
        $dropdown = null; 
  
        foreach ($models as $model) { 
            $dropdown[$model->id] = $model->nome; 
        } 
  
        return $dropdown; 
    } 
 
    public function getAtivo(){
     switch ($this->ativo) {
         case 1:
             return 'Sim';
             break;
 
         case 0:
             return 'Não';
             break;
     }
    }
}
