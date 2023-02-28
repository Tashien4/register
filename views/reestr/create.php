<?php

use yii\helpers\Html;
use app\models\Family;


$this->title = 'Создать орбащение';
$this->params['breadcrumbs'][] = ['label' => $fmodel->find_father($model->id_fio), 'url' => ['fio/update?id='.$model->id_fio]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reestr-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
