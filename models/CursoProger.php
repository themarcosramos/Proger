<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cursoProger".
 *
 * @property integer $id
 * @property string $nome
 * @property string $descricao
 * @property integer $idSituacao
 * @property integer $idGrandeArea
 * @property integer $idAreaAtuacao
 * @property integer $idSubArea
 * @property integer $idEspecialidade
 * @property integer $idTipoCurso
 * @property integer $idSetor
 * @property integer $interdepartamental
 * @property integer $interinstitucional
 * @property integer $cargaHoraria
 * @property string $dataInicio
 * @property string $dataFim
 * @property string $observacoes
 * @property integer $idTipoProger
 * @property integer $idProger
 * @property integer $idGestor
 * @property integer $idTipoEncargo
 * @property GrandeArea $idGrandeArea0
 * @property AreaAtuacao $idAreaAtuacao0
 * @property SubArea $idSubArea0
 * @property Especialidade $idEspecialidade0
 * @property TipoCurso $idTipoCurso0
 * @property Gestor $idGestor0
 * @property Setor $idSetor0
 * @property Situacao $idSituacao0
 * @property TipoProger $idTipoProger0
 * @property TipoEncargo $idTipoEncargo0
 */
class CursoProger extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cursoProger';
    }

    public function relations() {
        return array(
        'Integrante' => array(self::BELONGS_TO, 'Integrante', 'id'),
        );
    }

    /**
     * @inheritdoc
     */
    public function rules() 
    {
        return [
            [['nome'], 'required', 'message' => 'Informe o nome do Curso' ],
            [['descricao', 'idSituacao', 'idGrandeArea', 'idSetor', 'interdepartamental', 'interinstitucional', 'cargaHoraria', 'dataInicio', 'dataFim', 'idGestor', 'documentos','idTipoEncargo'], 'required'],
            [['nome', 'descricao','documentos','observacoes'], 'string'],
            [['idSituacao', 'idTipoCurso', 'idGrandeArea', 'idEspecialidade', 'idSetor', 'interdepartamental', 'interinstitucional', 'cargaHoraria', 'idTipoProger', 'idProger', 'idGestor', 'idTipoEncargo'], 'integer'],
            ['idAreaAtuacao', 'integer', 'message' => '"Área de atuação" não pode ficar em branco quando uma grande área for selecionada.'],
            ['idSubArea', 'integer', 'message' => '"Subárea" não pode ficar em branco quando uma área de atuação for selecionada.'],
            [['dataInicio', 'dataFim'], 'safe'],
            ['dataFim', 'compare', 'operator' => '>=', 'compareAttribute' => 'dataInicio'],
            [['idGrandeArea'], 'exist', 'skipOnError' => true, 'targetClass' => GrandeArea::className(), 'targetAttribute' => ['idGrandeArea' => 'id']],
            [['idAreaAtuacao'], 'exist', 'skipOnError' => true, 'targetClass' => AreaAtuacao::className(), 'targetAttribute' => ['idAreaAtuacao' => 'id']],
            [['idSubArea'], 'exist', 'skipOnError' => true, 'targetClass' => SubArea::className(), 'targetAttribute' => ['idSubArea' => 'id']],
            [['idEspecialidade'], 'exist', 'skipOnError' => true, 'targetClass' => Especialidade::className(), 'targetAttribute' => ['idEspecialidade' => 'id']],
            [['idGestor'], 'exist', 'skipOnError' => true, 'targetClass' => Gestor::className(), 'targetAttribute' => ['idGestor' => 'id']],
            [['idSetor'], 'exist', 'skipOnError' => true, 'targetClass' => Setor::className(), 'targetAttribute' => ['idSetor' => 'id']],
            [['idSituacao'], 'exist', 'skipOnError' => true, 'targetClass' => Situacao::className(), 'targetAttribute' => ['idSituacao' => 'id']],
            [['idTipoProger'], 'exist', 'skipOnError' => true, 'targetClass' => TipoProger::className(), 'targetAttribute' => ['idTipoProger' => 'id']],
            [['idTipoEncargo'], 'exist', 'skipOnError' => true, 'targetClass' => Situacao::className(), 'targetAttribute' => ['idTipoEncargo' => 'id']],

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
            'idSituacao' => 'Situação',
            'idTipoCurso' => 'Tipo de Curso',
            'idGrandeArea' => 'Grande Área',
            'idAreaAtuacao' => 'Área de Atuação',
            'idSubArea' => 'Subárea',
            'idEspecialidade' => 'Especialidade',
            'idSetor' => 'Setor',
            'interdepartamental' => 'Interdepartamental',
            'interinstitucional' => 'Interinstitucional',
            'cargaHoraria' => 'Carga Horária',
            'dataInicio' => 'Data Início',
            'dataFim' => 'Data Fim',
            'documentos' => 'Documentos',
            'observacoes' => 'Observações',
            'idTipoProger' => 'Tipo Proger',
            'idProger' => 'Proger',
            'idGestor' => 'Gestor',
            'idTipoEncargo' => 'Tipo de Encargo',
        ];
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
    public function getIdTipoCurso0()
    {
        return $this->hasOne(TipoCurso::className(), ['id' => 'idTipoCurso']);
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
    public function getIdSetor0()
    {
        //return $this->hasOne(Setor::className(), ['id' => 'idSetor']);
        $setor = Setor::model()->findByPk(2);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdSituacao0()
    {
        return $this->hasOne(Situacao::className(), ['id' => 'idSituacao']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdTipoProger0()
    {
        return $this->hasOne(TipoProger::className(), ['id' => 'idTipoProger']);
    }

    public function getProgramaProger()
    { 
        if($this->idTipoProger){
            return $this->hasOne(ProgramaProger::className(), ['id' => 'idProger']);
        }
    }
    
    public function getInterdepartamental()
    {
        switch ($this->interdepartamental) {
            case 1:
                return 'Sim';
                break;

            case 0:
                return 'Não';
                break;
        }
    }

    public function getInterinstitucional()
    {
        switch ($this->interinstitucional) {
            case 1:
                return 'Sim';
                break;

            case 0:
                return 'Não';
                break;
        }
    }

     /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdTipoEncargo0()
    {
        return $this->hasOne(TipoEncargo::className(), ['id' => 'idTipoEncargo']);
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


/*class TableB extends ActiveRecord {
class Integrante extends \yii\db\ActiveRecord {
    
    public static function tableName()
    {
        return 'integrante';
    }

    public function relations() {
        return array(
        'CursoProger' => array(self::BELONGS_TO, 'CursoProger', 'id'),
        );
    }


    public function search() {
        
        $criteria = new CDbCriteria();
            $criteria->with = array('CursoProger');
         
            $criteria->compare('CursoProger.cp', Yii::app()->request->getParam('CursoProger'), true);
           
            $sort = new CSort();
            $sort->attributes = array(
                'CursoProger.cp' => array(
                    'asc' => 'CursoProger.cp ASC',
                    'desc' => 'CursoProger.cp DESC'
                ),
                '*'
            );
            return new CActiveDataProvider($this,
                array(
                    'criteria' => $criteria,
                    'sort' => $sort
                ));
    }
    
}  */