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


//-----------------------------------------------------------

}
