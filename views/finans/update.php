<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Finans */
/*
$this->title = 'Update Finans: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Finans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';                          */
?>
 <div class="finans-update">


    <?=
             

$this->render('_form', [
        'finmodel' => $finmodel,'form'=>$form
    ]) ?>

  </div>