<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "financiamento".
 *
 * @property integer $id
 * @property integer $idProger
 * @property integer $idTipoProger
 * @property integer $idFinanciadora
 * @property string $edital
 * @property string $valorAprovado
 * @property string $dataInicio
 * @property string $dataFim
 * @property integer $ativo
 * @property string $observacao
 * @property TipoProger $idTipoProger0
 * @property Edital $idEdital0
 * @property Financiadora $idFinanciadora0
 */
class Financiamento extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'financiamento';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idProger', 'idTipoProger', 'idFinanciadora', 'edital', 'valorAprovado', 'dataInicio', 'dataFim', 'ativo'], 'required'],
            [['idProger', 'idTipoProger', 'idFinanciadora', 'ativo'], 'integer'],
            [['valorAprovado'], 'number'],
            [['dataInicio', 'dataFim'], 'safe'],
            ['dataFim', 'compare', 'operator' => '>=', 'compareAttribute' => 'dataInicio'],
            [['edital', 'observacao'], 'string'],
            [['idTipoProger'], 'exist', 'skipOnError' => true, 'targetClass' => TipoProger::className(), 'targetAttribute' => ['idTipoProger' => 'id']],
            [['idFinanciadora'], 'exist', 'skipOnError' => true, 'targetClass' => Financiadora::className(), 'targetAttribute' => ['idFinanciadora' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'idProger' => 'Id Proger',
            'idTipoProger' => 'Id Tipo Proger',
            'idFinanciadora' => 'Nome da Financiadora',
            'edital' => 'Nome do Edital',
            'valorAprovado' => 'Valor Aprovado',
            'dataInicio' => 'Data Inicio',
            'dataFim' => 'Data Fim',
            'ativo' => 'Ativo',
            'observacao' => 'Observação',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdTipoProger0()
    {
        return $this->hasOne(TipoProger::className(), ['id' => 'idTipoProger']);
    }

    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdFinanciadora0()
    {
        return $this->hasOne(Financiadora::className(), ['id' => 'idFinanciadora']);
    }
}
