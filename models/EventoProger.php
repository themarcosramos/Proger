<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "eventoProger".
 *
 * @property integer $id
 * @property string $nome
 * @property string $descricao
 * @property integer $idGrandeArea
 * @property integer $idAreaAtuacao
 * @property integer $idSubArea
 * @property integer $idEspecialidade
 * @property integer $idTipoEvento
 * @property string $dataInicio
 * @property string $dataFim
 * @property integer $numeroParticipantes
 * @property string $observacoes
 * @property integer $idTipoProger
 * @property integer $idProger
 * @property integer $idGestor
 * @property integer $idTipoEncargo
 * @property GrandeArea $idGrandeArea0
 * @property AreaAtuacao $idAreaAtuacao0
 * @property SubArea $idSubArea0
 * @property Especialidade $idEspecialidade0
 * @property TipoEvento $idTipoEvento0
 * @property AreaAtuacao $idAreaAtuacao0
 * @property Gestor $idGestor0
 * @property TipoProger $idTipoProger0
 * @property TipoEncargo $idTipoEncargo0
 */
class EventoProger extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'eventoProger';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nome', 'descricao', 'idTipoEvento', 'idGrandeArea', 'dataInicio', 'dataFim', 'idGestor', 'idTipoEncargo'], 'required'],
            [['nome', 'descricao', 'documentos','observacoes'], 'string'],
            [['idTipoEvento', 'idGrandeArea', 'idEspecialidade', 'numeroParticipantes', 'idTipoProger', 'idProger', 'idGestor', 'idTipoEncargo'], 'integer'],
            ['idAreaAtuacao', 'integer', 'message' => '"Área de atuação" não pode ficar em branco quando uma grande área for selecionada.'],
            ['idSubArea', 'integer', 'message' => '"Subárea" não pode ficar em branco quando uma área de atuação for selecionada.'],
            [['dataInicio', 'dataFim'], 'safe'],
            ['dataFim', 'compare', 'operator' => '>=', 'compareAttribute' => 'dataInicio'],
            [['idGrandeArea'], 'exist', 'skipOnError' => true, 'targetClass' => GrandeArea::className(), 'targetAttribute' => ['idGrandeArea' => 'id']],
            [['idAreaAtuacao'], 'exist', 'skipOnError' => true, 'targetClass' => AreaAtuacao::className(), 'targetAttribute' => ['idAreaAtuacao' => 'id']],
            [['idSubArea'], 'exist', 'skipOnError' => true, 'targetClass' => SubArea::className(), 'targetAttribute' => ['idSubArea' => 'id']],
            [['idEspecialidade'], 'exist', 'skipOnError' => true, 'targetClass' => Especialidade::className(), 'targetAttribute' => ['idEspecialidade' => 'id']],
            [['idTipoEvento'], 'exist', 'skipOnError' => true, 'targetClass' => TipoEvento::className(), 'targetAttribute' => ['idTipoEvento' => 'id']],
            [['idGestor'], 'exist', 'skipOnError' => true, 'targetClass' => Gestor::className(), 'targetAttribute' => ['idGestor' => 'id']],
            [['idTipoProger'], 'exist', 'skipOnError' => true, 'targetClass' => TipoProger::className(), 'targetAttribute' => ['idTipoProger' => 'id']],
            [['idTipoEncargo'], 'exist', 'skipOnError' => true, 'targetClass' => TipoEncargo::className(), 'targetAttribute' => ['idTipoEncargo' => 'id']],
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
            'descricao' => 'Descrição',
            'idTipoEvento' => 'Tipo do Evento',
            'idGrandeArea' => 'Grande Área',
            'idAreaAtuacao' => 'Área de Atuação',
            'idSubArea' => 'Subárea',
            'idEspecialidade' => 'Especialidade',
            'dataInicio' => 'Data de Inicio',
            'dataFim' => 'Data do  Fim',
            'numeroParticipantes' => 'Número Participantes',
            'documentos' => 'Documentos',
            'observacoes' => 'Observações',
            'idTipoProger' => ' Tipo Proger',
            'idProger' => ' Proger',
            'idGestor' => 'Gestor',
            'idTipoEncargo' => ' Tipo Encargo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdTipoEvento0()
    {
        return $this->hasOne(TipoEvento::className(), ['id' => 'idTipoEvento']);
    }

     /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdGrandeArea0()
    {
        return $this->hasOne(GrandeArea::className(), ['id' => 'idGrandeArea']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdAreaAtuacao0()
    {
        return $this->hasOne(AreaAtuacao::className(), ['id' => 'idAreaAtuacao']);
    }

     /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdSubArea0()
    {
        return $this->hasOne(SubArea::className(), ['id' => 'idSubArea']);
    }

     /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdEspecialidade0()
    {
        return $this->hasOne(Especialidade::className(), ['id' => 'idEspecialidade']);
    }

    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdGestor0()
    {
        return $this->hasOne(Gestor::className(), ['id' => 'idGestor']);
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
    public function getIdTipoEncargo0()
    {
        return $this->hasOne(TipoEncargo::className(), ['id' => 'idTipoEncargo']);
    }
}
