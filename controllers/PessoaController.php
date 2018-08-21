<?php

namespace app\controllers;

use Yii;
use app\models\Pessoa;
use app\models\search\PessoaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Integrante;
use yii\filters\AccessControl;
/**
 * PessoaController implements the CRUD actions for Pessoa model.
 */
class PessoaController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [

            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'valida-cpf' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Pessoa models.
     * @return mixed
     */
    public function actionIndex()
    {
    if(\Yii::$app->user->can('gerenciamento-cadastros-basicos')){
        $searchModel = new PessoaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }else {
        throw new \yii\web\ForbiddenHttpException('Você não está autorizado a realizar essa ação.');
    }
    }

    /**
     * Displays a single Pessoa model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
    if(\Yii::$app->user->can('gerenciamento-cadastros-basicos')){
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }else {
        throw new \yii\web\ForbiddenHttpException('Você não está autorizado a realizar essa ação.');
    }
    }

    /**
     * Creates a new Pessoa model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
    if(\Yii::$app->user->can('gerenciamento-cadastros-basicos')){
      $model = new Pessoa();
      $alerta = "Pessoa já cadastrada";
                
        
      if ($model->load(Yii::$app->request->post()) && $model->validate()) {

        $validacpf = Pessoa::find()->where(['cpf' => $model->cpf])->one();
        if($validacpf == true){
            return $this->redirect(['create',
                  'model' => $model, 'alerta' => $alerta
            ]);
        }else{

            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }
         
      }else{
        return $this->render('create', [
            'model' => $model, 
        ]);
      }
    }else {
        throw new \yii\web\ForbiddenHttpException('Você não está autorizado a realizar essa ação.');
    }
      
    }

    public function actionValidaCpf(){
        $cpf = $_POST['cpf'];
        
       $resultado = $validacpf = Pessoa::find()->where(['cpf' => $cpf])->one();
       if(isset($resultado)){
           return -1;
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
            $cpf == '99999999999' ||               
            ord($cpf[0])<48       ||
            ord($cpf[0])>57
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
            return true;        
       
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
     * Updates an existing Pessoa model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {    

    if(\Yii::$app->user->can('gerenciamento-cadastros-basicos')){                
        $model = $this->findModel($id);
        $alerta = "Pessoa já cadastrada";

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $validacpf = Pessoa::find()->where(['cpf' => $model->cpf])->one();
            if($validacpf == true and $validacpf->id != $model->id){
                return $this->redirect(['update',
                      'model' => $model, 'alerta' => $alerta, 'id' => $model->id
                ]);
            }else{
                $model->save();
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }else {
        throw new \yii\web\ForbiddenHttpException('Você não está autorizado a realizar essa ação.');
    }
       
    }   

    /**
     * Deletes an existing Pessoa model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    
    public function actionDelete($id)
    {
    if(\Yii::$app->user->can('gerenciamento-cadastros-basicos')){

        $integrantes = Integrante::find()->where(['idPessoa'=>$id])->all(); //Proucura por vinculo
        
        if ($integrantes == true){ //Se vinculo foi encontrado inativa

            for ($i =0; $i<count($integrantes);$i++) {
                $integrante = $integrantes[$i];
                $integrante->ativo =0;
                $integrante->save();
            }  
            return $this->redirect(['index']);            
            
        }else{
            
            $this->findModel($id)->delete(); //Deleta pessoa sem vinculo

            return $this->redirect(['index']);

        }
    }else {
        throw new \yii\web\ForbiddenHttpException('Você não está autorizado a realizar essa ação.');
    }
        
    }

    /**
     * Finds the Pessoa model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Pessoa the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Pessoa::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
