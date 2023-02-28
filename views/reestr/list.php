<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use app\models\Reestr;
?>
<div class="reestr-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if($id_fio>0) echo  Html::a('Добавить обращение', ['/reestr/create?id_fio='.$id_fio], ['class' => 'btn btn-success']) ?>
    </p>

    <?php
         $model=new Reestr;
       /*  if(isset($id_fio) and $id_fio>0)
		$model->id_fio=$id_fio;  */
         $dataProvider=$model->search(Yii::$app->request->queryParams,$id_fio);
 echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'=>$model,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            ['attribute'=>'nom',
              'format' => 'raw','header'=>'Номер',
               'contentOptions'=>['style'=>'width:5%;'] 
	    ],
            'date', 'srok',
            
              [ 'attribute' => 'theme',
                'format' => 'raw',
                'header'=>'Тема',
                'value' => function ($data) {
                   return Reestr::find_theme($data->theme);
                         
                },],
              'zag'
             ,
            [ 'attribute' => 'status', 'header'=>'Статус',
                'format' => 'raw',
               
                'value' => function ($data) {
                   return Reestr::find_status($data->status);
                         
                },
                'filter'=>Reestr::list_status(),'contentOptions'=>['style'=>'width:15%;'] 
		],
      

            //'vypl',
            //'tab',
            
            ['attribute'=>'prim',
              'format' => 'raw', 'header'=>'Решение',
               'contentOptions'=>['style'=>'width:15%;'] 
	    ],
         
            

            
            ['class' => 'yii\grid\ActionColumn',
		'template' => '{update} {delete}',
		'headerOptions' => ['style' => 'width:6%'],
                'buttons'=>[
                'update' => function ($url,$model,$key) {
                            return Html::a('', '/reestr/update?id='.$model->id, ['class' => 'glyphicon glyphicon-pencil']);
                        },
                'delete' => function ($url,$model,$key) {
                            return Html::a('','/reestr/delete?id='.$model->id, ['class' => 'glyphicon glyphicon-trash']);
                },         
            ]                       


            
        ],

        ],
    ]); ?>
</div>
