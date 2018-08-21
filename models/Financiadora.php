<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "financiadora".
 *
 * @property int $id
 * @property string $nome
 * @property string $sigla
 * @property int $ativo
 *
 * @property Financiamento[] $financiamentos
 */
class Financiadora extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'financiadora';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nome', 'sigla'], 'required'],
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
    public function getFinanciamentos()
    {
        return $this->hasMany(Financiamento::className(), ['idFinanciadora' => 'id']);
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
