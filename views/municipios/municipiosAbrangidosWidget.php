<?php
namespace app\views\municipios;

use yii\base\Widget;
use yii\helpers\Html;
use app\models\MunicipiosAbrangidos ;
use yii\data\ActiveDataProvider;

class municipiosAbrangidosWidget extends Widget{
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
        switch ($this->type) {
            case 'form':
                return $this->render('_form', ['model'=>$this->model]);                
                break;
            case 'gridview':
                $query = new ActiveDataProvider([
                    'query' =>MunicipiosAbrangidos::find()->where(['idProger' => $this->idmodel, 'idTipoProger'=> $this->idTipoProger]),
                    'pagination' => ['pageSize' => 10],        
                ]);
                return $this->render('gridview', ['query'=>$query, 'controller'=>$this->controller, 'novo'=>$this->novo]);
                break;            
            default:
                return $this->render('_form', ['model'=>$this->model]); 
        } 
    }
}