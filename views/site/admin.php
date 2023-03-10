<?php 

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\data\ActiveDataProvider;
use app\models\Site;
use app\models\LoginForm;
use app\models\User;

?>
<?php $form = ActiveForm::begin(); ?>


<a href='create'><h3>Добавить пользователя</h3></a>
<?php
        
        $searchModel=new LoginForm;
        $dataProvider = $searchModel->search(Yii::$app->request->get());
    
        $sp_role=['0'=>'Пользователь','1'=>'Администратор'];
        echo GridView::widget([
         'dataProvider' => $dataProvider,
         'filterModel' => $searchModel,
         'columns' => [
             ['class' => 'yii\grid\SerialColumn'],
            'usernamerus',
            [
                'attribute' => 'role',
                'format' => 'raw',               
                'value' => function ($data) {
                    $sp_role=['0'=>'Пользователь','1'=>'Администратор'];              
                    return  $sp_role[$data->role];
                },
                'filter' =>$sp_role,
            ],
           
             [
                 'attribute' => 'login',
                 'format' => 'raw',
                 'value' => function ($data) {
                     return $data->username;
                 },
             ], 
             
             ['class' => 'yii\grid\ActionColumn','template' => '{update} {delete}','headerOptions' => ['style' => 'width:8%'],
             'urlCreator' => function ($action, $model, $key, $index) {
                if ($action === 'update') {
                    $url ='lk?id='.$model->id;
                    return $url;
                }
                if ($action === 'delete') {
                    $url ='delete?id='.$model->id;
                    return $url;
                }
              }
            ]
            ],
        ]);  ?>
   <?php ActiveForm::end(); ?>