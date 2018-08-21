<?php
namespace app\views\integrante;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\data\ActiveDataProvider;
use app\models\Integrante;
use app\models\Pessoa;
use app\models\search\IntegranteSearch;


class integranteWidget extends Widget{
    public $pessoa; //Pessoa model
    public $integrante; //Integrante model
    public $cpf; //cpf de pessoa
    public $type; // se é um form de pessoa ou form de integrante ou gridview de integrantes
    public $idmodel; //id de Proger
    public $idTipoProger; // tipo de Proger
    public $controller; //controller onde serão chamadas as actions dos botoes da gridview ex: curso-proger
    public $novo; //se é um novo registro de Proger ou uma atualização
    public $updateIntegrante; //se é uma atualização do integrante
    
    public function init(){
        parent::init();
    }

    public function run(){
        switch ($this->type) {
            case 'form':
                if (isset($this->integrante))
                    return $this->render('integrante-form', ['model'=>$this->integrante, 'cpf'=>$this->cpf, 'controller'=>$this->controller, 'update'=>$this->updateIntegrante, 'idmodel'=>$this->idmodel, 'novo'=>$this->novo]);
                else
                    return $this->render('pessoa-form', ['model'=>$this->pessoa]);
                break;
            case 'gridview':
            $searchModel = new IntegranteSearch();
            $query = $searchModel->search(Yii::$app->request->queryParams);
            $query->query->andWhere(['idProger' => $this->idmodel, 'idTipoProger'=> $this->idTipoProger]);
               
                return $this->render('gridview', [ 'searchModel' => $searchModel, 'query'=>$query, 'controller'=>$this->controller,'novo'=>$this->novo]);
                break;            
            default:
                if (isset($this->integrante))
                    return $this->render('integrante-form', ['model'=>$this->integrante, 'cpf'=>$this->cpf, 'controller'=>$this->controller,'update'=>$this->updateIntegrante, 'idmodel'=>$this->idmodel, 'novo'=>$this->novo]);
                else
                    return $this->render('pessoa-form', ['model'=>$this->pessoa]);
        }       
    }

}