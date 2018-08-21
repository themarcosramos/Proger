<?php

namespace app\models;

use Yii;
use yii\helpers\FileHelper;

/**
 * This is the model class for table "relatorio".
 *
 * @property integer $id
 * @property integer $idTipoProger
 * @property integer $idProger
 * @property integer $populacaoAtingida
 * @property string $dataInicio
 * @property string $dataFim
 * @property string $dataEntregaRelatorio
 * @property string $urlArquivo
 *
 * @property TipoProger $idTipoProger0
 */
define('intRand', '12');
class Relatorio extends \yii\db\ActiveRecord
{
    public $file;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'relatorio';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idTipoProger', 'idProger', 'populacaoAtingida', 'dataInicio', 'dataFim'], 'required'],
            [['idTipoProger', 'idProger', 'populacaoAtingida'], 'integer'],
            [['dataInicio', 'dataFim', 'dataEntregaRelatorio'], 'safe'],
            ['dataFim', 'compare', 'operator' => '>=', 'compareAttribute' => 'dataInicio'],
            [['urlArquivo'], 'string'],
            [['file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'pdf'],
            [['idTipoProger'], 'exist', 'skipOnError' => true, 'targetClass' => TipoProger::className(), 'targetAttribute' => ['idTipoProger' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'idTipoProger' => 'Tipo Proger',
            'idProger' => 'Proger',
            'populacaoAtingida' => 'População Atingida',
            'dataInicio' => 'Data de  Início',
            'dataFim' => 'Data do  Fim',
            'dataEntregaRelatorio' => 'Data  de Entrega Relatório',
            'urlArquivo' => 'Arquivo',
            'file' => 'Relatório',
        ];
    }

    //esta função é executada logo apos salvar os dados no banco
    //é usada pra salvar o arquivo de upload
    public function beforeSave($insert) {
        if($this->file){
            $oldfile="a";//importante nao ser null ou vazio
            if(isset($this->urlArquivo)) //caso seja uma atualização carrega o nome do arquivo antigo
                $oldfile = substr($this->urlArquivo,0,intRand).substr($this->urlArquivo, strpos($this->urlArquivo,'.'));

            $this->urlArquivo = $this->file->baseName.'.'.$this->file->extension;
            //o nome do arquivo será um valor random alfanumerico de 12 digitos .pdf
            //no banco será salvo este valor alfanumerico concatenado com o nome do arquivo
            //para usar o nome random alfanumerico use a funcao getFileNameRand e getFileName para o nome (funcoes desse model)
            $strRand = $this->randKey("abcdefghijklmnopqrstuvxwyz0123456789", intRand);
            $this->urlArquivo = $strRand.$this->urlArquivo; //gera o nome do novo arquivo
            $caminho = Yii::$app->params['caminhoRelatorio'];
            $path = "$caminho$this->idTipoProger$this->idProger";//pasta do projeto é uma junção do tipoProger com o id
            if(!file_exists($path)) 
                FileHelper::createDirectory($path); //cria a pasta do projeto se nao existir
            else{
                if(file_exists($path.'/'.$oldfile)){
                    unlink(Yii::$app->basePath.'/web/'.$path.'/'.$oldfile);//deleta o arquivo antigo
                }
            }
            $this->file->saveAs($path.'/'.$strRand.'.'.$this->file->extension);// salva o arquivo novo
        }         
        return parent::beforeSave($insert);
    }

    //executa apos o delete dos dados no banco
    //serve pra deletar o arquivo
    public function afterDelete() {
        $strRand = substr($this->urlArquivo,0,intRand).substr($this->urlArquivo, strpos($this->urlArquivo,'.'));
        $caminho = Yii::$app->params['caminhoRelatorio'];
        $path = "$caminho$this->idTipoProger$this->idProger/$strRand";
        $path = Yii::$app->basePath.'/web/'.$path;
        if(file_exists($path)){
            unlink($path);
        }
    }

    private function randKey ($str='', $long=0){
        $key = null;
        $str = str_split($str);
        $start = 0;
        $limit = count($str)-1;
        for ($x=0; $x<$long; $x++){
            $key .= $str[rand($start, $limit)];
        }
        return $key;
    }
    //pega o nome do arquivo
    public function getFileName(){
        return substr($this->urlArquivo,intRand);
    }
    //pega o nome random alfanumerico
    public function getFileNameRand(){
        return substr($this->urlArquivo,0,intRand).substr($this->urlArquivo, strpos($this->urlArquivo,'.'));
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdTipoProger0()
    {
        return $this->hasOne(TipoProger::className(), ['id' => 'idTipoProger']);
    }
}
