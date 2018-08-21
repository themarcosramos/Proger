<?php

use yii\helpers\Html;
use \yii\helpers\ArrayHelper;
use yii\helpers\Url;
use app\models\Situacao;
use app\models\GrandeArea;
use app\models\AreaAtuacao;
use app\models\SubArea;
use app\models\Especialidade;
use app\models\Setor;
use app\models\ProgramaProger;
use app\models\Gestor;
use app\models\TipoEncargo;
use app\widgets\fluxo;
use app\models\UsuarioGestor;
use app\views\municipios\municipiosAbrangidosWidget;
use kartik\widgets\ActiveForm;
use kartik\field\FieldRange;
use kartik\datecontrol\DateControl;


/* @var $this yii\web\View */
/* @var $model app\models\ProjetoProger */
/* @var $form yii\widgets\ActiveForm */
$this->title = (isset($nome))?'Projeto '.$nome: 'Novo projeto';
?>

<h1><?=(isset($nome))?'Projeto '.$nome: 'Novo projeto'?></h1>
<?= Fluxo::widget(['index'=>1, 'novo'=>$novo, 'action'=>'projeto-proger/cadastrar', 'idmodel'=>$model->id]); ?>

<div class="well">
   

    <!-- form de projeto -->
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nome')->textInput(['maxlength' =>300,'style' =>'width: 50%']) ?>

    <?= $form->field($model, 'idTipoEncargo')->dropDownList(ArrayHelper::map(TipoEncargo::find()->orderBy('nome')->all(),'id', 'nome'),['prompt'=>'Selecione a natureza do projeto', 'style' =>'width: 50%']) ?>

    <?= $form->field($model, 'descricao')->textArea(['maxlength' =>500,'style' =>'width: 50%' ])?>

    <?php // Se nome do projeto existe, exibe campo Situação para poder ser alterado
    if($nome == true){
        echo $form->field($model, 'idSituacao')->dropDownList(ArrayHelper::map(Situacao::find()->orderBy('nome')->where(['ativo' => 1])->all(),'id', 'nome'),['style' =>'width: 50%']);
    }else{
        echo $form->field($model, 'idSituacao')->dropDownList(ArrayHelper::map(Situacao::find()->where(['id'=>1])->where(['ativo' => 1])->all(),'id', 'nome'),['style' =>'width: 50%', 'disabled'=> true]);
    }
    ?>

    <?php
                $grandeArea = ArrayHelper::map(GrandeArea::find()->where(['ativo' => 1])->all(), 'id', 'nome');
                echo $form->field($model, 'idGrandeArea')->dropDownList(
                    $grandeArea,
                    [
                        'prompt'=>'Selecione uma grande área', 'style' =>'width: 50%',
                        'onchange'=>'$.get( "'.Url::toRoute('/site/area').'", { id: $(this).val()}).done(function(data) 
                            {
                                $( "#'.Html::getInputId($model, 'idAreaAtuacao').'" ).html( data );
                            });',
                        'load'=>'$.get( "'.Url::toRoute('/site/area').'", { id: $(this).val()}).done(function(data) 
                        {
                            $( "#'.Html::getInputId($model, 'idAreaAtuacao').'" ).html( data );
                        });',
                    ]
                ); 
    ?>

    <?php
            $areaAtuação = ArrayHelper::map(AreaAtuacao::find()->where(['idGrandeArea' => $model->idGrandeArea, 'ativo' => 1])->all(), 'id', 'nome');

            echo $form->field($model, 'idAreaAtuacao')->dropDownList(
                $areaAtuação,
                [
                    'prompt'=>'', 'style' =>'width: 50%',
                    'onchange'=>'$.get( "'.Url::toRoute('/site/subarea').'", { id: $(this).val()}).done(function(data) 
                        {
                            $( "#'.Html::getInputId($model, 'idSubArea').'" ).html( data );
                        });',
                    'load'=>'$.get( "'.Url::toRoute('/site/subarea').'", { id: $(this).val()}).done(function(data) 
                    {
                        $( "#'.Html::getInputId($model, 'idSubArea').'" ).html( data );
                    });',
                ]
            ); 
    ?>


    <?php
            $subArea = ArrayHelper::map(SubArea::find()->where(['idAreaAtuacao' => $model->idAreaAtuacao, 'ativo' => 1])->all(), 'id', 'nome');
            echo $form->field($model, 'idSubArea')->dropDownList(
                $subArea,
                [
                    'prompt'=>'', 'style' =>'width: 50%',
                    'onchange'=>'$.get( "'.Url::toRoute('/site/especialidade').'", { id: $(this).val()}).done(function(data) 
                        {
                            $( "#'.Html::getInputId($model, 'idEspecialidade').'" ).html( data );
                        });',
                    'load'=>'$.get( "'.Url::toRoute('/site/especialidade').'", { id: $(this).val()}).done(function(data) 
                    {
                        $( "#'.Html::getInputId($model, 'idEspecialidade').'" ).html( data );
                    });',
                ]
            ); 
    ?>   
   

    <?php
            $especialidade = ArrayHelper::map(Especialidade::find()->where(['idSubArea' => $model->idSubArea, 'ativo' => 1])->all(), 'id', 'nome');
            echo $form->field($model, 'idEspecialidade')->dropDownList( $especialidade, ['prompt'=>'', 'style' =>'width: 50%']) 
    ?> 
    

    <?= $form->field($model, 'idSetor')->dropDownList(ArrayHelper::map(Setor::find()->orderBy('nome')->where(['ativo' => 1])->all(),'id', 'nome'),['prompt'=>'Selecione um setor', 'style' =>'width: 50%']) ?>

      <?php
       if(\Yii::$app->user->can('admin')){
        echo $form->field($model, 'idPrograma')->dropDownList(ArrayHelper::map(ProgramaProger::find()->all(),'id', 'nome'),['prompt'=>'Nenhum', 'style' =>'width: 50%']);
        }else{
         echo $form->field($model, 'idPrograma')->dropDownList(ArrayHelper::map(ProgramaProger::find()->where(['idGestor'=> UsuarioGestor::find()->where(['idUsuario'=>Yii::$app->user->getId()])->one()])->all(),'id', 'nome'),['prompt'=>'Nenhum', 'style' =>'width: 50%']);
       }
       ?>
    
    <?= $form->field($model, 'interdepartamental')->radioList(array('1'=>'Sim','0'=>'Não')) ?>
    
    <?= $form->field($model, 'interinstitucional')->radioList(array('1'=>'Sim','0'=>'Não')) ?>
   

   <div style ="width: 50%">               
                <?php
                    
                     echo FieldRange::widget([
                        'form' => $form,
                        'model' => $model,
                        'label' => 'Duração',
                        'separator' => 'até',
                        'attribute1' => 'dataInicio',
                        'attribute2' => 'dataFim',                  
                        'type' => FieldRange::INPUT_WIDGET,
                        'widgetClass' => DateControl::classname(),
                        'widgetOptions1'=>[
                            'displayFormat'=>'dd/MM/yyyy',
                        ],
                        'widgetOptions2'=>[
                            'displayFormat'=>'dd/MM/yyyy'
                        ],
                    ]);
               //Através das linhas de código a cima faz com o usuário, possa inserir a data de início e fim formado assim o período do financiamento .  ?>
        </div> 
     <?= $form->field($model, 'resolucoes')->textarea(['maxlength' =>500,'style' =>'width: 50%' ]) ?>   
    <?= $form->field($model, 'observacoes')->textArea(['maxlength' =>500,'style' =>'width: 50%' ]) ?>
    <!-- se tiver permissao de admin (verificado no controller) habilita o campo de idGestor -->
    <?= $form->field($model, 'idGestor')->dropDownList(ArrayHelper::map(Gestor::find()->orderBy('nome')->all(),'id', 'nome'),[ 'prompt'=>'Selecione um gestor', 'style' =>'width: 50%', 'disabled'=>!$admin]) ?>

    <div class="form-group">
        <?= Html::submitButton('Salvar', ['class' => 'btn btn-success']) ?>
    </div> 
       
    <?php ActiveForm::end(); ?>  
    <div class="form-group">

        <?=$model->isNewRecord ?'': Html::a('Avançar (Etapa 2)', ['/projeto-proger/cadastrar','n'=>$novo, 's'=>2,'idmodel'=>$model->id],['class'=>'btn btn-warning','title'=>"Esta ação não salva dados, certifique-se de salvar os dados antes de prosseguir"]) ?>
        
    </div>
</div>
<div>
    <?= Html::a('Ver Projetos', ['/projeto-proger/index'],['class'=>'btn btn-info  btn']) ?>
</div>
