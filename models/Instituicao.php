<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "instituicao".
 *
 * @property integer $id
 * @property string $instituicao
 * @property integer $idPais
 * @property integer $ativo
 * @property string $sigla
 *
 * @property pais $idPais
 * @property Integrante[] $integrantes
 */
class Instituicao extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'instituicao';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['instituicao', 'idPais', 'ativo'], 'required'],
            [['instituicao', 'sigla'], 'string'],
            [['idPais', 'ativo'], 'integer'],
            [['idPais'], 'exist', 'skipOnError' => true, 'targetClass' => Pais::className(), 'targetAttribute' => ['idPais' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'instituicao' => 'Instituição',
            'idPais' => 'País',
            'ativo' => 'Ativo',
            'sigla' => 'Sigla',
        ];
    }

    
    public function getPais()
    { 
        return $this->hasOne(pais::className(), ['id' => 'idPais']);
    }



    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIntegrantes()
    {
        return $this->hasMany(Integrante::className(), ['idInstituicao' => 'id']);
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
