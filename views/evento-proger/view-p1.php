<?php

use yii\helpers\Html;
use \yii\helpers\ArrayHelper;
use app\models\TipoEvento;
use app\models\Situacao;
use app\models\GrandeArea;
use app\models\AreaAtuacao;
use app\models\SubArea;
use app\models\Especialidade;
use app\models\TipoProger;
use app\models\Gestor;
use app\models\TipoEncargo;
use app\widgets\fluxo;
use yii\helpers\Url;
use app\models\ProgramaProger;
use app\models\ProjetoProger;
use kartik\widgets\ActiveForm;
use kartik\field\FieldRange;
use kartik\datecontrol\DateControl;


/* @var $this yii\web\View */
/* @var $model app\models\EventoProger */
/* @var $form yii\widgets\ActiveForm */
$this->title = (isset($nome))?'Evento '.$nome: 'Novo Evento ';
?>

<h1><?=(isset($nome))?'Evento '.$nome: 'Novo Evento'?></h1>
<?= Fluxo::widget(['index'=>1, 'novo'=>$novo, 'action'=>'evento-proger/view', 'idmodel'=>$model->id]);?>

<div class="well">
  
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nome')->textInput(['maxlength' =>300,'style' =>'width: 50%', 'disabled'=> true]) ?>
    
    <?= $form->field($model, 'idTipoEncargo')->dropDownList(ArrayHelper::map(TipoEncargo::find()->orderBy('nome')->all(),'id', 'nome'),['prompt'=>'Selecione a natureza do evento', 'style' =>'width: 50%', 'disabled'=> true]) ?>

    <?= $form->field($model, 'descricao')->textArea(['maxlength' =>500,'style' =>'width: 50%', 'disabled'=> true]) ?>

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
                        'disabled'=> true]
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
                    'disabled'=> true]
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
                    'disabled'=> true]
            ); 
    ?>

     <?php
            $especialidade = ArrayHelper::map(Especialidade::find()->where(['idSubArea' => $model->idSubArea, 'ativo' => 1])->all(), 'id', 'nome');
            echo $form->field($model, 'idEspecialidade')->dropDownList( $especialidade, ['prompt'=>'', 'style' =>'width: 50%', 'disabled'=> true]) 
    ?>
    
    <?= $form->field($model, 'idTipoEvento')->dropDownList(ArrayHelper::map(TipoEvento::find()->orderBy('nome')->where(['ativo' => 1])->all(),'id', 'nome'),['prompt'=>'Selecione um tipo de evento', 'style' =>'width: 50%', 'disabled'=> true])  ?>    

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
                            'disabled'=> true],
                        'widgetOptions2'=>[
                            'displayFormat'=>'dd/MM/yyyy',
                        'disabled'=> true],
                    ]);
               //Através das linhas de código a cima faz com o usuário, possa inserir a data de início e fim formado assim o período do financiamento .  ?>
        </div> 

    <?= $form->field($model, 'observacoes')->textArea(['maxlength' =>500,'style' =>'width: 50%', 'disabled'=> true]) ?>

    <?= $form->field($model, 'idGestor')->dropDownList(ArrayHelper::map(Gestor::find()->orderBy('nome')->all(),'id', 'nome'),[ 'prompt'=>'Selecione um gestor', 'style' =>'width: 50%', 'disabled'=> true]) ?>
    
    <?= $form->field($model,'numeroParticipantes')->textInput(['maxlength'=>8,'style'=>'width: 30%','onlynumber' => 'true', 'disabled'=> true]) ?>    

    <fieldset style="width: 50%; border:2px solid DarkSeaGreen; padding-left:20px; margin-bottom: 20px; ">

    <legend style="width: 25%; color: #363636;" >Subordinação</legend>
       
    <?php
        $tipoProgerCurso = ArrayHelper::map(TipoProger::find()->andwhere(['id'=>[1,2]])->all(), 'id', 'nome');
        echo $form->field($model, 'idTipoProger', ['options' => ['style' =>'width: 50%']])->dropDownList(
            $tipoProgerCurso,
            [
                'prompt'=>'Selecione um tipo',
                'onchange'=>'$.get( "'.Url::toRoute('/curso-proger/get-array-proger').'", { id: $(this).val()}).done(function(data) 
                    {
                        $( "#'.Html::getInputId($model, 'idProger').'" ).html( data );
                    });',
                'load'=>'$.get( "'.Url::toRoute('/curso-proger/get-array-proger').'", { id: $(this).val()}).done(function(data) 
                {
                    $( "#'.Html::getInputId($model, 'idProger').'" ).html( data );
                });',
                'disabled'=> true]
        ); 
    ?>
    
    <!-- Pega o idTipoProger e compara com o tipo Proger do Curso para cadastrar e atualizar cadastro -->    
    <?php

        $progers=[];
        
        $tipo = '';

        if($model->idTipoProger!=0){
            $tipo = TipoProger::findOne($model->idTipoProger)->nome;
        }
        switch ($tipo) {
            case 'Programa':
                $progers = ArrayHelper::map(ProgramaProger::find()->all(), 'id', 'nome');
                break;
            case 'Projeto':
                $progers = ArrayHelper::map(ProjetoProger::find()->all(), 'id', 'nome');
                break;
            case 'Curso':
                $progers = ArrayHelper::map(CursoProger::find()->all(), 'id', 'nome');
                break;
            case 'Evento':
                $progers = ArrayHelper::map(EventoProger::find()->all(), 'id', 'nome');
                break;
            default:
                null;
                break;
        }

        echo $form->field($model, 'idProger')->dropDownList( $progers, ['prompt'=>'Selecione um proger', 'style' =>'width: 50%', 'disabled'=> true]);
        
    ?>

    </fieldset>

<?php ActiveForm::end(); ?>  
<div class="form-group">

    <?=$model->isNewRecord ?'': Html::a('Avançar (Etapa 2)', ['/evento-proger/view','n'=>$novo, 's'=>2,'idmodel'=>$model->id],['class'=>'btn btn-warning',]) ?>
    
</div>
</div>
<div>
    <?= Html::a('Ver Eventos', ['/evento-proger/index'],['class'=>'btn btn-info  btn']) ?>
</div>

