<?php

namespace app\controllers;

use Yii;
use yii\rbac\DbManager;
use app\models\Usuario;
use app\models\Gestor;
use app\models\UsuarioGestor;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\search\UsuarioSearch;
use yii\web\Response;
use yii\helpers\ArrayHelper;

/**
 * UsuarioController implements the CRUD actions for Usuario model.
 */
class UsuarioController extends Controller
{

    private function randKey ($str='', $long=0){
        $key = null;
        $str = str_split($str);
        $start = 0;
        $limit = count($str)-1;
        for ($x=0; $x<$long; $x++){
            $key .= $str[rand($start, $limit)];
        }
        return $key;
    }

    public function behaviors()
    {
        return [
           'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'update', 'create', 'delete', 'redefinirsenha', 'minha-conta', 'resetpass', 'recoverpass','consulta-email'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'consulta-email' => ['POST'],
                ],
            ],
        ];
    }
    /** 
     * Author Marcos Ramos 
     * a função a seguir realizar uma busca 
     * no banco para verifica se o e-mail já
     * foi cadastrado anteriormente 
     */
    public function actionConsultaEmail(){
        $email = $_POST['email'];
        
        $resultado = Usuario::find()->where(['email' => $email])->one();
        
        if($resultado == true){ 
            return -1;
        }    
    }
    /**
     * Lists all Usuario models.
     * @return mixed
     */
    public function actionIndex()
    {

        if(\Yii::$app->user->can('gerenciar-usuario')){

            $searchModel = new UsuarioSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
               'searchModel' => $searchModel, 
               'dataProvider' => $dataProvider,
           ]);

        }
        else{

            throw new \yii\web\ForbiddenHttpException('Você não está autorizado a realizar essa ação.');
        }

    }

    /**
     * Displays a single Usuario model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $connection = \Yii::$app->db;        

        $sql = "SELECT g.nome from usuarioGestor ug 
        INNER JOIN gestor g ON ug.idGestor = g.id
        where idUsuario = ".$id;

        $command = $connection->createCommand($sql);
        $resultado = $command->queryAll();

        //var_dump($resultado);
        //die();

        if(\Yii::$app->user->can('gerenciar-usuario')){

            return $this->render('view', [
                'model' => $this->findModel($id),
                'gestores' =>$resultado,
            ]);

        }
        else{

            throw new \yii\web\ForbiddenHttpException('Você não está autorizado a realizar essa ação.');
        }

    }

    public function actionMinhaConta($id){
        if(\Yii::$app->user->id == $id){ //Verifica se o id passando como parâmetro corresponde ao usuário logado, evitando que o usuário possa alterar senha de outro
            $model = $this->findModel($id);
            $model->scenario = 'redefinirSenha'; 

            if(Yii::$app->request->isAjax){
                Yii::$app->response->format = Response::FORMAT_JSON;
                if ($model->load(Yii::$app->request->post()) && $model->save()) {
                    return 'Senha alterada com sucesso!';
                }else {
                    return 'Não foi possível alterar sua senha.';
                }
            }else { 
                return $this->render('minha-conta', ['model' => $model,]);
            }
        }else {
            throw new \yii\web\ForbiddenHttpException('Você não está autorizado a realizar essa ação.');
        }
    }

    /**
     * Creates a new Usuario model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        if(\Yii::$app->user->can('gerenciar-usuario')){

            $model = new Usuario();
            $gestores = Gestor::find()->all();            
            $model->scenario = 'cadastro';

            if($model->trocar_senha == null){
                $model->trocar_senha = 0;

            }

            if ($model->load(Yii::$app->request->post()) ) {

                $model->verification_code = $this->randKey("abcdefghijklmnopqrstuvxwyz0123456789", 8);
                $model->save();

                return $this->redirect(['index']);
                
            } else {
                return $this->render('create', [
                    'model' => $model,
                    'gestores' => $gestores,
                ]);
            }

        }
        else{

            throw new \yii\web\ForbiddenHttpException('Você não está autorizado a realizar essa ação.');
        }

    }

    /**
     * Updates an existing Usuario model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {

        if(\Yii::$app->user->can('gerenciar-usuario')){

            $model = $this->findModel($id);             
            $gestores = Gestor::find()->all(); 
            $model->scenario = 'update';
            $alerta = "Já existe usuário cadastrado com este e-mail";
            
          
            if ($model->load(Yii::$app->request->post()) && $model->validate() ) {
                
                $validaemail = Usuario::find()->where(['email' => $model->email])->one();

                if($validaemail == true and $validaemail->id != $model->id){
                    return $this->redirect(['update',
                          'model' => $model,'id' => $model->id, 'alerta' => $alerta
                          
                 ]);
                }
                
                $model->save();
                return $this->redirect(['index',]);
                
            } else {                
                return $this->render('update', [
                    'model' => $model,
                    'todosGestores' => $gestores,
                ]);
            }

        }
        else{

            throw new \yii\web\ForbiddenHttpException('Você não está autorizado a realizar essa ação.');
        }

    }

    /**
     * Deletes an existing Usuario model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {

        if(\Yii::$app->user->can('gerenciar-usuario')){

            //Realiza uma consulta SQL para verificar se o usuário a ser excluído já possui ações gravadas no sistema. 
            //Se existir, ele não pode ser excluído.
            $connection = \Yii::$app->db;

            $sql = "DECLARE @idUsuario INT
                    SET @idUsuario = ".$id."

                    IF(

                    SELECT idUsuario FROM MovimentoSemCotas
                    WHERE idUsuario = @idUsuario

                    ) > 0 OR

                    (
                        SELECT idUsuario FROM MovimentoSemCotas
                        WHERE idUsuario = @idUsuario
                    ) > 0 OR
                    (
                        SELECT idUsuario FROM Digitais
                        WHERE idUsuario = @idUsuario
                    ) > 0 OR

                    (
                        SELECT idUsuario FROM HistoricoRemanejamento
                        WHERE idUsuario = @idUsuario
                    ) > 0 OR
                    (
                        SELECT idUsuario FROM TabelaLog
                        WHERE idUsuario = @idUsuario
                    ) > 0

                        SELECT '1'
                    ELSE
                        SELECT '0'";

            $command = $connection->createCommand($sql);
            $resultado = $command->queryOne();

            if($resultado[''] == 1){
                \Yii::$app->getSession()->setFlash('erro', 'Não é possível excluir este usuário pois já existem registros do mesmo no banco de dados.');
                return $this->redirect(['index']);
            }

            else if($resultado[''] == 0){

                $this->findModel($id)->delete();
                return $this->redirect(['index']);

            }

        }
        else{

            throw new \yii\web\ForbiddenHttpException('Você não está autorizado a realizar essa ação.');
        }


    }

    //author Marcus Vinicius
    public function actionRedefinirsenha($id){

        if(\Yii::$app->user->can('gerenciar-usuario')){
            $model = $this->findModel($id);
            $model->scenario = 'redefinirSenha';

            if($model->senha == null){
                return $this->render('redefinirSenha', ['model' => $model,]);
            }

            else if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['index']);
            } else {
                return $this->render('redefinirSenha', ['model' => $model,]);
            }
        }else{
            throw new \yii\web\ForbiddenHttpException('Você não está autorizado a realizar essa ação.');
        }        
    }

    //author Jhone Darts
    public function actionRecoverpass($id)
    {

        if(\Yii::$app->user->can('gerenciar-usuario')){

            $model = $this->findModel($id);
            $model->scenario = 'recoverpass';

            if($model->senha == null){
                return $this->render('recoverpass', [
                    'model' => $model,
                ]);
            }

            else if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['index']);
            } else {
                return $this->render('recoverpass', [
                    'model' => $model,
                ]);
            }

        }
        else{

            throw new \yii\web\ForbiddenHttpException('Você não está autorizado a realizar essa ação.');
        }
    }
    //author Jhone Darts
    public function actionResetpass($id)
    {

        if(\Yii::$app->user->can('gerenciar-usuario')){

            $model = $this->findModel($id);
            $model->scenario = 'resetpass';
            
            if($model->senha == null){
                return $this->render('resetpass', [
                    'model' => $model,
                ]);
            }

            else if ($model->load(Yii::$app->request->post()) && $model->save()) {
                
                return $this->redirect(['index']);
            } else {
                return $this->render('resetpass', [
                    'model' => $model,
                ]);
            }

        }
        else{

            throw new \yii\web\ForbiddenHttpException('Você não está autorizado a realizar essa ação.');
        }
        
    }

    /**
     * Finds the Usuario model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Usuario the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $connection = \Yii::$app->db;
        if (($model = Usuario::findOne($id)) !== null) {
            $model->gestores = $connection->createCommand('SELECT idGestor FROM usuarioGestor where idUsuario = '.$model->idUsuario)->queryColumn();
           // var_dump($model->gestores);
            //die();            
            //$model->gestores = ArrayHelper::getColumn($model->gestores, 'idGestor');
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
