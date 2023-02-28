<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Fio;
use app\models\Bls;
use yii\web\JsExpression;
use yii\jui\AutoComplete;

?>
<style>
.tab td {padding:0px 5px;}
.tab {background: linear-gradient(to bottom, #e0e9f7 , #fff1dc);}
</style>
<div class="family-form">

    <?php $form = ActiveForm::begin(); ?>
   <table class="tab"><tr><td style="width:50%">
    <?php  if($model->ch_id_fio>0) $model->fio=$model->find_fio($model->ch_id_fio);
	 echo $form->field($model, 'fio')->widget(
                        AutoComplete::className(), [            
                            'clientOptions' => [
                                'source' =>$mmodel->fio_auto(),
                                'autoFill'=>true,
                                'minLength'=>'4',
								'select' => new JsExpression("function( event, ui ) {
									$('#family-ch_id_fio').val(ui.item.id);
								}")],
                                'options' =>['style'=>'width:600px']
                                 ]);
                             ?>
    <?= Html::activeHiddenInput($model, 'ch_id_fio')?>
    </td><td>
    <?= $form->field($model, 'rel')->dropdownlist($model->list_relation()); ?></td>
   </tr>
    <tr><td>
    <?= $form->field($model, 'tel')->textInput(['maxlength' => true]) ?>
    </td><td><?= $form->field($model, 'accaunt')->textInput(['maxlength' => true]) ?></td></tr>
    <tr>
	<td><?php 	echo '<b>'.$model->getAttributeLabel('id_bls').'</b><br>';
			echo $mmodel->give_me_adr($mmodel->id);
			echo $form->field($model, 'adr')->widget(
                        		AutoComplete::className(), [            
                            			'clientOptions' => [
                                		'source' =>$mmodel->bls_auto(),
                                		'autoFill'=>true,

                                		'minLength'=>'4',
                                        'select' => new JsExpression("function( event, ui ) {
                                            $('#family-id_bls').val(ui.item.id);
                                        }")],
                                		'options' =>['style'=>'width:500px']
                                 	])->label('');         
			 ?> <?= Html::activeHiddenInput($model, 'id_bls')?>
   	</td><td>
    <?= $form->field($model, 'id_lgot')->dropdownlist($mmodel->find_lgot())?></td></tr>
     <tr ><td>
       <br><?= $form->field($model, 'work')->textArea(['maxlength' => true]) ?></td>
      <td>
     <?= $form->field($model, 'stady')->textArea(['maxlength' => true]) ?></td></tr>
 <tr><td colspan=2>
     <?= $form->field($model, 'prim')->textArea(['maxlength' => true]) ?></td></tr>
     
     </table>
    

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success','name'=>'fam_save']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
