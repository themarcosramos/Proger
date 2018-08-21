<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\grid\GridView;
use app\widgets\fluxo;
use app\models\Situacao;
use app\models\TipoEncargo;
use app\models\AreaAtuacao;
use app\models\Setor;
use app\models\Gestor;
use app\models\Pessoa;
use app\models\ProgramaProger;
use app\models\Relatorio;

?>

<div class="projeto-proger-detail-view"
Hu
<?php 
switch ($salto) {
    case 3:
        echo "<div><h4>Relatório $model->id</h4></div>";
        echo DetailView::widget([
            'model' => $model,
            'attributes' => [
                'populacaoAtingida',
                'dataInicio',
                'dataFim',
                [
                    'attribute' => 'urlArquivo',
                    'value' => $model->getFileName(),
                ],
            ],
        ]);
        break;
}
?>
</div>