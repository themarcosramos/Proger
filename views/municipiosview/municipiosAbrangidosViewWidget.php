<?php
namespace app\views\municipiosview;

use yii\base\Widget;
use yii\helpers\Html;
use app\models\MunicipiosAbrangidos ;
use yii\data\ActiveDataProvider;

class municipiosAbrangidosViewWidget extends Widget{
    public $model; //MunicipiosAbrangidos model
    public $type; // se é um form ou gridview
    public $idmodel; //id de Proger
    public $idTipoProger; // tipo de Proger
    public $controller; //controller onde serão chamadas as actions dos botoes da gridview ex: curso-proger
    public $novo; //se é um novo registro de Proger ou uma atualização


    public function init(){
        parent::init();
    }
    public function run(){
 
                $query = new ActiveDataProvider([
                    'query' =>MunicipiosAbrangidos::find()->where(['idProger' => $this->idmodel, 'idTipoProger'=> $this->idTipoProger]),
                    'pagination' => ['pageSize' => 10],        
                ]);
                return $this->render('gridview', ['query'=>$query, 'controller'=>$this->controller, 'novo'=>$this->novo]);

        
    }
}