<?php

use yii\helpers\Html;
use yii\grid\GridView;

use yii\widgets\ActiveForm;
use yii\data\ActiveDataProvider;
 use app\models\Site;
 use app\models\Fio;
 use app\models\Bls;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Список';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fio-index">
   <div style="display:flex;    justify-content: space-between;"> <p>
        <?= Html::a('Создать', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <p><a href='ziplist' class="btn btn-success">Скачать архив</a></p>
    </div>
    <?php
          
       $dataProvider = $model->search(Yii::$app->request->queryParams);

echo 	 GridView::widget([
        'dataProvider' => $dataProvider,
	'filterModel' => $model,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'id',
           [ 'attribute' => 'fio',
                'format' => 'raw',
                'value' => function ($data) {
                   return $data->paspfio["fam"].' '.$data->paspfio["im"].' '.$data->paspfio["ot"];
                         
                },],
  		[ 'attribute' => 'rod',
                'format' => 'raw',
                'value' => function ($data) {
                   return $data->paspfio["rod"];
                         
                },],
         
        
              [ 'attribute' => 'tel',
                'format' => 'raw',
                'header'=>'Контакные данные',
                'value' => function ($data) {
                 return $data->paspfio["tel"].' '.$data->paspfio["email"];
                         
                },],
                [ 'attribute' => 'id_bls',
                'format' => 'raw',
		            'header'=>'Адрес',
                'value' => function ($data) {
                         if($data->id_bls==$data->id_bls_reg)
                   		return Fio::give_me_adr($data->id);
                   	else return Fio::give_me_adr($data->id).'<br><span style="font-size:12px">Временная регистрация</span><br>'.Fio::give_me_adr($data->id,1);	
                         
                },],

                [ 'attribute' => 'tab',
                'format' => 'raw',
                'value' => function ($data) {
                   return $data->rfio['fio'];
                         
                },],
 
            //'tab',

            ['class' => 'yii\grid\ActionColumn',
		'template' => '{update} {delete}',
		'headerOptions' => ['style' => 'width:6%'],
              
            
        ],
        ],
    ]); ?>
</div>
