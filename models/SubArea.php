<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "subArea".
 *
 * @property int $id
 * @property string $nome
 * @property string $codigo
 * @property int $ativo
 * @property int $idAreaAtuacao
 *
 * @property Especialidade[] $especialidades
 * @property SubArea $id0
 * @property SubArea $subArea
 * @property AreaAtuacao $areaAtuacao
 * @property CursoProger[] $cursoProgers
 * @property EventoProger[] $eventoProgers
 * @property ProgramaProger[] $programaProgers
 * @property ProjetoProger[] $projetoProgers
 */
class SubArea extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'subArea';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nome', 'codigo', 'ativo', 'idAreaAtuacao'], 'required'],
            [['nome', 'codigo'], 'string'],
            [['ativo', 'idAreaAtuacao'], 'integer'],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => SubArea::className(), 'targetAttribute' => ['id' => 'id']],
            [['idAreaAtuacao'], 'exist', 'skipOnError' => true, 'targetClass' => AreaAtuacao::className(), 'targetAttribute' => ['idAreaAtuacao' => 'id']],
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
            'idAreaAtuacao' => 'Área de atuação',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEspecialidades()
    {
        return $this->hasMany(Especialidade::className(), ['idSubArea' => 'id']);
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
    public function getId0()
    {
        return $this->hasOne(SubArea::className(), ['id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubArea()
    {
        return $this->hasOne(SubArea::className(), ['id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAreaAtuacao()
    {
        return $this->hasOne(AreaAtuacao::className(), ['id' => 'idAreaAtuacao']);
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
