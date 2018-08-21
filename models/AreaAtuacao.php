<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "areaAtuacao".
 *
 * @property int $id
 * @property string $nome
 * @property string $codigo
 * @property int $ativo
 * @property int $idGrandeArea
 *
 * @property GrandeArea $grandeArea
 * @property CursoProger[] $cursoProgers
 * @property EventoProger[] $eventoProgers
 * @property ProgramaProger[] $programaProgers
 * @property ProjetoProger[] $projetoProgers
 * @property SubArea[] $subAreas
 */
class AreaAtuacao extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'areaAtuacao';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nome', 'codigo', 'idGrandeArea'], 'required'],
            [['nome', 'codigo'], 'string'],
            [['ativo', 'idGrandeArea'], 'integer'],
            [['idGrandeArea'], 'exist', 'skipOnError' => true, 'targetClass' => GrandeArea::className(), 'targetAttribute' => ['idGrandeArea' => 'id']],
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
            'codigo' => 'Código',
            'ativo' => 'Ativo',
            'idGrandeArea' => 'Grande Área',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGrandeArea()
    {
        return $this->hasOne(GrandeArea::className(), ['id' => 'idGrandeArea']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCursoProgers()
    {
        return $this->hasMany(CursoProger::className(), ['idAreaAtuacao' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEventoProgers()
    {
        return $this->hasMany(EventoProger::className(), ['idAreaAtuacao' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProgramaProgers()
    {
        return $this->hasMany(ProgramaProger::className(), ['idAreaAtuacao' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjetoProgers()
    {
        return $this->hasMany(ProjetoProger::className(), ['idAreaAtuacao' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubAreas()
    {
        return $this->hasMany(SubArea::className(), ['idAreaAtuacao' => 'id']);
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
