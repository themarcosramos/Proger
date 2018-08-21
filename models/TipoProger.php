<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tipoProger".
 *
 * @property int $id
 * @property string $nome
 * @property int $ativo
 *
 * @property CursoProger[] $cursoProgers
 * @property EventoProger[] $eventoProgers
 * @property Financiamento[] $financiamentos
 * @property Integrante[] $integrantes
 * @property MunicipiosAbrangidos[] $municipiosAbrangidos
 * @property Relatorio[] $relatorios
 * @property ResolucaoProger[] $resolucaoProgers
 */
class TipoProger extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tipoProger';
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
        return $this->hasMany(CursoProger::className(), ['idTipoProger' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEventoProgers()
    {
        return $this->hasMany(EventoProger::className(), ['idTipoProger' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinanciamentos()
    {
        return $this->hasMany(Financiamento::className(), ['idTipoProger' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIntegrantes()
    {
        return $this->hasMany(Integrante::className(), ['idTipoProger' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMunicipiosAbrangidos()
    {
        return $this->hasMany(MunicipiosAbrangidos::className(), ['idTipoProger' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelatorios()
    {
        return $this->hasMany(Relatorio::className(), ['idTipoProger' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResolucaoProgers()
    {
        return $this->hasMany(ResolucaoProger::className(), ['idTipoProger' => 'id']);
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
