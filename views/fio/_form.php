<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\AutoComplete;

/* @var $this yii\web\View */
/* @var $model app\models\Fio */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="fio-form">

    <?php $form = ActiveForm::begin(); ?>
<table>  
     <tr>
	<td><?php echo $model->getAttributeLabel('id_fio');?></td>
		<td><?php  echo $pmodel->fam.' '.$pmodel->im.' '.$pmodel->ot.' ('.$pmodel->rod.') ';?></td>
	</tr>
	<tr>
	<td><td><?php echo $model->id_bls->label?></td>
		<td><?php  echo $piar->adr;
		/*	echo '<br>'.$form->field($model, 'id_bls')->widget(
                        AutoComplete::className(), [            
                            'clientOptions' => [
                                'source' =>$model->bls_auto(),
                                'autoFill'=>true,

                                'minLength'=>'2'],
                                'options' =>['style'=>'width:500px']
                                 ])->label('');     */
                                          
			    ?>

?></td>
	</td>



    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success','name'=>'save']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
