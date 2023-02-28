<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\AutoComplete;

/* @var $this yii\web\View */
/* @var $model app\models\Fio */
/* @var $form yii\widgets\ActiveForm */
?>


    <?php $form = ActiveForm::begin(); ?>



        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success','name'=>'save']) ?>

    <?php ActiveForm::end(); ?>


