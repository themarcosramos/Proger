<?php 
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use \yii\helpers\ArrayHelper;
use yii\widgets\MaskedInput;
use app\models\Estado;
use app\models\Cidade;
//paramesters
$fieldWidth = '50%';
$fieldWidth1 = '52.5%';
?>

<script language="javascript">

    window.onload = function(){
        validaCPF();
    }   
    function validaCPF(){
        if($('#pessoa-cpf').val().length != 0){
            $("#inputError").empty();              
            var request = $.ajax({                          //manda a requisicao pra este endereco (controller/action)
                url: "<?= Yii::$app->urlManager->createUrl('pessoa/valida-cpf'); ?>",
                data: "cpf="+$("#pessoa-cpf").val(), //pega o valor digitado pelo usuario no campo cpf
                type: 'POST',
            }); 
            
            request.done(function(msg) { //requisição feita com sucesso
                console.log(msg)

               if(msg == 0){
                   $("#inputError").html('<p style="color: #b94a48">Informe um CPF Válido</p>');  
                   document.getElementById('pessoa-cpf').value=''; // Limpa o campo                  
                   $("#pessoa-cpf").focus();
                }
                              
            });
            request.fail(function(jqXHR, textStatus) { //requisição fracassada
                console.log("Request failed: " + textStatus);
                $("#inputError").empty();
                
            });     
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


<div class="well">    
    <?php $form = ActiveForm::begin();
    $request = Yii::$app->request;
    $alerta = $request->get('alerta');
      
    if($alerta == true){
        echo  "<script> alert('Pessoa já cadastrada');</script>";
    }?>

    <div style="width:<?= $fieldWidth?>">
        <?= $form->field($model, 'cpf')->textInput(['maxlength' =>14,'onBlur'=>'js:validaCPF();','onkeypress'=>'js:mascara(this,cpf);']);?>
    </div>
    <div class="help-block" align="left" id="inputError" >
    </div>

    <?= $form->field($model, 'nome')->textInput(['maxlength' =>100, 'style' =>'width: '.$fieldWidth]) ?>

    <div style="width:<?= $fieldWidth?>">
        <?= $form->field($model, 'rg')->textInput(['type'=>'number','min' =>1]);
        ?>
    </div>

    <?= $form->field($model, 'email')->textInput(['maxlength' =>45, 'style' =>'width: '.$fieldWidth]) ?>  

    <div class="row" style="width:<?= $fieldWidth1?>">   
        <div class="col-sm-3 col-md-6">
            <?= $form->field($model, 'telefone')->widget(MaskedInput::classname(), [
                    'mask' => '(99)9999-9999',
                    'clientOptions' => [
                                               
                        'placeholder' => '',
                        
                    ]
                ]); 
            ?>
        </div>
        <div class="col-sm-3 col-md-6">
            <?= $form->field($model, 'celular')->widget(
                MaskedInput::classname(), [                    
                    //'model' =>$model,
                    //'attribute' => 'cecular',
                    //'name' => 'celular',
                    'mask' => '(99)99999-9999',
                    'clientOptions' => [
                                               
                        'placeholder' => '',
                        
                    ]
                ]); 
            ?>
        </div>
    </div>

    <div class="row" style="width:<?= $fieldWidth1?>">  
        <div class="col-sm-3 col-md-9"> 
            <?= $form->field($model, 'rua')->textInput(['maxlength' =>100]) ?>
        </div>
        <div class="col-sm-3 col-md-3"> 
            <?= $form->field($model, 'numero')->textInput(['type'=>'number','min' =>0]);
            ?>
        </div>
    </div>    

    <div class="row" style="width:<?= $fieldWidth1?>">
        <div class="col-sm-3 col-md-9">
            <?= $form->field($model, 'bairro')->textInput(['maxlength' =>45]) ?>
        </div>
        <div class="col-sm-3 col-md-3">
            <?= $form->field($model, 'cep')->widget(
                MaskedInput::classname(), [
                    'mask' => '99999-999',
                    'clientOptions' => [
                                               
                        'placeholder' => '',
                        
                    ]
                ]);
            ?> 
        </div>
    </div>    

    <div class="row" style="width:<?= $fieldWidth1?>">   
        <div class="col-sm-3 col-md-6">             
            <?php
                $estado = ArrayHelper::map(Estado::find()->where(['ativo' => 1])->all(), 'id', 'nome');
                echo $form->field($model, 'idEstado')->dropDownList(
                    $estado,
                    [
                        'prompt'=>'Selecione um estado',
                        'onchange'=>'$.get( "'.Url::toRoute('/pessoa/cidade').'", { id: $(this).val()}).done(function(data) 
                            {
                                $( "#'.Html::getInputId($model, 'idCidade').'" ).html( data );
                            });',
                        'load'=>'$.get( "'.Url::toRoute('/pessoa/cidade').'", { id: $(this).val()}).done(function(data) 
                        {
                            $( "#'.Html::getInputId($model, 'idCidade').'" ).html( data );
                        });',
                    ]
                ); 
            ?>
        </div>  

        <div class="col-sm-3 col-md-6">
        <?php
            $cidade = ArrayHelper::map(Cidade::find()->where(['idEstado' => $model->idEstado, 'ativo' => 1])->all(), 'id', 'nome');
            echo $form->field($model, 'idCidade')->dropDownList( $cidade, ['prompt'=>'Selecione um estado primeiro']) 
        ?> 
        </div>

        <div style="width:<?= $fieldWidth?>">
        <div class="col-sm-3 col-md-3"> 
            <?= Html::submitButton($model->isNewRecord ? 'Salvar' : 'Atualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>  
    </div>   

    </div>

    

    <?php ActiveForm::end(); ?>
</div>