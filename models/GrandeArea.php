<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "grandeArea".
 *
 * @property int $id
 * @property string $nome
 * @property string $codigo
 * @property int $ativo
 *
 * @property AreaAtuacao[] $areaAtuacaos
 * @property CursoProger[] $cursoProgers
 * @property EventoProger[] $eventoProgers
 * @property ProgramaProger[] $programaProgers
 * @property ProjetoProger[] $projetoProgers
 */
class GrandeArea extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'grandeArea';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nome', 'codigo', 'ativo'], 'required'],
            [['nome', 'codigo'], 'string'],
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
            'codigo' => 'Codigo',
            'ativo' => 'Ativo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAreaAtuacaos()
    {
        return $this->hasMany(AreaAtuacao::className(), ['idGrandeArea' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCursoProgers()
    {
        return $this->hasMany(CursoProger::className(), ['idGestor' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEventoProgers()
    {
        return $this->hasMany(EventoProger::className(), ['idGestor' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProgramaProgers()
    {
        return $this->hasMany(ProgramaProger::className(), ['idGestor' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjetoProgers()
    {
        return $this->hasMany(ProjetoProger::className(), ['idGestor' => 'id']);
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

    public static function dropdown() { 
 
        $models = static::find()->orderBy('nome')->all(); 
        $dropdown = null; 
  
        foreach ($models as $model) { 
            $dropdown[$model->id] = $model->nome; 
        } 
  
        return $dropdown; 
    }
}
