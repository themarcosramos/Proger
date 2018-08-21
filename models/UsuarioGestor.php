<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usuarioGestor".
 *
 * @property integer $id
 * @property integer $idUsuario
 * @property integer $idGestor
 *
 * @property Usuario $idUsuario0
 * @property Gestor $idGestor0
 */
class UsuarioGestor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'usuarioGestor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idUsuario', 'idGestor'], 'required'],
            [['idUsuario', 'idGestor'], 'integer'],
            [['idUsuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['idUsuario' => 'idUsuario']],
            [['idGestor'], 'exist', 'skipOnError' => true, 'targetClass' => Gestor::className(), 'targetAttribute' => ['idGestor' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [            
            'idUsuario' => 'Id Usuario',
            'idGestor' => 'Id Gestor',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdUsuario0()
    {
        return $this->hasOne(Usuario::className(), ['idUsuario' => 'idUsuario']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdGestor0()
    {
        return $this->hasOne(Gestor::className(), ['id' => 'idGestor']);
    }
}
