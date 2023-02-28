<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\models\Reestr */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="reestr-form">

    <?php $form = ActiveForm::begin(); ?>


    <?php    if($model->date==0) 
		$model->date=date("d.m.Y"); 
 			echo $form->field($model, 'date')->widget(DatePicker::className(),[
  				  
					'dateFormat' => 'php:d.m.Y',
			
    					'language' => 'ru',
					'options'=>['autocomplete'=>'off','placeholder'=>'дд.мм.гггг'],
   					 'clientOptions' => [
      				  	'format' => 'dd.mm.yyyy',
       				 	'autoclose'=>true,
       				 	'weekStart'=>1, 
    					]
				]);?>
        <?php 		echo $form->field($model, 'srok')->widget(DatePicker::className(),[
  				  
					'dateFormat' => 'php:d.m.Y',
			
    					'language' => 'ru',
					'options'=>['autocomplete'=>'off','placeholder'=>'дд.мм.гггг'],
   					 'clientOptions' => [
      				  	'format' => 'dd.mm.yyyy',
       				 	'autoclose'=>true,
       				 	'weekStart'=>1, 
    					]
				]); ?>
<table style="width:100%">
	<tr>
		<td colspan=3>
    	<?= $form->field($model, 'theme')->dropdownlist($model->list_theme()) ?>
		</td>
	</tr>
    <tr>
		<td style="padding: 10px;"><?= $form->field($model, 'status')->dropdownlist($model->list_status()) ?></td>
		<td style="padding: 10px;"><?= $form->field($model, 'poluch')->dropdownlist($model->list_poluch()) ?></td>
    	<td style="padding: 10px;"><?= $form->field($model, 'vypl')->dropdownlist(['0'=>'','1'=>'однократное','2'=>'длящееся']) ?></td>
	</tr>
	<tr>
		<td colspan=3><?= $form->field($model, 'nom')->textInput() ?></td>
	</tr>
	<tr>
		<td colspan=3><?= $form->field($model, 'zag')->textarea() ?></td>
	</tr>
	<tr>
		<td colspan=3><?= $form->field($model, 'prim')->textarea() ?></td>
	</tr>
	<tr>
		<td colspan=3><?= $form->field($model, 'otvet')->textarea() ?></td>
	</tr>
</table>





    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success','name'=>'save_reestr']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
