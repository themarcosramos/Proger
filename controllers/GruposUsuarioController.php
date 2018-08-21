<?php

namespace app\controllers;

use Yii;
use app\models\GruposUsuario;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\search\GruposUsuarioSearch;
use yii\rbac\DbManager;
use app\models\AuthItem;
use app\models\AuthItemChild;
use app\models\Permissao;
use yii\helpers\ArrayHelper;

/**
 * GruposUsuarioController implements the CRUD actions for GruposUsuario model.
 */
class GruposUsuarioController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'update', 'create'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all GruposUsuario models.
     * @return mixed
     */
    public function actionIndex()
    {

        if(\Yii::$app->user->can('gerenciar-usuario')){

            $searchModel = new GruposUsuarioSearch();
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
     * Displays a single GruposUsuario model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {

        if(\Yii::$app->user->can('gerenciar-usuario')){

            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);

        }
        else{

            throw new \yii\web\ForbiddenHttpException('Você não está autorizado a realizar essa ação.');
        }

    }

    /**
     * Creates a new GruposUsuario model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        if(\Yii::$app->user->can('gerenciar-usuario')){

            $model = new GruposUsuario();

            $permissoes = AuthItem::find()->where(['type' => '2'])->all();
            
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['index']);
            } else {
                return $this->render('create', [
                    'model' => $model,
                    'authItems' => $permissoes,
                ]);
            }

        }
        else{

            throw new \yii\web\ForbiddenHttpException('Você não está autorizado a realizar essa ação.');
        }

    }

    /**
     * Updates an existing GruposUsuario model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {

        if(\Yii::$app->user->can('gerenciar-usuario')){

            $model = $this->findModel($id);

            $allPermissions = Permissao::findAll();

            if ($model->load(Yii::$app->request->post()) && $model->update()) {
                return $this->redirect(['view', 'id' => $model->name]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                    'allPermissions' => $allPermissions,
                ]);
            }

        }
        else{

            throw new \yii\web\ForbiddenHttpException('Você não está autorizado a realizar essa ação.');
        }
        
    }

    /**
     * Deletes an existing GruposUsuario model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        /*$this->findModel($id)->delete();

        return $this->redirect(['index']);*/
    }

    /**
     * Finds the GruposUsuario model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return GruposUsuario the loaded model
     * @throws NotFoundHttpException if the model cannot be found
    */
    protected function findModel($id)
    {

        if (($grupo = GruposUsuario::findOne($id)) !== null) {
            return $grupo;

        } else {

            throw new NotFoundHttpException('The requested page does not exist.');

        }
    }
}
