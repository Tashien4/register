<?php

use yii\helpers\Html;
use yii\helpers\Url;

use yii\widgets\ActiveForm;
use yii\grid\GridView;


use yii\data\ActiveDataProvider;
 use app\models\Site;
 use app\models\Family;
 use app\models\Fio;

/* @var $this yii\web\View */
/* @var $model app\models\Fio */
/* @var $form yii\widgets\ActiveForm */
?>



    <?php $form = ActiveForm::begin(); ?>
        <a href="<?php echo Url::to(['family/create?id_fio='.$main_m->id]);?>" class="btn btn-success">Добавить</a>
 <?php   $model=new Family;             
       $dataProvider = $model->search(Yii::$app->request->queryParams,$main_m->id);

echo 	 GridView::widget([
        'dataProvider' => $dataProvider,
	'filterModel' => $model,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'id',
           [ 'attribute' => 'ch_id_fio',
                'format' => 'raw',
                'value' => function ($data) {
                   return $data->paspfio["fam"].' '.$data->paspfio["im"].' '.$data->paspfio["ot"];
                         
                },],
  		[ 'attribute' => 'rod',
                'format' => 'raw',
                'value' => function ($data) {
                   return $data->paspfio["rod"];
                         
                },],
         
           // 'rel',
          //  'id_bls_reg',
               [ 'attribute' => 'rel',
                'format' => 'raw',
               
                'value' => function ($data) {
                   return Family::find_relation($data->rel);
                         
                },],
		'tel',
                [ 'attribute' => 'contact',
                	'format' => 'raw',
               
                	'value' => function ($data) {
                  		 return $data->contact>0?'Контакное лицо':'';
                         
                },],
	

                ['class' => 'yii\grid\ActionColumn',
		'template' => '{update} {delete}',
		'headerOptions' => ['style' => 'width:6%'],
              
            
        ],
        ],
    ]); ?>


    <?php ActiveForm::end(); ?>


