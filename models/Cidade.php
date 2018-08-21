<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cidade".
 *
 * @property int $id
 * @property string $nome
 * @property int $idEstado
 * @property int $ativo
 *
 * @property Estado $estado
 * @property MunicipiosAbrangidos[] $municipiosAbrangidos
 * @property Pessoa[] $pessoas
 */
class Cidade extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cidade';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nome', 'idEstado'], 'required'],
            [['nome'], 'string'],
            [['idEstado', 'ativo'], 'integer'],
            [['idEstado'], 'exist', 'skipOnError' => true, 'targetClass' => Estado::className(), 'targetAttribute' => ['idEstado' => 'id']],
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
            'idEstado' => 'Id Estado',
            'ativo' => 'Ativo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getidEstado0()
    {
        return $this->hasOne(Estado::className(), ['id' => 'idEstado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMunicipiosAbrangidos()
    {
        return $this->hasMany(MunicipiosAbrangidos::className(), ['idCidade' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPessoas()
    {
        return $this->hasMany(Pessoa::className(), ['idCidade' => 'id']);
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
