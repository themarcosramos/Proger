<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;
use yii\widgets\AjaxSubmitButton;

/* @var $this yii\web\View */
/* @var $model app\models\Usuario */

$this->title = 'Minha Conta';
$this->params['breadcrumbs'][] = $this->title;

$model->senha = null;

$this->registerJs('

    $("body").on("beforeSubmit", "form#redefinirSenha", function() {

        var form = $(this);
        if (form.find(".has-error").length) {
          return false;
        }

        $.ajax({
          url: form.attr("minha-conta"),
          type: "post",
          data: form.serialize(),
          success: function(result) {
            //$("#modal-senha").modal("hide");
            //$("#resultado-senha").html("<div align=\"center\" class=\"alert-success alert fade in\"><strong>"+result+"</strong></div>");
            alert(result);
            location.reload();
          },
          error: function(error){
            alert("Erro: " + error);
          },
        });

        return false;
    })

');

?>

<div class="well">

    <h1><?= Html::encode($this->title) ?></h1>

    <hr style="height:1px; border:none; background-color:#D0D0D0; margin-top: 10px; margin-bottom: 15px;" />

    <div id="resultado-senha">
    </div>

    <?= DetailView::widget([
        'model' => $model,
        'template' => '<tr><th style="text-align: right; width: 15%">{label}</th><td>{value}</td></tr>',
        'attributes' => [
            [
                'attribute' => 'grupo.descricao',
                'label' => 'Grupo',
            ],
            'nome',
            'login',
            [
                'attribute' => 'email',
                'label' => 'E-mail',
            ],
        ],
    ]) ?>

    <p>

        <?php
            Modal::begin([
                'id' => 'modal-senha',
                'header' => '<h2>Redefinir Senha</h2>',
                'toggleButton' => ['label' => 'Redefinir Senha', 'class' => 'btn btn-danger'],
            ]);

            $form = ActiveForm::begin([
                'id' => "redefinirSenha",
            ]); ?>

            <div class="alert alert-info">
                <b>Usuário: </b> <?= $model->nome ?>
            </div>

            <div style="width: 400px; margin-left: 80px">
                
                <div class="row">
                    <div class="col-lg-6">
                        <?= $form->field($model, 'senha')->passwordInput(['maxlength' => 10])->label('Digite a nova senha: ')->hint('Máximo: 10 caracteres') ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <?= $form->field($model, 'repeat_password')->passwordInput(['maxlength' => 10])->label('Confirmação de senha: ') ?>
                    </div>
                </div>
            </div>

            <div class="form-group" align="right" style="margin: 20px">
                <?= Html::submitButton('Salvar', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>

            <? Modal::end(); ?>

    </p>

</div>