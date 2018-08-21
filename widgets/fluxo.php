<?php
namespace app\widgets;

use yii\base\Widget;

class fluxo extends Widget{
    public $action;
    public $idmodel;
    public $index;
    public $novo;

    public function init(){
        parent::init();
    }

    public function run(){
        return $this->render('fluxoview', [
            'action'=>$this->action, 'idmodel'=>$this->idmodel, 'index'=>$this->index, 'novo'=>$this->novo
            ]);
    }
}