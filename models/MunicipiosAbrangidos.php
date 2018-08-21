<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "municipiosAbrangidos".
 *
 * @property integer $id
 * @property integer $idTipoProger
 * @property integer $idProger
 * @property integer $idCidade
 *
 * @property TipoProger $idTipoProger0
 * @property Cidade $idCidade0
 */
class MunicipiosAbrangidos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'municipiosAbrangidos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idTipoProger', 'idProger', 'idCidade'], 'required'],
            [['idTipoProger', 'idProger', 'idCidade'], 'integer'],
            [['idTipoProger'], 'exist', 'skipOnError' => true, 'targetClass' => TipoProger::className(), 'targetAttribute' => ['idTipoProger' => 'id']],
            [['idCidade'], 'exist', 'skipOnError' => true, 'targetClass' => Cidade::className(), 'targetAttribute' => ['idCidade' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'idTipoProger' => 'Id Tipo Proger',
            'idProger' => 'Id Proger',
            'idCidade' => 'Cidade',
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
    public function getIdCidade0()
    {
        return $this->hasOne(Cidade::className(), ['id' => 'idCidade']);
    }
}
