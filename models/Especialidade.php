<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "especialidade".
 *
 * @property int $id
 * @property string $nome
 * @property string $codigo
 * @property int $ativo
 * @property int $idSubArea
 *
 * @property SubArea $subArea
 */
class Especialidade extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'especialidade';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nome', 'codigo', 'ativo', 'idSubArea'], 'required'],
            [['nome', 'codigo'], 'string'],
            [['ativo', 'idSubArea'], 'integer'],
            [['idSubArea'], 'exist', 'skipOnError' => true, 'targetClass' => SubArea::className(), 'targetAttribute' => ['idSubArea' => 'id']],
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
            'idSubArea' => 'Subárea',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubArea()
    {
        return $this->hasOne(SubArea::className(), ['id' => 'idSubArea']);
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
