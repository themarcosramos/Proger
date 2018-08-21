<?php
use yii\helpers\Html;

use \yii\helpers\ArrayHelper;
use app\models\TipoVinculo;
use app\models\TipoFuncao;
use app\models\Instituicao;
use app\models\Setor;
use app\models\Curso; 
use app\models\Pessoa;
use kartik\widgets\ActiveForm;
use kartik\field\FieldRange;
use kartik\datecontrol\DateControl;

//Variaveis passadas pelo widget

/* @var $model app\models\Integrante  model*/
/* @var $update (boolean) indica se é uma atualizacao de registro, ou criação
/* @var $cpf (int) quando o controler passa formType 0, deve passar tb o cpf da pessoa*/
/* @var $idmodel (int) id do projeto */
/* @var $novo (boolean) true se for create, false se for update */

//parameters
$fieldWidth = '50%';
$idBolsista = TipoFuncao::find()->where(['descricao'=>'Bolsista'])->one()->id;
?>
<!-- funcao javascript para buscar o idPessoa e setar no campo  integrante-idpessoa por meio do cpf da pessoa-->
<script language="javascript">

var idBolsista = "<?php echo $idBolsista;?>";

    window.onload = function(){
        buscarPessoa();
    }   
    function buscarPessoa(){
        if($('#pessoa-cpf').val().length != 0){
            $("#inputError").empty();              
            var request = $.ajax({                          //manda a requisicao pra este endereco (controller/action)
                url: "<?= Yii::$app->urlManager->createUrl('integrante/buscar-pessoa'); ?>",
                data: "cpf="+$("#pessoa-cpf").val(), //pega o valor digitado pelo usuario no campo cpf
                type: 'POST',
            }); 
            
            request.done(function(msg) { //requisição feita com sucesso
                console.log(msg)

                if((msg != 0)&&(msg != -1 )){
                    var str = msg.split("§;");            
                    document.getElementById("nome").value = str[1]; //exibe nome em campo desabilitado
                    document.getElementById("exibir-nome").style.display ="block"; //exibe campo com nome
                    document.getElementById("nome-pessoa").style.display ="none"; //oculta o outro campo com nome quando primeiro campo esta sendo exibido
                    document.getElementById('integrante-idpessoa').value=str[0];//seta o id em integrante-idPessoa
                }
                else if(msg == 0){
                   $("#inputError").html('<p style="color: #b94a48">Informe um CPF Válido</p>');  
                   document.getElementById('pessoa-cpf').value=''; // Limpa o campo
                   document.getElementById("exibir-nome").style.display ="none"; //oculta campo com nome
                   document.getElementById('integrante-idpessoa').value='';
                   $("#pessoa-cpf").focus();
                }
                else if(msg == -1){
                   $("#inputError").empty();
                   $("#inputError").html('<strong style="color: #A62E2E">Pessoa não cadastrada!</strong>');
                   document.getElementById('pessoa-cpf').value=''; // Limpa o campo
                   document.getElementById("exibir-nome").style.display ="none"; //oculta campo com nome
                   document.getElementById('integrante-idpessoa').value='';
                }                
            });
            request.fail(function(jqXHR, textStatus) { //requisição fracassada
                console.log("Request failed: " + textStatus);
                
                
            });            
        }
    }     

    function optionCheck(){
        
        var option = document.getElementById("options").value;
        if(option == idBolsista){
            
            document.getElementById("curso").style.display ="block";                  
          
        }else{
            
            document.getElementById("campo-curso").value = '';
            document.getElementById("curso").style.display ="none"; 
               
                
        }

    }

function mascara(o,f){
    v_obj=o
    v_fun=f
    setTimeout("execmascara()",1)
}

function execmascara(){
    v_obj.value=v_fun(v_obj.value)
}

function cpf(v){
    v=v.replace(/\D/g,"")                    //Remove tudo o que não é dígito
    v=v.replace(/(\d{3})(\d)/,"$1.$2")       //Coloca um ponto entre o terceiro e o quarto dígitos
    v=v.replace(/(\d{3})(\d)/,"$1.$2")       //Coloca um ponto entre o terceiro e o quarto dígitos
                                             //de novo (para o segundo bloco de números)
    v=v.replace(/(\d{3})(\d{1,2})$/,"$1-$2") //Coloca um hífen entre o terceiro e o quarto dígitos
    return v
}

</script>

<h3>Novo Integrante</h3>
<div class="integrante-form">

    <?php $form = ActiveForm::begin(); 
        $pessoa = new Pessoa();
        $pessoa->cpf = $cpf;
        
        if($model->idPessoa == true){//Pega nome do integrante na edição
        $pessoa->nome= Pessoa::find()->where(['id' => $model->idPessoa ])->one()->nome;
        }        
    ?>
    <!-- campo cpf, fica desabilitado pra edicao se for uma edicao de integrante -->
    <?= (!$update)?$form->field($pessoa, 'cpf', $options = ['labelOptions'=>['label'=>'Consultar CPF']])->textInput(['maxlength' =>14,'onBlur'=>'js:buscarPessoa();','onkeypress'=>'js:mascara(this,cpf);','style' =>'width: '.$fieldWidth]): $form->field($pessoa, 'cpf')->textInput(['disabled'=>true, 'style' =>'width: '.$fieldWidth])?>
    <!-- Campo pra exibir as mensagens da requisicao feita pela funcao em javascript -->    
    <div class="help-block" align="left" id="inputError" >
    </div>
    <div style="display: none" id="exibir-nome" >
    <?php if($model->idPessoa == false){ // Campo para exibir nome da pessoa em cadastro de integrante
        echo $form->field($pessoa, 'nome')->textInput(['disabled'=>true,'style' =>'width: '.$fieldWidth, 'id'=>'nome']);
    }?>
    </div>
    <div style="display: block" id="nome-pessoa" >
    <?php if($pessoa->cpf == true){ // Campo para exibir nome da pessoa em edição de integrante e transição do cadastro de pessoa para integrante
    $pessoa->nome= Pessoa::find()->where(['cpf' => $pessoa->cpf ])->one()->nome;
     echo $form->field($pessoa, 'nome')->textInput(['disabled'=>true, 'style' =>'width: '.$fieldWidth]);
    }?>
    </div>
    <div class="help-block" id="cadastrarlink">
        <a href="?r=<?=$controller?>/create-pessoa&n=<?= $novo?>&idmodel=<?php echo $idmodel?>">Deseja cadastrar pessoa?</a> 
    </div>
    <?php ActiveForm::end();?>
    <?php $form = ActiveForm::begin();?>
    <!-- Hidden -->
    <div style="display: none" >
        <?php if($pessoa->cpf == true){// Seta idPessoa no campo na transição do cadastro de pessoa para integrante
        $model->idPessoa= Pessoa::find()->where(['cpf' => $pessoa->cpf ])->one()->id;
        echo  $form->field($model, 'idPessoa')->textInput();
        }else {
        echo  $form->field($model, 'idPessoa')->textInput();  
        }?>
    </div>

    <?= $form->field($model, 'idTipoVinculo')->dropDownList(ArrayHelper::map(TipoVinculo::find()->orderBy('descricao')->where(['ativo' => 1])->all(),'id', 'descricao'),['prompt'=>'Selecione um vínculo', 'style' =>'width: '.$fieldWidth]) ?>

    <?=$form->field($model, 'idTipoFuncao')->dropDownList([$idBolsista => 'Bolsista'] + ArrayHelper::map(TipoFuncao::find()->orderBy('descricao')->where(['ativo' => 1])->all(),'id', 'descricao'),['prompt'=>'Selecione uma função','style' =>'width: '.$fieldWidth, 'id'=>'options', 'onchange'=>'js:optionCheck()']);?>
    
    <div id="curso" style="<?php if($model->idCurso == true){ echo 'display:block';}else{ echo 'display:none';}?>">
    <?=$form->field($model, 'idCurso')->dropDownList(ArrayHelper::map(Curso::find()->orderBy('nome')->where(['ativo' => 1])->all(),'id', 'nome'),['prompt'=>'Selecione um curso', 'style' =>'width: '.$fieldWidth,'id'=>'campo-curso'])?>
    </div>

    <?= $form->field($model, 'idInstituicao')->dropDownList(ArrayHelper::map(Instituicao::find()->orderBy('instituicao')->where(['ativo' => 1])->all(),'id', 'instituicao'),['prompt'=>'Selecione uma instituição', 'style' =>'width: '.$fieldWidth]) ?>

    <?= $form->field($model, 'idSetor')->dropDownList(ArrayHelper::map(Setor::find()->orderBy('nome')->where(['ativo' => 1])->all(),'id', 'nome'),['prompt'=>'Selecione um setor', 'style' =>'width: '.$fieldWidth]) ?>
    
    <!-- Campo ativo só surge para edição de integrante -->
    <div style="display:<?= $model->isNewRecord ? 'none': 'block'?>">
    <?=$form->field($model, 'ativo')->radioList(array('1'=>'Sim','0'=>'Não'))?>
    </div>
    
    
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

    <?= $form->field($model, 'matricula')->textInput(['maxlength' =>15,'style' =>'width: '.$fieldWidth, 'placeholder'=>'Apenas números']) ?>

    <?= $form->field($model, 'cargaHoraria')->textInput(['maxlength' =>4,'style' =>'width: '.$fieldWidth, 'placeholder'=>'Apenas números']) ?>
    
   
    <!-- Botão Salvar só surge para cadastrar novo integrante -->
    <div class="form-group" style="display:<?= $model->isNewRecord ? 'block': 'none'?>">
        <?= Html::submitButton( 'Salvar', ['class' => 'btn btn-success']) ?>
    </div>
    
    <!-- Botão Atualuzar e Cancelar só surge na edição de integrante -->
    <div class="form-group" style="display:<?= $model->id ? 'block': 'none'?>" >
    <?= Html::submitButton('Atualizar', ['class' => 'btn btn-primary']) ?>
    <a href="?r=<?=$controller?>/cadastrar&n=<?= $novo?>&s=2&idmodel=<?php echo $idmodel?>" class="btn btn-warning">Cancelar</a>
    </div>
    
    <?php ActiveForm::end(); ?>
</div>