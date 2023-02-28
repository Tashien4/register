<?php

namespace app\controllers;

use Yii;
use app\models\Fio;
use app\models\Reestr;
use app\models\Bls;
use app\models\Paspfio;
use app\models\Family;
use app\models\Lgot;
use app\models\Finans;
use app\models\After;
use app\models\Rfio;
use app\models\Excel;

use yii\helpers\Url;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
/**
 * FioController implements the CRUD actions for Fio model.
 */
class FioController extends Controller
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
                ],
            ],
        ];
    }

//----------------------------
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Fio::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
//--------------------------------------
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
//------------------------
      public function actionList()
    {
        $model=new Fio;

        return $this->render('list', [
            'model' => $model,
        ]);
    }
//-----------------------------
public function actionRfio_create() {

$id_fio=$_GET['id_fio'];

        $model=new Rfio;
$fmodel=Fio::findOne($_GET['id_fio']);
$model->fio=$_GET['fio'];
$model->tel=$_GET['tel'];

	if(isset($_POST['save'])) {
		$fmodel->create_rfio($_POST['Rfio']['fio'],$_POST['Rfio']['otdel'],$_POST['Rfio']['tel'],$_POST['Rfio']['dolg'],$id_fio);
                return $this->redirect(['update', 'id' => $id_fio,'rel'=>5]);
	};
      return $this->render('_rfio', [
            'model' => $model,'fmodel' => $fmodel,'id_fio'=>$id_fio
        ]);
   		


}
//-----------------
    /**
     * Creates a new Fio model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Fio();
 
        if (isset($_POST['Fio']) or isset($_GET['post_id'])) {
            if(isset($_GET['post_id']))
                $_POST['Fio']['id']=$_GET['post_id'];

            if(isset($_POST['Fio']['id']) and $_POST['Fio']['id']>0)
            {
		        $model->id=$_POST['Fio']['id'];
                $fmodel=Paspfio::find()->where(['id'=>$model->id])->One();
                //изначально адрес проживания и регистрации совпадает
                $model->id_bls=$fmodel->id_bls;
                $model->id_bls_reg=$fmodel->id_bls;
                $model->tel=$fmodel->tel;

                //проверка на повтор
                $prov=Fio::findOne(['id'=>$model->id]);
                if(isset($prov)) 
                    return $this->redirect(['update', 'id' => $model->id]);

  	            if ($model->save()) {  

                    $amodel=new After;
                    $amodel->id_fio=$model->id;
                        if($amodel->validate())
			                $amodel->save();

		            $fmodel=new Finans;
                    $fmodel->id_fio=$model->id;
                        if($fmodel->validate())
			                $fmodel->save();

		            return $this->redirect(['update', 'id' => $model->id]);
                }
	            else print_r($model->geterrors());
            }
             else return $this->redirect(['create_people', 'fio' => $_POST['Fio']['fio']]);
    
 };
           return $this->render('create', [
            'model' => $model,
        ]);
    }
//-------------------------------------------------
public function actionCreate_people(){
    $model=new Paspfio;
    $fmodel = new Fio();
    if(isset($_POST['Paspfio'])) {
        $model->load(Yii::$app->request->post());
        $rod=explode('.',$_POST['Paspfio']['rod']);
		$rr=$rod[2].'-'.$rod[1].'-'.$rod[0];
		$model->rod=$rr;     
        if(isset($_POST['Paspfio']['id_bls']) and ($_POST['Paspfio']['id_bls']>0))
        $model->id_bls=$_POST['Paspfio']['id_bls'];
        else $model->id_bls=0;
    if($model->validate()) {
        $model->save();  
        return $this->redirect(['create', 'post_id' => $model->id]);
    }
    else print_r($model->geterrors());
}
    return $this->render('create_people', [
        'model' => $model,'fmodel' => $fmodel,
    ]);
}
//-------------------------------------
public function actionExcel() {

$id_fio=$_GET['id_fio'];
               return $this->render('excel',['id_fio'=>$id_fio]);

}
//-------------------------------------------------
public function actionZiplist() {
$models=Fio::find()->all();
$fileName ='output/all.zip';
//print_r($models);
$zip = new \ZipArchive();
$zip->open($fileName, \ZipArchive::CREATE);

foreach($models as $model) {
    $title=$model->find_for_excel($model->id);   
    Excel::fio_excel($model->id);
    Excel::reestr_excel($model->id);
    $zip->addFile('output/ФОРМА_'.$title.'_1.xlsx','ФОРМА_'.$title.'_1.xlsx' );
    $zip->addFile('output/ФОРМА_'.$title.'_2.xlsx','ФОРМА_'.$title.'_2.xlsx' );
}
$zip->close();

              return $this->render('zip_list');
}
//--------------------------------------------------


    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $pmodel=Paspfio::findOne(['id'=>$model->id]);
        $bmodel=Bls::findOne(['id'=>$pmodel->id_bls]);
        $finmodel=Finans::findOne(['id_fio'=>$model->id]);
        $afmodel=After::findOne(['id_fio'=>$model->id]);
        $rfiomodel=Rfio::findOne(['tab'=>$model->tab]);
        if(!isset($rfiomodel)) $rfiomodel=new Rfio;
        $old_tab=$model->tab;
        
         if(isset($_POST['save_otvet'])) {
             if(isset($_POST['Fio']['tab']) and $_POST['Fio']['tab']>0) {
             $tab=$_POST['Fio']['tab'];
	         $old_tab=$tab;
             $prov=$model->find_otvet($_POST['Fio']['tabs']);
            
	        if($prov==0 or $prov!=$tab)
	           return $this->redirect(['/fio/rfio_create', 'id_fio' => $model->id,'tel'=>$_POST['Rfio']['tel'],'fio'=>$_POST['Fio']['tabs']]);  
            else { 
                $model->order_tab($model->id,$tab,$_POST['Rfio']['tel']);
                return $this->redirect(['/fio/update', 'id' => $model->id,'rel'=>5]);  
               }; 
            };
        };   
	 if(isset($_POST['finans'])) {
                 $finmodel->attributes=$_POST['Finans'];
                 if($finmodel->validate()) {
			$finmodel->save();
                        //return $this->redirect(['update', 'id' => $model->id]);
		} else print_r($finmodel->geterrors());
		     return $this->redirect(['/fio/update', 'id' => $model->id,'rel'=>6]);   
        };

	 if(isset($_POST['save_after'])) {
                 $afmodel->attributes=$_POST['After'];
                 if($afmodel->validate()) {
			$afmodel->save();
                        //return $this->redirect(['update', 'id' => $model->id]);
		} else print_r($afmodel->geterrors());
		     return $this->redirect(['/fio/update', 'id' => $model->id,'rel'=>7]);   
        };

        if(isset($_POST['Fio']['family_status']) and $_POST['Fio']['family_status']>0) {
            $married=$_POST['Fio']['family_status'];
            $family=Family::findOne(['id_fio'=>$model->id,'ch_id_fio'=>$married]);

           if(!isset($family->id)) {
               $family=new Family;
               $family->id_fio=$model->id;
               $family->ch_id_fio=$married;
               $family->rel=($pmodel->pol==1)?2:3;
               $family->id_bls=$model->id_bls_reg;
               if($family->validate())
                   $family->save(); 
           };
       };    
        if(isset($_POST['save'])) {
		    $model->attributes=$_POST['Fio'];
            $pmodel->attributes=$_POST['Paspfio'];

            if($pmodel->validate()) 
                $pmodel->save();
            else print_r($pmodel->geterrors());

            if($model->validate()) {
			$model->save();
                return $this->redirect(['update', 'id' => $model->id]);
		} else print_r($model->geterrors());
    };
	if(isset($_POST['save_lgot'])) {
             $model->new_lg($model->id,$_POST['Fio']['lgtype']);

             for($i=1;$i<4;$i++) {
               $lmodel=Lgot::findOne(['id_fio'=>$model->id,'pp'=>$i]);
               if(isset($lmodel))
               	$lmodel->id_lgot=($_POST['Fio']['lgtype_'.$i]);
	       else {
                $lmodel=new Lgot;
               	$lmodel->id_lgot=($_POST['Fio']['lgtype_'.$i]);
                $lmodel->id_fio=$model->id;
                $lmodel->pp=$i;
		};	
               if($lmodel->validate()) {
			        $lmodel->save();
                        //return $this->redirect(['update', 'id' => $model->id]);
		} else print_r($lmodel->geterrors());

		};
                 return $this->redirect(['/fio/update', 'id' => $model->id,'rel'=>2]);
		
        };
    

        return $this->render('update', [
        'model' => $model,
		'pmodel' => $pmodel,
		'bmodel' => $bmodel,
		'finmodel' => $finmodel,
		'afmodel' => $afmodel, 'rfiomodel'=>$rfiomodel

        ]);
    }
//--------------------------------------------------
    public function actionDelete($id)
    {
        $family=Family::findAll(['id_fio'=>$id]);
	if(count((array)$family)>0)
		foreach($family as $fam)
			$fam->delete();


        $finans=Finans::findOne(['id_fio'=>$id]);
	if(isset($finans))$finans->delete();

        $this->findModel($id)->delete();

        return $this->redirect(['list']);
    }
 //-----------------------------------------------
    protected function findModel($id)
    {
        if (($model = Fio::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
//---------------------------------------------------
   //-----------------------------------------------------------
public function actionFind_ul() {
	$aret[]=array('id'=>0,'name'=>'-');
	
    if ($_GET['id_city']) {
		$parq=$_GET['id_city'];
        
    Yii::$app->response->format = Response::FORMAT_JSON;
  //  if (Yii::$app->request->isAjax) {
        $sql=sprintf("
			select t.id, name
			from sKLADR.sstreets t
            		where id_npunkt=%s
			order by t.kat;
        	",     $parq
		);
        $command=Yii::$app->db->createCommand($sql); 
		$prows = $command->queryAll();
        return ['success' => true, 'prows' => $prows];
   // }

  //  return ['oh no' => 'you are not allowed :('];
}

	}
//-----------------------------------------------------------

}
