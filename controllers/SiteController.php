<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Users;
use app\models\User;

use app\models\_uparams;
use yii\web\Session;

class SiteController extends Controller
{
 
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
        //        'only' => ['update','index'],
                'rules' => [
		[
                     'actions' => ['index','login'],
                     'allow' => true,
                 	],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
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

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->redirect('/fio/list');
    }
    /**
     * username action.
     *
     * @return Response|string
     */
    //--------------------------------------------------------
    //-----------------------------------------------------------
    //------------------------------------------------
    public function actionDelete($id)
    {
        _uparams::find()->where(['id_user'=>$id])->one()->delete();

        User::findOne($id)->delete();

        return $this->redirect(['login']);
    }
//-----------------------------------------------------------
    public function actionLogin()
    {
      
        $model = new User();

        if(isset($_POST['User'])) {
            $name=$_POST['User']['login'];
            $model=User::find()->where(['id'=>$name])->one();    // ,'ingroup'=>$org
  
            $model->login=$model->username;
            if ($model->load(Yii::$app->request->post()) && $model->login()) {
                 return $this->redirect(['/fio/list']);
            }    else print_r($model->geterrors());
           
        }
            return $this->render('login', [
                'model' => $model
            ]);
    }
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        /*if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }*/
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

public function actionCreate(){
    $model=new LoginForm;
    if(isset($_POST['User']))
    { 
        $model->attributes=$_POST['User'];
        
        $model->password=sha1(md5($model->username).md5($model->password));
 //       print_r($model->attributes);

    /*    $sql='insert into users (usernamerus,username,password) 
                    values("'.$model->usernamerus.'","'.$model->username.'","'.$model->password.'");';
        $command=Yii::$app->db->createCommand($sql)->execute();
        
        */
        if($model->validate()) {
        $model->save();
 
        return $this->redirect(['admin']);
    }
        else print_r($model->geterrors());


     }
     return $this->render('lk',array('model'=>$model));
}
//-----------------------------------------------------------
public function actionLk(){
    if(isset($_GET['id'])) $id=$_GET['id'];
    else $id=Yii::$app->user->id;
    $my_id=Yii::$app->user->id;
if($id==0) 
    return $this->redirect(['create']);

    $model=User::find()->where(['id'=>$id])->One();
    $my_mod=User::find()->where(['id'=>$my_id])->One();
    $role=$my_mod->role;
    if(isset($_POST['User']))
    {   
           $pass_old=$model->password;
           $model->attributes=$_POST['User'];
           //чтобы не проходить проверку пароля-сохранение через базу
            $sql='update users set usernamerus="'.$_POST['User']['usernamerus'].'",
                role='.$_POST['User']['role'].' where id='.$id;
            $command=Yii::$app->db->createCommand($sql)->execute();

            if($model->password!=$pass_old){
            $sql='update users set password="'.sha1(md5($model->username).md5($model->password)).'" where id='.$id;
            $command=Yii::$app->db->createCommand($sql)->execute();
            };
    };

    return $this->render('lk',array('model'=>$model,'role'=>$role));
}
//--------------------------------------------------
public function actionAdmin()
	{    
        
		$model=LoginForm::find()->where(['id'=>Yii::$app->user->id])->one();
        
     
		return $this->render('admin',array('model'=>$model));
	}
}
