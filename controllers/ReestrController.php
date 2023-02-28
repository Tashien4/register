<?php

namespace app\controllers;

use Yii;
use app\models\Reestr;
use app\models\Fio;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ReestrController implements the CRUD actions for Reestr model.
 */
class ReestrController extends Controller
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
               //     'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Reestr models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Reestr::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionList()
    {
        if(isset($_GET['id_fio']))
        	$id_fio=$_GET['id_fio'];
	else $id_fio=0;
        $dataProvider = new ActiveDataProvider([
            'query' => Reestr::find(),
        ]);

        return $this->render('list', [
            'dataProvider' => $dataProvider,'id_fio'=>$id_fio
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

 //--------------------------------------
   public function actionCreate()
    {
        $model = new Reestr();
        $model->id_fio=$_GET['id_fio'];
        $fmodel=Fio::findOne($_GET['id_fio']);
        
        if(isset($_POST['save_reestr'])) {
                $model->attributes=$_POST['Reestr'];

		$date=explode('.',$_POST['Reestr']['date']);
		$dd=$date[2].'-'.$date[1].'-'.$date[0];
		$model->date=$dd;
 	        if($_POST['Reestr']['srok']!='')
			$ss=$_POST['Reestr']['srok'];
		else $ss=date("d.m.Y");
		$date=explode('.',$ss);
		$dd=$date[2].'-'.$date[1].'-'.$date[0];
		$model->srok=$dd;
 	        if($model->validate()) {
			$model->save();
			return $this->redirect(['/fio/update', 'id' => $model->id_fio,'rel'=>5]);	
		} else print_r($model->geteerors());

        }
        return $this->render('create', [
            'model' => $model,
            'fmodel' => $fmodel,
        ]);
    }
 //-----------------------------------------------
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        if(isset($_POST['save_reestr'])) {
                $model->attributes=$_POST['Reestr'];

		$date=explode('.',$_POST['Reestr']['date']);
		$dd=$date[2].'-'.$date[1].'-'.$date[0];
		$model->date=$dd;
 	
		$date=explode('.',$_POST['Reestr']['srok']);
		$dd=$date[2].'-'.$date[1].'-'.$date[0];
		$model->srok=$dd;
 	        if($model->validate()) {
			$model->save();
			return $this->redirect(['/fio/update', 'id' => $model->id_fio,'rel'=>5]);	
		} else print_r($model->geteerors());

        }
             return $this->render('update', [
            'model' => $model,
        ]);
    }

 //-------------------------
   public function actionDelete($id)
    {
        $model=$this->findModel($id);
	$id_fio=$model->id_fio;
	$model->delete();

        return $this->redirect(['/fio/update', 'id' => $id_fio,'rel'=>5]);	
    }
 //-----------------------------------------
    /**
     * Finds the Reestr model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Reestr the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Reestr::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
