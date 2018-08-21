<?php

namespace app\controllers;

use Yii;
use app\models\Integrante;
use app\models\Pessoa;
use app\models\search\Integrante as IntegranteSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * IntegranteController implements the CRUD actions for Integrante model.
 */
class IntegranteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            //se definir access as funcoes buscarPessoa e cidade nao funcionam, mesmo adcionando a permissao
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'buscar-pessoa' => ['POST'],
                ],
            ],
        ];
    }

    public function actionBuscarPessoa(){
        $cpf = $_POST['cpf'];
        $resultado = Pessoa::find()->where(['cpf' => $cpf])->one();
        
        if(isset($resultado)){//idPessoa - Existe Cadastro
            return $resultado->id."§;".$resultado->nome."§;";
        }

        // remove tudo que não seja número
        $cpf = preg_replace("/[^0-9]/", "", $cpf);
        
        // se o tamanho da string for dirente de 11 ou estiver
        if (strlen($cpf) != 11) {
            return 0;   //CPF invalido
        }
        // Verifica se nenhuma das sequências invalidas abaixo 
        // foi digitada. Caso afirmativo, retorna 0
        else if ($cpf == '00000000000' ||
            $cpf == '01234567890' ||
            $cpf == '12345678900' || 
            $cpf == '11111111111' || 
            $cpf == '22222222222' || 
            $cpf == '33333333333' || 
            $cpf == '44444444444' || 
            $cpf == '55555555555' || 
            $cpf == '66666666666' || 
            $cpf == '77777777777' || 
            $cpf == '88888888888' || 
            $cpf == '99999999999' //||               
           // ord($cpf[0])<48       ||
          //  ord($cpf[0])>57
            ) {
            return 0;       
        }else {  // calculo para verificação de cpf invalido
           
            for ($t = 9; $t < 11; $t++) {                 
                for ($d = 0, $c = 0; $c < $t; $c++) {
                    $d += $cpf{$c} * (($t + 1) - $c);
                }
                $d = ((10 * $d) % 11) % 10;
                if ($cpf{$c} != $d) {
                    return 0;
                }
            }     
            return -1;        
       
        }
    }

    public function actionCidade($id){
        $rows = \app\models\Cidade::find()->where(['idEstado' => $id, 'ativo' => 1])->all();
 
        if(count($rows)>0){
            echo "<option>Selecione uma cidade</option>";
            foreach($rows as $row){
                echo "<option value='$row->id'>$row->nome</option>";
            }
        }
        else{
            echo "<option>Nenhuma cidade cadastrado</option>";
        } 
    }

    /**
     * Lists all Integrante models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new IntegranteSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Integrante model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Integrante model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Integrante();
        $model->idProger = 1;
        $model->idTipoProger = 4;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->renderAjax('create', [
                'model' => $model
            ]);
        }        
    }


    /**
     * Updates an existing Integrante model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model
            ]);
        }
    }

    /**
     * Deletes an existing Integrante model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Integrante model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Integrante the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Integrante::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
