<?php

namespace app\controllers;

use Yii;
use app\models\ProgramaProger;
use app\models\search\ProgramaProgerSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\UsuarioGestor;
use app\models\IntegrantePessoa;
use app\models\Integrante;
use app\models\Pessoa;
use app\models\Relatorio;
use app\models\Financiamento;
use app\models\ResolucaoProger;
use app\models\MunicipiosAbrangidos;
use app\models\TipoEncargo;
use yii\bootstrap\Modal;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use app\models\ProjetoProger;
use app\models\TipoProger;
use yii\db\Query;



/**
 * ProgramaProgerController implements the CRUD actions for ProgramaProger model.
 */

$GLOBALS['tipoProger'] = TipoProger::find()->where(['nome'=>'Programa'])->one()->id;

class ProgramaProgerController extends Controller
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
                        'actions' => ['index', 'view', 'detail-view', 'delete','cadastrar', 'update-resolucao', 'delete-resolucao','update-financiamento','delete-financiamento','update-relatorio','download-relatorio','delete-relatorio', 'create-pessoa', 'buscar-pessoa', 'update-integrante', 'delete-integrante','delete-municipio'],
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
     * Lists all ProgramaProger models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(\Yii::$app->user->can('gerenciamento-cadastros-avançados')){
            $searchModel = new ProgramaProgerSearch();
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
     * Displays a single ProgramaProger model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($idmodel, $s) {
        global $tipoProger;
        $nomePrograma = $this->findModel($idmodel)->nome;
        if(\Yii::$app->user->can('gerenciamento-cadastros-avançados')){
            switch ($s) {
                case 1:
                    $model = $this->findModel($idmodel);
                    break;
                case 2:
                    //$model = new ActiveDataProvider([
                    //    'query' => Integrante::find()->where(['idTipoProger'=>$tipoProger, 'idProger'=>$idmodel]),
                    //    'pagination' => ['pageSize' => 10],  
                    //]);
                    $model = Integrante::find()->where(['idTipoProger'=>$tipoProger, 'idProger'=>$idmodel])->all();
                    break;
                case 3:
                    $model = new ActiveDataProvider([
                        'query' => Relatorio::find()->where(['idTipoProger'=>$tipoProger, 'idProger'=>$idmodel]),
                        'pagination' => ['pageSize' => 10],  
                    ]);
                    break;
                case 4:
                    $model = new ActiveDataProvider([
                        'query' => Financiamento::find()->where(['idTipoProger'=>$tipoProger, 'idProger'=>$idmodel]),
                        'pagination' => ['pageSize' => 10],  
                    ]);
                    break;
                case 5:
                 //   $model1 = new ActiveDataProvider([
                 //       'query' => ResolucaoProger::find()->where(['idTipoProger'=>$tipoProger, 'idProger'=>$idmodel]),
                //        'pagination' => ['pageSize' => 10],  
                //    ]);
                    $model2 = new ActiveDataProvider([
                        'query' => MunicipiosAbrangidos::find()->where(['idTipoProger'=>$tipoProger, 'idProger'=>$idmodel]),
                        'pagination' => ['pageSize' => 10],  
                    ]);
                    return $this->render('view', [
                        'nomePrograma' =>  $nomePrograma,
                        'query1' => $query1,
                        'query2' => $query2,
                        'idmodel' => $idmodel,
                        'salto' => $s,
                    ]);
                    break;
                default:
                    $model = $this->findModel($idmodel);
                    break;
            }
            return $this->render('view', [
                'nomePrograma' => $nomePrograma,
                'model' => $model,
                'idmodel' => $idmodel,
                'salto' => $s,
            ]);
        } else {
            throw new \yii\web\ForbiddenHttpException('Você não está autorizado a realizar essa ação.');
        }
    }

    /**
     * Deletes an existing ProgramaProger model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
      //  $this->findModel($id)->delete();

    //    return $this->redirect(['index']);
  
        if(\Yii::$app->user->can('gerenciamento-cadastros-basicos')){
            
            //O objetivo do if abaixo é verificar se a chave do registro acionado está sendo utilizada e em caso positiva ao invés de deletar vai inativar o registro.

            $registroAcionado = $this->findModel($id);//Coloca o registro acionado pelo botão de lixeira em uma variável para poder manipular sem fazer find toda vez.
            $projeto = (new Query())->from('ProjetoProger')->where(['idPrograma' => $registroAcionado->id]);
            $curso = (new Query())->from('CursoProger')->where(['idTipoProger' => 1,'idProger' => $registroAcionado->id]);
            $evento = (new Query())->from('EventoProger')->where(['idTipoProger' => 1,'idProger' => $registroAcionado->id]);

            if($projeto ->exists() != null||
               $evento ->exists()!= null||
               $curso ->exists()!= null){//Verifica se existe associações ao registro atual
             
              
                $registroAcionado->idSituacao = 10;
                $registroAcionado->save();
            }
            else{
                $registroAcionado->delete();
            }


            return $this->redirect(['index']);
        }
        else{
            throw new \yii\web\ForbiddenHttpException('Você não está autorizado a realizar essa ação.');
        }
    }

    /**
     * Finds the ProgramaProger model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProgramaProger the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProgramaProger::findOne($id)) !== null) {
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
            return $this->redirect(['/programa-proger/index']);

        $modelPrograma = new ProgramaProger();

        if($idmodel!=0)
        $modelPrograma  = $this->findModel($idmodel);
        //normalmente nao acontece, se acontecer é pq algo deu errado. Renderiza o index se salto nao for setado
        if($salto == 0){
          return $this->render('index', [ ]);
         }
         if($salto == 1){
               //variavel $admin servirá pra habilitar ou nao a edicao de Gestor em cadastrar-p1   
            $admin =false;
            if(\Yii::$app->user->can('admin'))
                $admin = true;
            //atribuindo idGestor se for um novo cadastro
            if(!isset($modelPrograma->idGestor))
                //pega o gestor do usuario logado
                $modelPrograma->idGestor = UsuarioGestor::find()->where(['idUsuario'=>Yii::$app->user->getId()])->one()->idGestor;
                 //Se campo Situação estiver vazio, atribui valor um 1 referente a Ativo em tabela Situacao para cadastrar novo modelPrograma-
                 if($modelPrograma->idSituacao == false){
                    $modelPrograma->idSituacao = 1;
                }
            if ($modelPrograma->load($post) && $modelPrograma->validate()){
                $modelPrograma->save(); 
                $idmodel = $modelPrograma->id;
                return $this->redirect(['cadastrar','s' => 1, 'idmodel' => $idmodel, 'n' => $novo, 'nome'=> $modelPrograma->nome]);
            }else{
                return $this->render('cadastrar-p1', ['tipoProger'=>$tipoProger,'model' => $modelPrograma,'novo' => $novo, 'nome'=> $modelPrograma->nome, 'admin'=>$admin]);
         }  
       }else if($salto ==2){
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
            return $this->redirect(['cadastrar','s' => 2,'idmodel' => $idmodel, 'n' => $novo, 'nome'=>  $modelPrograma->nome]);
        }else{  
            //se foi a action create-pessoa deste controller que chamou cadastrar para o salto 2 ela deve passar tambem o cpf da pessoa 
            //se passou, atribui o valor pra renderizar o cadastrar-p2 com o campo cpf já preenchido, se nao renderiza vazio mesmo
            if (isset($get['cpf']))
                $cpf = $get['cpf'];
            return $this->render('cadastrar-p2', ['cpf'=>$cpf,'formType'=>0, 'updateIntegrante'=>0,'integrante'=>$integrante, 'pessoa'=>$pessoa, 'idmodel'=>$idmodel, 'novo'=>$novo, 'nome'=>  $modelPrograma->nome]);
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
            return $this->redirect(['cadastrar','s' => 3,'idmodel' => $idmodel, 'n' => $novo,'nome'=> $modelPrograma->nome]);       
              // no else a seguir,que só ocorrera caso não tenha dados sendo enviados por formulário e/ou em caso de dados não validos, ocorrendo assim a rendelizada da tela de cadastro 5  
        }else{
            return $this->render('cadastrar-p3', ['model' => $relatorio,'idmodel'=>$idmodel, 'novo' => $novo, 'nome'=> $modelPrograma->nome]);
        }

      }else if( $salto==4){
        $financiamento = new Financiamento();     //Nesta linha ocorrerá a criação do objeto financiamento que será usado                                                 para a criação do financiamento no sistema.
        $financiamento->idTipoProger =$tipoProger; // será atribuído o id correspondente ao tipoproger 
        $financiamento->idProger = $idmodel;       // será atribuído o model correspondente a financiamento  

        // no if há seguir vai  ocorrer a verificação  se tem  dados enviados pelo formulário e sendo validos serão salvos
        if ($financiamento->load($post) && $financiamento->validate()) {
        // No if há seguir, vai verificar se os dados foram salvos no banco de dados, ocorrendo com sucesso será rendelizada a tela de cadastro 4 esperando que o usuário clicar no botão para ir para próxima tela 
            if($financiamento->save()){
               return $this->redirect(['cadastrar', 's' => 4, 'idmodel' => $idmodel, 'n' => $novo, 'nome'=> $modelPrograma->nome]);
            }
        // no else a seguir,que só ocorrera caso não tenha dados sendo enviados por formulário e/ou em caso de dados não validos, ocorrendo assim a rendelizada da tela de cadastro 4 
        }else{
            return $this->render ('cadastrar-p4',['model'=>$financiamento,'idmodel'=>$idmodel, 'novo' => $novo, 'nome'=> $modelPrograma->nome]); 
      }
    }else if($salto==5){
       // $resolucaoProger = new ResolucaoProger();
            //já atribui e salva os dados de ResoluçãoProger por são todos ids e estao no alcance neste momento
       //     $resolucaoProger->idTipoProger = $tipoProger;
       //     $resolucaoProger->idProger = $idmodel;
            $municipio = new MunicipiosAbrangidos();
            $municipio->idProger = $idmodel;
            $municipio->idTipoProger = $tipoProger;

      //      if($resolucaoProger->load($post) && $resolucaoProger->validate()){
      //          $resolucaoProger->save();     
                //permanece no estagio 5
      //          return $this->redirect(['cadastrar','s' => 5, 'idmodel' => $idmodel, 'n' => $novo,'nome'=> $modelPrograma->nome]);
            if($municipio->load($post) && $municipio->validate()){
                $municipio->save();     
                //permanece no estagio 5
                return $this->redirect(['cadastrar','s' => 5, 'idmodel' => $idmodel, 'n' => $novo,'nome'=> $modelPrograma->nome]);
            }else {
                return $this->render('cadastrar-p5', ['municipio'=>$municipio,'idmodel'=>$idmodel, 'novo' => $novo, 'nome'=> $modelPrograma->nome, 'tipoProger'=>$tipoProger]);
            }

    }else{
        //render view do projeto se salto 0

        $searchModel = new ProgramaProgerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    }else {
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
        $modelPrograma = $this->findModel($idmodel)->nome;
        if ($pessoa->load(Yii::$app->request->post()) && $pessoa->validate()) {      
            $pessoa->save();                  
            return $this->redirect(['cadastrar', 's' => 2, 'cpf'=>$pessoa->cpf, 'idmodel' => $idmodel, 'n' => $n, 'nome'=> $modelPrograma]);
        } else{   
            return $this->render('cadastrar-p2', ['formType'=>1,'integrante'=>$integrante, 'pessoa'=>$pessoa, 
                'idmodel'=>$idmodel, 'novo'=>$n, 'nome'=> $modelPrograma]);
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
       $modelPrograma = $this->findModel($idmodel)->nome;
        //$model->delete();
        $model->ativo = false;
        return $this->redirect(['cadastrar', 's' => 2, 'idmodel' => $idmodel, 'n' => $n, 'nome'=> $modelPrograma]);
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
           $modelPrograma = $this->findModel($idmodel)->nome;
            $cpf = Pessoa::findOne($model->idPessoa)->cpf;

            //Se função não for Bolsista altera Curso para nulo
            if($model->idTipoFuncao !== 4){
                $model->idCurso = null;
            }

            //quando terminar a edicao, salva e renderiza a tela novamente com os dados zerados
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return  $this->redirect(['cadastrar', 's' => 2, 'idmodel' => $idmodel, 'n' => $n, 'nome'=>$modelPrograma]);
            } else {
            //renderiza a tela com os dados pre-carregados para edicao
                return $this->render('cadastrar-p2', ['integrante' => $model, 'formType'=>0,'cpf'=>$cpf, 'updateIntegrante'=>1,'idmodel'=>$idmodel, 'novo' => $n, 'nome'=>$modelPrograma]);
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
            $modelPrograma = $this->findModel($idmodel)->nome;
            //quando terminar a edicao, salva e renderiza a tela novamente com os dados zerados
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return  $this->redirect(['cadastrar', 's' => 4, 'idmodel' => $idmodel, 'n' => $n, 'nome'=>$modelPrograma]);
            } else {
            //renderiza a tela com os dados pre-carregados para edicao
                return $this->render('cadastrar-p4', ['model' => $model,'idmodel'=>$idmodel, 'novo' => $n, 'nome'=>$modelPrograma]);
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
        $modelPrograma = $this->findModel($idmodel)->nome;
        $model->delete();
        return $this->redirect(['cadastrar', 's' => 4, 'idmodel' => $idmodel, 'n' => $n, 'nome'=>$modelPrograma]);
    }else {
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
            $modelPrograma = $this->findModel($idmodel)->nome;
            //quando terminar a edicao, salva e renderiza a tela novamente com os dados zerados
            if($model->load(Yii::$app->request->post()) && $model->validate()){
                $model->file = UploadedFile::getInstance($model,'file');                
                $model->save();
                return  $this->redirect(['cadastrar', 's' => 3, 'idmodel' => $idmodel, 'n' => $n, 'nome'=>$modelPrograma]);
            } else {
            //renderiza a tela com os dados pre-carregados para edicao
                return $this->render('cadastrar-p3', ['model' => $model,'idmodel'=>$idmodel, 'novo' => $n, 'nome'=>$modelPrograma]);
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
        $modelPrograma = $this->findModel($idmodel)->nome;
        $model->delete();
        return $this->redirect(['cadastrar', 's' => 3, 'idmodel' => $idmodel, 'n' => $n, 'nome'=>$modelPrograma]);
    }else {
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
/*    public function actionUpdateResolucao($id, $n){
        global $tipoProger;
        if(\Yii::$app->user->can('gerenciamento-cadastros-avançados')){ 
            //carrega o model pelo id          
            if (($resolucaoProger = ResolucaoProger::findOne($id)) == null) 
                throw new NotFoundHttpException('The requested page does not exist.');
            if (($model = Resolucao::findOne($resolucaoProger->idResolucao)) == null) 
                throw new NotFoundHttpException('The requested page does not exist.');
            $idmodel = $resolucaoProger->idProger;
            $modelPrograma = $this->findModel($idmodel)->nome;
            //quando terminar a edicao, salva e renderiza a tela novamente com os dados zerados
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                $model = new Resolucao();
                return  $this->redirect(['cadastrar', 's' => 5, 'idmodel' => $idmodel, 'n' => $n, 'nome'=>$modelPrograma]);
            } else {
            //renderiza a tela com os dados pre-carregados para edicao
                return $this->render('cadastrar-p5', ['model' => $model,'idmodel'=>$idmodel, 'novo' => $n, 'nome'=>$modelPrograma, 'tipoProger'=>$tipoProger]);
            }
        }
        else{
            throw new \yii\web\ForbiddenHttpException('Você não está autorizado a realizar essa ação.');
        }
    }
*/
     /**
     * Deletes an existing ResolucaoProger model.
     * If deletion is successful, the browser will be updated to the 'cadastrar-p3' page.
     * @param integer $id
     * @param integer $n indicates that it is a new (true) record, or an update.
     * @return mixed
     */
 /*   public function actionDeleteResolucao($id, $n) {
    if(\Yii::$app->user->can('gerenciamento-cadastros-avançados')){       
        $model = ResolucaoProger::findOne($id);
        $idmodel = $model->idProger;
        $modelPrograma = $this->findModel($idmodel)->nome;
        $model->delete();
        return $this->redirect(['cadastrar', 's' => 5, 'idmodel' => $idmodel, 'n' => $n, 'nome'=>$modelPrograma]);
    }else {
        throw new \yii\web\ForbiddenHttpException('Você não está autorizado a realizar essa ação.');
    }
    
    }
*/
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
            $modelPrograma= $this->findModel($idmodel)->nome;
            $model->delete();
            return $this->redirect(['cadastrar', 's' => 5, 'idmodel' => $idmodel, 'n' => $n, 'nome'=>$modelEvento]);
        }else {
            throw new \yii\web\ForbiddenHttpException('Você não está autorizado a realizar essa ação.');
        }
    }

}