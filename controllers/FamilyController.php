<?php

namespace app\controllers;

use Yii;
use app\models\Family;
use app\models\Fio;

use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FamilyController implements the CRUD actions for Family model.
 */
class FamilyController extends Controller
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
                //    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Family models.
     * @return mixed
     */
//-------------------------------------
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Family::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
//-------------------------------------------
//-------------------------------------
    public function actionList()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Family::find(),
        ]);

        return $this->render('list', [
            'dataProvider' => $dataProvider,
        ]);
    }
//------------------------------------------------
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
//-----------------------------------
    public function actionCreate()
    {
        $model = new Family();
        $model->id_fio=$_GET['id_fio'];
        $mmodel=Fio::findOne(['id'=>$model->id_fio]);
	if($mmodel->id_bls_reg>0) $model->id_bls=$mmodel->id_bls_reg;
	elseif($mmodel->id_bls>0) $model->id_bls=$mmodel->id_bls;
	else $model->id_bls=0; 
        if(isset($_POST['fam_save'])){
                $model->attributes=$_POST['Family'];

        	if(isset($_POST['Family']['fio']) 
		   and $_POST['Family']['fio']!='' 
		   and stristr($_POST['Family']['fio'],'-')==true){

			$fio=explode('-',$_POST['Family']['fio']);
                	$model->ch_id_fio=$fio[0];
		}

     		if(isset($_POST['Family']['adr']) and $_POST['Family']['adr']!=''){
			$adr=explode('|',$_POST['Family']['adr']);
                	$model->id_bls=$adr[0];
		}
		if($model->validate()) {
			$model->save();
                        return $this->redirect(['/fio/update', 'id' => $model->id_fio,'rel'=>4]);
		} else print_r($model->geterrors());
	} 	
        return $this->render('create', [
            'model' => $model,
            'mmodel' => $mmodel,
        ]);
    }
//-------------------------------------------------------------
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $mmodel=Fio::findOne(['id'=>$model->id_fio]);
        
	if($model->id_bls==0) $model->id_bls=($mmodel->id_bls_reg>0?$mmodel->id_bls_reg:$mmodel->id_bls);
//	elseif($mmodel->id_bls>0) $model->id_bls=$mmodel->id_bls;
	  
        if(isset($_POST['fam_save'])){
                $model->attributes=$_POST['Family'];

        	if(isset($_POST['Family']['fio']) and $_POST['Family']['fio']!='' and stristr($_POST['Family']['fio'],'-')==true){
			$fio=explode('-',$_POST['Family']['fio']);
                	$model->ch_id_fio=$fio[0];
		}

     		if(isset($_POST['Family']['adr']) and $_POST['Family']['adr']!='' and stristr($_POST['Family']['adr'],'|')==true){
			$adr=explode('|',$_POST['Family']['adr']);
                	$model->id_bls=$adr[0];
		}
		if($model->validate()) {
			$model->save();
                        return $this->redirect(['/fio/update', 'id' => $model->id_fio,'rel'=>4]);
		} else print_r($model->geterrors());
	} 	

            return $this->render('update', [
            'model' => $model, 
            'mmodel' => $mmodel,
        ]);
    }

    /**
     * Deletes an existing Family model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
         $model=$this->findModel($id);
	$id_fio=$model->id_fio;
	$model->delete();

        return $this->redirect(['/fio/update', 'id' => $id_fio,'rel'=>4]);	
}

    /**
     * Finds the Family model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Family the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Family::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
