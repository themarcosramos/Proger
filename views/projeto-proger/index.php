<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\models\Setor;
use app\models\Situacao;
use app\models\AreaAtuacao;
use kartik\export\ExportMenu;
use app\models\UsuarioGestor;
use app\models\Usuario;
use app\models\Gestor;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\ProjetoProgerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Projetos';
$this->params['breadcrumbs'][] = $this->title;

//Pega o usuario logado e gestor para exibir no cabeçalho e rodapé do formato PDF
if(Yii::$app->user->getId() == true){
    
    $idUsuario = UsuarioGestor::find()->where(['idUsuario'=>Yii::$app->user->getId()])->one()->idUsuario;
    $nomeUsuario = Usuario::find()->where(['idUsuario'=>$idUsuario])->one()->nome;  
    $idGestor = UsuarioGestor::find()->where(['idUsuario'=>Yii::$app->user->getId()])->one()->idGestor;
    $gestor = Gestor::find()->where(['id'=>$idGestor])->one()->nome;
}

// Opções de cabeçalho e rodapé para o formato PDF
$pdfCabecalho = [
    'L' => [ // configuração do canto esquerdo
        'content'   => 'Gerado por: '.$nomeUsuario,
        'font-size' => 8,
        'color'     => '#000000'
    ],
    'C' => [ // configuração do centro
        'content'   => 'Projetos',
        'font-size' => 16,
        'color'     => '#000000'
    ],
    'R' => [ // configuração do canto direito
        'content'   => 'Gerado em' . ': ' . date("d/m/y H:i:s"),
        'font-size' => 8,
        'color'     => '#000000'
    ]
];
$pdfRodape = [
    'L'    => [ // configuração do canto esquerdo
        'content'    => 'Gestor:'.$gestor,
        'font-size'  => 8,
        'font-style' => 'B',
        'color'      => '#000000'
    ],
    'R'    => [ // configuração do canto direito
        'content'     => '[ {PAGENO} ]',
        'font-size'   => 10,
        'font-style'  => 'B',
        'font-family' => 'serif',
        'color'       => '#000000'
    ],
    'line' => TRUE,
];
?>
    
    <?= GridView::widget([ // configurações da GridView Widget \kartik\grid\GridView encontrado em http://demos.krajee.com/grid#gridview
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,       
        'toolbar'=>[
            '{export}', //exibe botão com opções de exportação
            '{toggleData}' //exibe botão com opção para mostrar todos ou paginado
        ],

        'exportConfig' => [// configuração para cada formato de exportação

            GridView::EXCEL => [
                'label' => 'Excel', //o rótulo para o item de menu de formato de exportação exibido.
                'filename' => 'Projetos', //o nome do arquivo base para o arquivo gerado. O padrão é 'grid-export'. Isso será usado para gerar um nome de arquivo padrão para download (a extensão será um dos formatos csv, html ou xls - com base na configuração de formato).      
                'showHeader'      => TRUE, //se deseja mostrar o cabeçalho da tabela na saída. O padrão é verdadeiro.
                'showPageSummary' => TRUE, //se deseja mostrar o resumo da página da tabela na saída. O padrão é verdadeiro.
                'showFooter'      => TRUE, //se deseja mostrar o rodapé da tabela na saída. O padrão é verdadeiro.
                'showCaption'     => TRUE, //se deseja mostrar a legenda da tabela na saída. O padrão é verdadeiro.                  
                'mime'            => 'application/vnd.ms-excel', // o tipo mime (para o formato de arquivo) a ser definido antes de baixar.                
                
            ],
            GridView::PDF => [
                'label' => 'PDF',
                'filename' => 'Projetos',                
                'showHeader'      => TRUE,
                'showPageSummary' => TRUE,
                'showFooter'      => TRUE,
                'showCaption'     => TRUE,               
                'mime'            => 'application/pdf',
                'config'          => [ //as configurações adicionais específicas para cada formato / tipo de arquivo.
                    'mode'          => 'c', //estrutura campos da grid
                    'format'        => 'A4-L', // foramato da pagina.Opções: 'A4' modo retrato e 'A4-L' modo paisagem                                   
                    'methods'       => [
                        'SetHeader' => [// exporta o cabeçalho
                            ['odd' => $pdfCabecalho, 'even' => $pdfCabecalho]
                        ],
                        'SetFooter' => [//exporta o rodapé
                            ['odd' => $pdfRodape, 'even' => $pdfRodape]
                        ],
                    ],                    
                   
                ]
            ]
            
                
            ],
        
        'panel'=>[ // O painel permitirá a configuração de várias seções para incorporar conteúdo / botões, antes e depois do cabeçalho e antes e depois do rodapé.          
            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-globe"></i> Projetos</h3>',
            'type'=>'info',
            'before'=>Html::a('Novo', ['cadastrar','s'=>1, 'novo'=>true], ['class' => 'btn btn-success']),            
        ],
        'autoXlFormat'=>true,
        'export'=>[//configurações de exportação
        'fontAwesome'=>false,// controla exibição dos icones
        'showConfirmAlert'=>false, //popup para confirmar se quer o não fazer o download
        'target'=>GridView::TARGET_SELF //nenhuma janela é exibida neste caso, o download é enviado na mesma página.
        /*Outras opções são: 
        "GridView :: TARGET_BLANK" em que uma nova janela em branco é exibida e fechada após o término do download.
        "GridView :: TARGET_POPUP" pelo qual uma janela pop-up com a mensagem de progresso de download é exibida.
        */
    ],
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

            //'id',
            
            //'nome',
            [
                'attribute' =>'nome', 
                'headerOptions' => ['style'=>'text-align:center; width: 300px'],
                'contentOptions'=>['align' => 'center']
            ],
            //'descricao',
            [
                'attribute' => 'descricao',
                //'label' => 'Descricao',
                'headerOptions' => ['style'=>'text-align:center; width: 320px '],
                
            ],
            //'idSituacao',
            [
                'attribute' => 'idSituacao',
                'filter' => Situacao::dropdown(),
                'value' => function($model, $index, $dataColumn) {
                    $dropdown = Situacao::dropdown();
                    return $dropdown[$model->idSituacao];
                },
                'headerOptions' => ['style'=>'text-align:center; width: 130px'],
                'contentOptions'=>['align' => 'center']
            ],
            //'idAreaAtuacao',
            [
                'attribute' => 'idAreaAtuacao',
                'filter' => AreaAtuacao::dropdown(),
                'value' => function($model, $index, $dataColumn) {
                    $dropdown = AreaAtuacao::dropdown();
                    return
                     $dropdown
                     [$model->idAreaAtuacao];
                },
                'headerOptions' => ['style'=>'text-align:center; width: 160px'],
                'contentOptions'=>['align' => 'center']
            ],
            //'idSetor',
            /*[
                'attribute' => 'idSetor',
                'filter' => Setor::dropdown(),
                'value' => function($model, $index, $dataColumn) {
                    $dropdown = Setor::dropdown();
                    return $dropdown[$model->idSetor];
                },
                'headerOptions' => ['style'=>'text-align:center; width: 180px'],
                'contentOptions'=>['align' => 'center']
            ],*/
            // 'idPrograma',
            //'interdepartamental',
            [            
                'attribute' => 'interdepartamental',
                'format' => 'raw',
                'filter' => [1 => 'Sim', 0 => 'Não'],
                'value' => function($model, $index, $dataColumn) {
                    switch($model->interdepartamental){
                        case 1: return  '<p class="label label-success">Sim</p>';
                        case 0: return '<p class="label label-danger">Não</p>';
                    }
                },
                'headerOptions' => ['style'=>'text-align:center; width: 160px'],
                'contentOptions'=>['align' => 'center']
            ],
            //'interinstitucional',
            [
                'attribute' => 'interinstitucional',
                'format' => 'raw',
                'filter' => [1 => 'Sim', 0 => 'Não'],
                'value' => function($model, $index, $dataColumn) {
                    switch($model->interinstitucional){
                        case 1: return  '<p class="label label-success">Sim</p>';
                        case 0: return '<p class="label label-danger">Não</p>';
                    }
                },
                'headerOptions' => ['style'=>'text-align:center; width: 160px'],
                'contentOptions'=>['align' => 'center']
            ],
            // 'dataInicio',
            // 'dataFim',
            // 'observacoes',
            // 'idGestor',
            
           

            //['class' => 'yii\grid\ActionColumn'],
            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'headerOptions' => ['style'=>'text-align:center; '],
                'contentOptions'=>['align' => 'center'],                
                'urlCreator' => function ($action, $model, $key, $index) {
                    if ($action === 'view') {
                        $url = Yii::$app->urlManager->createUrl('projeto-proger/view').'&s=1&idmodel='.$model->id; 
                        return $url;
                    }
                    if ($action === 'update') {
                        $url = Yii::$app->urlManager->createUrl('projeto-proger/cadastrar').'&n=0&s=1&idmodel='.$model->id;
                        return $url;
                    }
                    if ($action === 'delete') {
                        $url = Yii::$app->urlManager->createUrl('projeto-proger/delete').'&id='.$model->id;
                        return $url;
                    }
                }
            ],
        ],
    ]); ?>

