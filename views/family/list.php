<?php

use yii\helpers\Html;
use yii\helpers\Url;

use yii\widgets\ActiveForm;
use yii\grid\GridView;


use yii\data\ActiveDataProvider;
 use app\models\Site;
 use app\models\Family;
 use app\models\Fio;
?>
          
 <?php   $model=new Family;             
       $dataProvider = $model->search2(Yii::$app->request->queryParams);

    echo GridView::widget([
        'dataProvider' => $dataProvider,
         'filterModel' => $model,

        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

               [ 'attribute' => 'id_fio',
                'format' => 'raw',
                'value' => function ($data) {
                   return $data->paspfiomain["fam"].' '.$data->paspfiomain["im"].' '.$data->paspfiomain["ot"];
                         
                },],
  
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
               [ 'attribute' => 'rel',
                'format' => 'raw',
               
                'value' => function ($data) {
                   return Family::find_relation($data->rel);
                         
                },],
		'tel',
		'work',
      ['class' => 'yii\grid\ActionColumn','template' => '{update}{delete}',
                         'buttons'=>[
                'update' => function ($url,$model,$key) {
                            return Html::a('', '/family/update?id='.$model->id, ['class' => 'glyphicon glyphicon-pencil']);
                        },
                'delete' => function ($url,$model,$key) {
                            return Html::a('','/family/delete?id='.$model->id, ['class' => 'glyphicon glyphicon-trash']);
                },         
            ]                       


	    ],

        ],
    ]); ?>
