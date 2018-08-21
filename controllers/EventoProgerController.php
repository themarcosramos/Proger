<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use app\models\EventoProger;
use app\models\search\EventoPorger;
use app\models\ProjetoProger;
use app\models\Pessoa;
use app\models\ResolucaoProger;
use app\models\IntegrantePessoa;
use app\models\Integrante;
use app\models\TipoProger;
use app\models\UsuarioGestor;
use app\models\MunicipiosAbrangidos;
use app\models\Financiamento;
use app\models\Relatorio;
use yii\helpers\FileHelper;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\bootstrap\Alert;

/**
 * EventoProgerController implements the CRUD actions for EventoProger model.
 */

$GLOBALS['tipoProger'] = TipoProger::find()->where(['nome'=>'Evento'])->one()->id;

class EventoProgerController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'detail-view', 'delete','cadastrar', 'update-resolucao', 'delete-resolucao','update-financiamento','delete-financiamento','update-relatorio','download-relatorio','delete-relatorio', 'create-pessoa', 'buscar-pessoa', 'update-integrante', 'delete-integrante','delete-municipio','view-integrante','view-financiamento'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    /**
     * Lists all EventoProger models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(\Yii::$app->user->can('gerenciamento-cadastros-avançados')){
            $searchModel = new EventoPorger();
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
     * Displays a single EventoProger model.
     * @param integer $id
     * @return mixed
     */
   
    /**
     * Displays a single EventoProger model.
     * @param integer $id
     * @return mixed
     */
   public function  actionView($novo=false){
    global $tipoProger;
      if(\Yii::$app->user->can('gerenciamento-cadastros-avançados')){        
       $post = Yii::$app->request->post();  
       $get = Yii::$app->request->get();
       $salto = 0;
       $idmodel = 0;
       $finalizado = 0; 

        if (isset($get['n']))
            $novo = $get['n'];
     
        if (isset($get['s']))
            $salto = $get['s'];  
      
        if (isset($get['idmodel']))
            $idmodel = $get['idmodel'];
         
        if($finalizado==1)                           
            return $this->redirect(['/evento-proger/index']);

         $modelEvento = new EventoProger();

        if($idmodel!=0)
        $modelEvento  = $this->findModel($idmodel);

        if($salto == 0){
            return $this->render('index', [ ]);
  
           }else if($salto==1){ 
              if(!isset($modelEvento->idGestor))
              $modelEvento->idGestor = UsuarioGestor::find()->where(['idUsuario'=>Yii::$app->user->getId()])->one()->idGestor;

                  $idmodel = $modelEvento->id;
                  return $this->render('view-p1', ['model' => $modelEvento ,'novo'=>$novo, 'nome'=> $modelEvento->nome]);

            }else if($salto==2){
                 $integrante = new Integrante();
                 $integrante->idProger = $idmodel;
                 $integrante->idTipoProger = $tipoProger;
                 $pessoa = new Pessoa();
                 $cpf = null;

                 return $this->render('view-p2', ['cpf'=>$cpf,'formType'=>0, 'updateIntegrante'=>0,'integrante'=>$integrante, 'pessoa'=>$pessoa, 'idmodel'=>$idmodel, 'novo'=>$novo, 'nome'=>  $modelEvento->nome]);   

            }else if($salto==3){
                $relatorio = new Relatorio();                                                      
                $relatorio->idProger = $idmodel;         
                $relatorio->idTipoProger = $tipoProger;  

                return $this->render('view-p3', 
                ['model' => $relatorio,
                'idmodel'=>$idmodel, 
                'novo' => $novo, 
                'nome'=> $modelEvento->nome]);

            }else if($salto==4){
                $financiamento = new Financiamento();    
                $financiamento->idTipoProger =$tipoProger; 
                $financiamento->idProger = $idmodel;   

                return $this->render ('view-p4',['model'=>$financiamento,'idmodel'=>$idmodel, 'novo' => $novo, 'nome'=> $modelEvento->nome]); 

            }else if($salto==5){
               
            $municipio = new MunicipiosAbrangidos();
            $municipio->idProger = $idmodel;
            $municipio->idTipoProger = $tipoProger;

            return $this->render('view-p5', [ 'municipio'=>$municipio,'idmodel'=>$idmodel, 'novo' => $novo, 'nome'=>$modelEvento->nome, 'tipoProger'=>$tipoProger]);
            
            }else{
                //render view do projeto se salto 0
               $searchModel = new ProjetoProgerSearch();
               $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
               return $this->render('index', [
                 'searchModel' => $searchModel,
                 'dataProvider' => $dataProvider,
             ]);

            }
    }   
   }

   public function actionViewIntegrante($id, $n){
    if(\Yii::$app->user->can('gerenciamento-cadastros-avançados')){ 
        //carrega o model pelo id          
        if (($model = Integrante::findOne($id)) == null) 
            throw new NotFoundHttpException('The requested page does not exist.');     
        $idmodel = $model->idProger;
        $modelEvento = $this->findModel($idmodel)->nome;
        $cpf = Pessoa::findOne($model->idPessoa)->cpf;
      
            return $this->render('view-p2', ['integrante' => $model, 'formType'=>0,'cpf'=>$cpf, 'updateIntegrante'=>1,'idmodel'=>$idmodel, 'novo' => $n, 'nome'=>$modelEvento,'op'=>1]);
    }
    else{
        throw new \yii\web\ForbiddenHttpException('Você não está autorizado a realizar essa ação.');
    }
}

public function actionViewFinanciamento($id, $n) {
    if(\Yii::$app->user->can('gerenciamento-cadastros-avançados')){ 
        //carrega o model pelo id          
        if (($model = Financiamento::findOne($id)) == null) 
            throw new NotFoundHttpException('The requested page does not exist.');     
        $idmodel = $model->idProger;
        $modelEvento = $this->findModel($idmodel)->nome;
        //quando terminar a edicao, salva e renderiza a tela novamente com os dados zerados
       // if ($model->load(Yii::$app->request->post()) && $model->save()) {
       //     return  $this->redirect(['cadastrar', 's' => 4, 'idmodel' => $idmodel, 'n' => $n, 'nome'=>$modelEvento]);
      //  } else {
        //renderiza a tela com os dados pre-carregados para edicao
            return $this->render('view-p4', ['model' => $model,'idmodel'=>$idmodel, 'novo' => $n, 'nome'=>$modelEvento]);
       // }
    }
    else{
        throw new \yii\web\ForbiddenHttpException('Você não está autorizado a realizar essa ação.');
    }
}




    /**
     * Deletes an existing EventoProger model.
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
     * Finds the EventoProger model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return EventoProger the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EventoProger::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionCadastrar($novo=false){
    
        global $tipoProger;
        if(\Yii::$app->user->can('gerenciamento-cadastros-avançados')){        
        $post = Yii::$app->request->post();  
        $get = Yii::$app->request->get();
        $salto = 0;
        $idmodel = 0;
        $finalizado = 0;
        //pega os paramatros passados por meio do get. quando passados
        //novo indica se é um projeto sendo atualizado(false, 0) ou criado (true, 1)
        if (isset($get['n']))
            $novo = $get['n'];
        //indica o estagio em que esta
        if (isset($get['s']))
            $salto = $get['s'];  
        //id do projeto que é repassado de estagio pra estágio
        if (isset($get['idmodel']))
            $idmodel = $get['idmodel'];
        //indica o fim processo de edição ou criação    
        if($finalizado==1)                           
            return $this->redirect(['/evento-proger/index']);

        $modelEvento = new EventoProger();

        if($idmodel!=0)
        $modelEvento  = $this->findModel($idmodel);
        //normalmente nao acontece, se acontecer é pq algo deu errado. Renderiza o index se salto nao for setado
        if($salto == 0){
          return $this->render('index', [ ]);

         }else if($salto==1){ 
            $admin =false;
            if(\Yii::$app->user->can('admin'))
                $admin = true;
            //atribuindo idGestor se for um novo cadastro
            if(!isset($modelEvento->idGestor))
            //pega o gestor do usuario logado
            $modelEvento->idGestor = UsuarioGestor::find()->where(['idUsuario'=>Yii::$app->user->getId()])->one()->idGestor;
             
            if ($modelEvento->load($post) && $modelEvento->validate()) {
                $modelEvento->save(); 
                $idmodel = $modelEvento->id;
                return $this->redirect(['cadastrar','s' => 1, 'idmodel' => $idmodel ,'novo'=>$novo, 'nome'=> $modelEvento->nome]);
            } else {
                return $this->render('cadastrar-p1',
                 ['model' =>  $modelEvento 
                 ,'novo'=>$novo,
                  'nome'=> $modelEvento->nome,
                  'admin'=>$admin]);
            }
         }else if($salto==2){
            $integrante = new Integrante();
            $integrante->idProger = $idmodel;
            $integrante->idTipoProger = $tipoProger;
            $pessoa = new Pessoa();
            $cpf = null;

            if($integrante->ativo == false){
                $integrante->ativo = 1;
            }  
            if ($integrante->load($post) && $integrante->validate()) {                
                $integrante->save();   
                //mesmo dando tudo certo nao passa pro proximo estagio, esta funcao só é feita pelo botao avancar dentro da view
                //renderiza a mesma view, mostra a gridview atualizada com o novo valor               
                return $this->redirect(['cadastrar','s' => 2,'idmodel' => $idmodel, 'n' => $novo, 'nome'=>  $modelEvento->nome]);
            }else{  
                //se foi a action create-pessoa deste controller que chamou cadastrar para o salto 2 ela deve passar tambem o cpf da pessoa 
                //se passou, atribui o valor pra renderizar o cadastrar-p2 com o campo cpf já preenchido, se nao renderiza vazio mesmo
                if (isset($get['cpf']))
                    $cpf = $get['cpf'];
                return $this->render('cadastrar-p2', ['cpf'=>$cpf,'formType'=>0, 'updateIntegrante'=>0,'integrante'=>$integrante, 'pessoa'=>$pessoa, 'idmodel'=>$idmodel, 'novo'=>$novo, 'nome'=>  $modelEvento->nome]);
            }   
        //relatorios
         }else if($salto==3){
            $relatorio = new Relatorio();            //Nesta linha ocorrerá a criação do objeto relatorio  que será usado para a                                             criação do relatorio  no sistema.
            $relatorio->idProger = $idmodel;         // será atribuído o model correspondente a relatorio  
            $relatorio->idTipoProger = $tipoProger;  // será atribuído o id correspondente ao tipoproger 

            // no if há seguir vai  ocorrer a verificação  se tem  dados enviados pelo formulário e são validos serão salvos
            if($relatorio->load($post) && $relatorio->validate()){
                $relatorio->file = UploadedFile::getInstance($relatorio,'file');
                if($relatorio->file){//verifica se tem arquivo e pega o nome e extensão
                    $relatorio->urlArquivo = $relatorio->file->baseName.'.'.$relatorio->file->extension;
                }
                $relatorio->save();
                return $this->redirect(['cadastrar','s' => 3,'idmodel' => $idmodel, 'n' => $novo,'nome'=> $modelEvento->nome]);       
                  // no else a seguir,que só ocorrera caso não tenha dados sendo enviados por formulário e/ou em caso de dados não validos, ocorrendo assim a rendelizada da tela de cadastro 5  
            }else{
                return $this->render('cadastrar-p3', ['model' => $relatorio,'idmodel'=>$idmodel, 'novo' => $novo, 'nome'=> $modelEvento->nome]);
            }

         }else if($salto==4){
            $financiamento = new Financiamento();     //Nesta linha ocorrerá a criação do objeto financiamento que será usado                                                 para a criação do financiamento no sistema.
            $financiamento->idTipoProger =$tipoProger; // será atribuído o id correspondente ao tipoproger 
            $financiamento->idProger = $idmodel;       // será atribuído o model correspondente a financiamento  

            // no if há seguir vai  ocorrer a verificação  se tem  dados enviados pelo formulário e sendo validos serão salvos
            if ($financiamento->load($post) && $financiamento->validate()) {
            // No if há seguir, vai verificar se os dados foram salvos no banco de dados, ocorrendo com sucesso será rendelizada a tela de cadastro 4 esperando que o usuário clicar no botão para ir para próxima tela 
                if($financiamento->save()){
                   return $this->redirect(['cadastrar', 's' => 4, 'idmodel' => $idmodel, 'n' => $novo, 'nome'=> $modelEvento->nome]);
                }
            // no else a seguir,que só ocorrera caso não tenha dados sendo enviados por formulário e/ou em caso de dados não validos, ocorrendo assim a rendelizada da tela de cadastro 4 
            }else{
                return $this->render ('cadastrar-p4',['model'=>$financiamento,'idmodel'=>$idmodel, 'novo' => $novo, 'nome'=> $modelEvento->nome]); 
            }  
         }else if($salto==5){ 

            $municipio = new MunicipiosAbrangidos();
            $municipio->idProger = $idmodel;
            $municipio->idTipoProger = $tipoProger;

            if($municipio->load($post) && $municipio->validate()){
                $municipio->save();     
                //permanece no estagio 5
                return $this->redirect(['cadastrar','s' => 5, 'idmodel' => $idmodel, 'n' => $novo,'nome'=> $modelEvento->nome]);
            }else {
                return $this->render('cadastrar-p5', [ 'municipio'=>$municipio,'idmodel'=>$idmodel, 'novo' => $novo, 'nome'=>$modelEvento->nome, 'tipoProger'=>$tipoProger]);
            }

         }else{
             //render view do projeto se salto 0
             $searchModel = new ProjetoProgerSearch();
             $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
             return $this->render('index', [
                 'searchModel' => $searchModel,
                 'dataProvider' => $dataProvider,
             ]);
        }

        }else{
            throw new \yii\web\ForbiddenHttpException('Você não está autorizado a realizar essa ação.');
        }

    }
     /**
     * Cria um novo model de Pessoa.
     * If creation is successful, the browser will be updated to the 'cadastrar-p2' with integrante form page.
     * @param integer $idmodel Project id
     * @param integer $n indicates that it is a new (true) record, or an update (false).
     * @return mixed
     */
    public function actionCreatePessoa($idmodel, $n){
        $integrante = new Integrante();
        $pessoa = new Pessoa();
        $modelEvento = $this->findModel($idmodel)->nome;
        if ($pessoa->load(Yii::$app->request->post()) && $pessoa->validate()) {      
            $pessoa->save();                  
            return $this->redirect(['cadastrar', 's' => 2, 'cpf'=>$pessoa->cpf, 'idmodel' => $idmodel, 'n' => $n, 'nome'=> $modelEvento]);
        } else{   
            return $this->render('cadastrar-p2', ['formType'=>1,'integrante'=>$integrante, 'pessoa'=>$pessoa, 
                'idmodel'=>$idmodel, 'novo'=>$n, 'nome'=> $modelEvento]);
        } 
    }
       /**
     * Deletes an existing Integrante model.
     * If deletion is successful, the browser will be updated to the 'cadastrar-p2' page.
     * @param integer $id
     * @param integer $n indicates that it is a new (true) record, or an update.
     * @return mixed
     */
    public function actionDeleteIntegrante($id, $n) {        
        $model = Integrante::findOne($id);
        $idmodel = $model->idProger;
       $modelEvento = $this->findModel($idmodel)->nome;
        //$model->delete();
        $model->ativo = false;
        return $this->redirect(['cadastrar', 's' => 2, 'idmodel' => $idmodel, 'n' => $n, 'nome'=> $modelEvento]);
    }
    
      /**
     * Updates an existing Integrante model.
     * If update is successful, the browser will be updated to the 'view' page.
     * @param integer $id
     * @param boolean $n indicates that it is a new (true) record, or an update.
     * @return mixed
     */
    public function actionUpdateIntegrante($id, $n){
        if(\Yii::$app->user->can('gerenciamento-cadastros-avançados')){ 
            //carrega o model pelo id          
            if (($model = Integrante::findOne($id)) == null) 
                throw new NotFoundHttpException('The requested page does not exist.');     
            $idmodel = $model->idProger;
           $modelEvento = $this->findModel($idmodel)->nome;
            $cpf = Pessoa::findOne($model->idPessoa)->cpf;

            //Se função não for Bolsista altera Curso para nulo
            if($model->idTipoFuncao !== 4){
                $model->idCurso = null;
            }

            //quando terminar a edicao, salva e renderiza a tela novamente com os dados zerados
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return  $this->redirect(['cadastrar', 's' => 2, 'idmodel' => $idmodel, 'n' => $n, 'nome'=>$modelEvento]);
            } else {
            //renderiza a tela com os dados pre-carregados para edicao
                return $this->render('cadastrar-p2', ['integrante' => $model, 'formType'=>0,'cpf'=>$cpf, 'updateIntegrante'=>1,'idmodel'=>$idmodel, 'novo' => $n, 'nome'=>$modelEvento]);
            }
        }
        else{
            throw new \yii\web\ForbiddenHttpException('Você não está autorizado a realizar essa ação.');
        }
    }
    
    /**
     * Updates an existing Financiamento model.
     * If update is successful, the browser will be updated to the 'view' page.
     * @param integer $id
     * @param boolean $n indicates that it is a new (true) record, or an update.
     * @return mixed
     */
    public function actionUpdateFinanciamento($id, $n) {
        if(\Yii::$app->user->can('gerenciamento-cadastros-avançados')){ 
            //carrega o model pelo id          
            if (($model = Financiamento::findOne($id)) == null) 
                throw new NotFoundHttpException('The requested page does not exist.');     
            $idmodel = $model->idProger;
            $modelEvento = $this->findModel($idmodel)->nome;
            //quando terminar a edicao, salva e renderiza a tela novamente com os dados zerados
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return  $this->redirect(['cadastrar', 's' => 4, 'idmodel' => $idmodel, 'n' => $n, 'nome'=>$modelEvento]);
            } else {
            //renderiza a tela com os dados pre-carregados para edicao
                return $this->render('cadastrar-p4', ['model' => $model,'idmodel'=>$idmodel, 'novo' => $n, 'nome'=>$modelEvento]);
            }
        }
        else{
            throw new \yii\web\ForbiddenHttpException('Você não está autorizado a realizar essa ação.');
        }
    }
      /**
     * Deletes an existing Financiamento model.
     * If deletion is successful, the browser will be updated to the 'cadastrar-p3' page.
     * @param integer $id
     * @param integer $n indicates that it is a new (true) record, or an update.
     * @return mixed
     */
    public function actionDeleteFinanciamento($id, $n) {
    if(\Yii::$app->user->can('gerenciamento-cadastros-avançados')){
        $model = Financiamento::findOne($id);
        $idmodel = $model->idProger;
        $modelEvento = $this->findModel($idmodel)->nome;
        $model->delete();
        return $this->redirect(['cadastrar', 's' => 4, 'idmodel' => $idmodel, 'n' => $n, 'nome'=>$modelEvento]);
    }else{
        throw new \yii\web\ForbiddenHttpException('Você não está autorizado a realizar essa ação.');
    }
    }
     /**
     * Downloads an existing arquivo.pdf associate with the id relatorio.
     * If update is successful, the browser starts download.
     * @param integer $url file url in the caminhosRelatorio (param)
     */
    public function actionDownloadRelatorio($filename, $idproger){
        global $tipoProger;
        if(\Yii::$app->user->can('gerenciamento-cadastros-avançados')){
            $storagePath = Yii::$app->params['caminhoRelatorio'];
            $folder = "$tipoProger$idproger";//pasta do projeto
            // check filename for allowed chars (do not allow ../ to avoid security issue: downloading arbitrary files)
            if (!is_file("$storagePath/$folder/$filename")) {
                throw new \yii\web\NotFoundHttpException('The file does not exists.');
            }
            //download
            return Yii::$app->response->sendFile("$storagePath/$folder/$filename", $filename);  
        }else {
            throw new \yii\web\ForbiddenHttpException('Você não está autorizado a realizar essa ação.');
        }
    }
    
    /**
     * Updates an existing Relatorio model.
     * If update is successful, the browser will be updated to the 'view' page.
     * @param integer $id
     * @param boolean $n indicates that it is a new (true) record, or an update.
     * @return mixed
     */
    public function actionUpdateRelatorio($id, $n) {
        global $tipoProger;
        
        if(\Yii::$app->user->can('gerenciamento-cadastros-avançados')){ 
            //carrega o model pelo id          
            if (($model = Relatorio::findOne($id)) == null) 
                throw new NotFoundHttpException('The requested page does not exist.');     
            $idmodel = $model->idProger;
            $modelEvento = $this->findModel($idmodel)->nome;
            //quando terminar a edicao, salva e renderiza a tela novamente com os dados zerados
            if($model->load(Yii::$app->request->post()) && $model->validate()){
                $model->file = UploadedFile::getInstance($model,'file');                
                $model->save();
                return  $this->redirect(['cadastrar', 's' => 3, 'idmodel' => $idmodel, 'n' => $n, 'nome'=>$modelEvento]);
            } else {
            //renderiza a tela com os dados pre-carregados para edicao
                return $this->render('cadastrar-p3', ['model' => $model,'idmodel'=>$idmodel, 'novo' => $n, 'nome'=>$modelEvento]);
            }
        }
        else{
            throw new \yii\web\ForbiddenHttpException('Você não está autorizado a realizar essa ação.');
        }
    }

     /**
     * Deletes an existing Relatorio model.
     * If deletion is successful, the browser will be updated to the 'cadastrar-p3' page.
     * @param integer $id
     * @param integer $n indicates that it is a new (true) record, or an update.
     * @return mixed
     */    
    public function actionDeleteRelatorio($id, $n) {
    if(\Yii::$app->user->can('gerenciamento-cadastros-avançados')){
        $model = Relatorio::findOne($id);
        $idmodel = $model->idProger;
        $modelEvento = $this->findModel($idmodel)->nome;
        $model->delete();
        return $this->redirect(['cadastrar', 's' => 3, 'idmodel' => $idmodel, 'n' => $n, 'nome'=>$modelEvento]);
    }else{
        throw new \yii\web\ForbiddenHttpException('Você não está autorizado a realizar essa ação.');
    }
    }

     /**
     * Updates an existing Resolucao model.
     * If update is successful, the browser will be updated to the 'view' page.
     * @param integer $id
     * @param boolean $n indicates that it is a new (true) record, or an update.
     * @return mixed
     */
    public function actionUpdateResolucao($id, $n){
        global $tipoProger;
        if(\Yii::$app->user->can('gerenciamento-cadastros-avançados')){ 
            //carrega o model pelo id          
            if (($resolucaoProger = ResolucaoProger::findOne($id)) == null) 
                throw new NotFoundHttpException('The requested page does not exist.');
            if (($model = Resolucao::findOne($resolucaoProger->idResolucao)) == null) 
                throw new NotFoundHttpException('The requested page does not exist.');
            $idmodel = $resolucaoProger->idProger;
            $modelEvento = $this->findModel($idmodel)->nome;
            //quando terminar a edicao, salva e renderiza a tela novamente com os dados zerados
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                $model = new Resolucao();
                return  $this->redirect(['cadastrar', 's' => 5, 'idmodel' => $idmodel, 'n' => $n, 'nome'=>$modelEvento]);
            } else {
            //renderiza a tela com os dados pre-carregados para edicao
                return $this->render('cadastrar-p5', ['model' => $model,'idmodel'=>$idmodel, 'novo' => $n, 'nome'=>$modelEvento, 'tipoProger'=>$tipoProger]);
            }
        }else{
            throw new \yii\web\ForbiddenHttpException('Você não está autorizado a realizar essa ação.');
        }
    }
    
    /**
     * Deletes an existing ResolucaoProger model.
     * If deletion is successful, the browser will be updated to the 'cadastrar-p3' page.
     * @param integer $id
     * @param integer $n indicates that it is a new (true) record, or an update.
     * @return mixed
     */
    public function actionDeleteResolucao($id, $n) { 
    if(\Yii::$app->user->can('gerenciamento-cadastros-avançados')){       
        $model = ResolucaoProger::findOne($id);
        $idmodel = $model->idProger;
        $modelEvento = $this->findModel($idmodel)->nome;
        $model->delete();
        return $this->redirect(['cadastrar', 's' => 5, 'idmodel' => $idmodel, 'n' => $n, 'nome'=>$modelEvento]);
    }else {
        throw new \yii\web\ForbiddenHttpException('Você não está autorizado a realizar essa ação.');
    }
    }
    
    /**
     * Deletes an existing MunicipiosAbrangidos model.
     * If deletion is successful, the browser will be updated to the 'cadastrar-p1' page.
     * @param integer $id
     * @param integer $n indicates that it is a new (true) record, or an update.
     * @return mixed
     */
    public function actionDeleteMunicipio($id, $n) {
        if(\Yii::$app->user->can('gerenciamento-cadastros-avançados')){
            $model = MunicipiosAbrangidos::findOne($id);
            $idmodel = $model->idProger;
            $modelEvento = $this->findModel($idmodel)->nome;
            $model->delete();
            return $this->redirect(['cadastrar', 's' => 5, 'idmodel' => $idmodel, 'n' => $n, 'nome'=>$modelEvento]);
        }else {
            throw new \yii\web\ForbiddenHttpException('Você não está autorizado a realizar essa ação.');
        }
    }
}