<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "setor".
 *
 * @property integer $id
 * @property string $nome
 * @property string $sigla
 * @property integer $ativo
 *
 * @property CursoProger[] $cursoProgers
 * @property Integrante[] $integrantes
 * @property ProgramaProger[] $ProgramaProgers
 * @property ProjetoProger[] $projetoProgers
 */
class Setor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'setor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nome', 'sigla', 'ativo'], 'required'],
            [['nome', 'sigla'], 'string'],
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
            'sigla' => 'Sigla',
            'ativo' => 'Ativo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCursoProgers()
    {
        return $this->hasMany(CursoProger::className(), ['idSetor' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIntegrantes()
    {
        return $this->hasMany(Integrante::className(), ['idSetor' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProgramaProgers()
    {
        return $this->hasMany(ProgramaProger::className(), ['idSetor' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjetoProgers()
    {
        return $this->hasMany(ProjetoProger::className(), ['idSetor' => 'id']);
    }

    public function getSituacao(){

        switch ($this->ativo) {
            case 1:
                return 'Ativo';
                break;

            case 0:
                return 'Inativo';
                break;
        }
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
