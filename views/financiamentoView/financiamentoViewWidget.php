<?php
namespace app\views\financiamentoView;

use yii\base\Widget;
use yii\helpers\Html;
use app\models\Financiamento;
use yii\data\ActiveDataProvider;


class financiamentoViewWidget extends Widget{     
    public $model; //Financiamento model
    public $type; //o que vai ser renderizado, grid ou form
    public $idmodel; //id do Proger
    public $idTipoProger; //tipo do Proger
    public $novo; //se é um novo registro de Proger ou uma atualização
    public $controller; //controller onde serão chamadas as actions dos botoes da gridview, ex: curso-proger
    
    public function init(){
        parent::init();
    }

    public function run(){

        switch ($this->type) {
            case 'form':
                return $this->render('_formview', ['model'=>$this->model]);
                break;
            case 'gridview':
                $query = new ActiveDataProvider([
                    'query' => Financiamento::find()->where(['idProger' => $this->idmodel, 'idTipoProger'=> $this->idTipoProger]),
                    'pagination' => ['pageSize' => 10],        
                ]);
                return $this->render('gridview', ['query'=>$query, 'controller'=>$this->controller,'novo'=>$this->novo]);
                break;            
            default:
                return $this->render('_formview', ['model'=>$this->model]); 
        }        
    }
        

}