<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Gestor;
use kartik\widgets\DatePicker;
use app\models\Setor;
use app\models\Situacao;
use app\models\AreaAtuacao;
use app\models\TipoProger;
use app\models\CursoProger; 
use yii\widgets\DetailView;


/* @var $this yii\web\View */
/* @var $searchModel app\models\search\CursoProgerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$nomeCursoProger = CursoProger::find()->where(['id'=> $idmodel])->one()->nome;

$this->title = 'Curso Proger: '.$nomeCursoProger;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="curso-proger-index">

    <h1><?= $this->title ?></h1>
    

    <hr style="height:1px; border:none; background-color:#D0D0D0; margin-top: 10px; margin-bottom: 15px;" />


</div>
