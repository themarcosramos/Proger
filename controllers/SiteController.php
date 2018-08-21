<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\rbac\DbManeger;
use yii\web\Session;
use app\models\FormRecoverPass;
use app\models\FormResetPass;
use app\models\Usuario;

class SiteController extends Controller
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

    public function actionRecoverpass()
 {
  
  //Instancia para validar el formulario
  $model = new FormRecoverPass;
  
  //Mensaje que será mostrado al usuario en la vista
  $msg = null;
  
  if ($model->load(Yii::$app->request->post()))
  {
   if ($model->validate())
   {
    //Buscar al usuario a través del email
    $table = Usuario::find()->where("email=:email", [":email" => $model->email]);
    //Si el usuario existe
    if (count($table) == 1)
    {
      //También almacenaremos el id del usuario en una variable de sesión
     //El id del usuario es requerido para generar la consulta a la tabla users y 
     //restablecer el password del usuario
      $table = Usuario::find()->where("email=:email", [":email" => $model->email])->one();
     $table->scenario = 'recoverpass';
     
     //Esta variable contiene un número hexadecimal que será enviado en el correo al usuario 
     //para que lo introduzca en un campo del formulario de reseteado
     //Es guardada en el registro correspondiente de la tabla users
     $verification_code = $this->randKey("abcdefghijklmnopqrstuvxwyz0123456789", 8);
     //Columna verification_code
     $table->verification_code = $verification_code;
     $table->trocar_senha = 1;
     //Guardamos los cambios en la tabla users
     $table->save();
     
     //Criação de texto para email
      $subject = "Recuperar Senha - Proger UEFS";
      $body = "<p>Redefinir sua senha?</p>";
      $body.= "<p>Se você solicitou uma redefinição de senha, clique no link abaixo.</p>"; 
      $body.=  "<p>Se você não fez essa solicitação, ignore este e-mail...</p>";
      $body.=  "<p><strong> Não compartilhe esse link com nínguem!!</strong></p> ";           
      $body .= "<p><a href='".Yii::$app->params["enderecoSistema"]."index.php?r=site/resetpass&cod=".$verification_code."&email=".$model->email."'>Recuperar Senha</a></p>";

     //Enviamos el correo
     Yii::$app->mailer->compose()
     ->setTo($model->email)
     ->setFrom([Yii::$app->params["adminEmail"] => Yii::$app->params["title"]])
     ->setSubject($subject)
     ->setHtmlBody($body)
     ->send();
     
     //Vaciar el campo del formulario
     $model->email = null;
     
     //Mostrar el mensaje al usuario
     $msg = "Foi enviado uma mensagem para sua conta de email para que possa redefinir sua senha";
    }
    else //El usuario no existe
    {
     $msg = "Email não consta no banco de dados!";
    }
   }
   else
   {
    $model->getErrors();
   }
  }
  return $this->render("recoverpass", ["model" => $model, "msg" => $msg]);
 }

 
 public function actionResetpass()
 {
    
  //Instancia para validar el formulario
  $model = new FormResetPass;

  $request = Yii::$app->request;
  $get = $request->get();
  $cod = $request->get('cod');
  $email = $request->get('email');     

  //Mensaje que será mostrado al usuario
  $msg = null;

  //Si el formulario es enviado para resetear el password
  if ($model->load(Yii::$app->request->post()))  {
    if ($model->validate())   {
      //Pesquisa se existe o usuário passado como parametro no link enviado para o email do usuário
      $table = Usuario::findOne(["email" => $email]);

      if(!$table || $table['verification_code']!=$cod || $table['email']!=$email || $table['trocar_senha']==0)
              throw new \yii\web\ForbiddenHttpException('Você não está autorizado a realizar essa ação.');

       //Encriptar el password
       $table->senha = $model->password;
       $table->trocar_senha = 0; 
       
       $table->scenario = 'resetpass';
       //Si la actualización se lleva a cabo correctamente
       if ($table->save())
       {
        
        //Vaciar los campos del formulario
        $model->password = null;
        $model->password_repeat = null;
        $model->recover = null;
        $model->verification_code = null;
        
        $msg = "Parabéns, senha resetada corretamente, redirecionando a página de login ...";
        $msg .= "<meta http-equiv='refresh' content='5; ".Url::toRoute("site/login")."'>";
       }
       else
       {
        $msg = "Ocorreu um erro!";
       }
     
    }
    else
    {
     $model->getErrors();
    }
   
  }
  
  return $this->render("resetpass", ["model" => $model, "msg" => $msg]);
  
 }
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),                
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],                    
                    
                ],
                
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */

  

   
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionArea($id){
        $rows = \app\models\AreaAtuacao::find()->where(['idGrandeArea' => $id, 'ativo' => 1])->all();
 
        if(count($rows)>0){
            echo "<option>Selecione uma área</option>";
            foreach($rows as $row){
                echo "<option value='$row->id'>$row->nome</option>";
            }
        }
        else{
            echo "<option></option>";
        } 
    }

    public function actionSubarea($id){
        $rows = \app\models\SubArea::find()->where(['idAreaAtuacao' => $id, 'ativo' => 1])->all();
 
        if(count($rows)>0){
            echo "<option>Selecione uma subárea</option>";
            foreach($rows as $row){
                echo "<option value='$row->id'>$row->nome</option>";
            }
        }
        else{
            echo "<option></option>";
        } 
    }

    public function actionEspecialidade($id){
        $rows = \app\models\Especialidade::find()->where(['idSubArea' => $id, 'ativo' => 1])->all();
 
        if(count($rows)>0){
            echo "<option></option>";
            foreach($rows as $row){
                echo "<option value='$row->id'>$row->nome</option>";
            }
        }
        else{
            echo "<option></option>";
        } 
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        //return $this->render('index');

        return $this->render('index');

        if(!Yii::$app->user->isGuest){
            return $this->render('index');
        }
        else{
            return $this->goBack();
        }




    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        /*if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);

    */

        
      
        if (!\Yii::$app->user->isGuest) {
            //return $this->goHome();
            return $this->render('index');
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {  

            return $this->render('index');
            
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
        
    


    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

}
