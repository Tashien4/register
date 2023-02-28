<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use yii\jui\AutoComplete;
use yii\web\JsExpression;
?>
<div class="fio-create_people">

    <?php $form = ActiveForm::begin(); ?>
<?php $fio=explode(' ',$_GET['fio']);
if(isset($fio[0])) $model->fam=mb_strtoupper(substr($fio[0],0,2)).substr($fio[0],2);

if(isset($fio[1])) $model->im=mb_strtoupper(substr($fio[1],0,2)).substr($fio[1],2);;
if(isset($fio[2])) $model->ot=mb_strtoupper(substr($fio[2],0,2)).substr($fio[2],2);;
if(isset($fio[3])) $model->ot.=' '.$fio[3];// двойные отчетства
?>
        <?= $form->field($model, 'fam')->textInput(); ?>
        <?= $form->field($model, 'im')->textInput() ?>
        <?= $form->field($model, 'ot')->textInput() ?>
        <?= $form->field($model, 'pol')->dropdownlist(['0'=>'Женский','1'=>'Мужской']) ?>
        <?php $model->rod=date('d.m.Y');
            echo $form->field($model, 'rod')->widget(DatePicker::className(),[           
            'dateFormat' => 'php:d.m.Y',
            'language' => 'ru',
            'options'=>['autocomplete'=>'off','placeholder'=>'дд.мм.гггг'],
               'clientOptions' => [
                    'format' => 'dd.mm.yyyy',
                    'autoclose'=>true,
                    'weekStart'=>1, 
                ]
            ]);?>
        <?php echo $form->field($fmodel, 'adr_main')->widget(
                        		AutoComplete::className(), [            
                            			'clientOptions' => [
                                		'source' =>$fmodel->bls_auto(),
                                		'autoFill'=>true,
                                		'minLength'=>'4',
                                        'select' => new JsExpression("function( event, ui ) {
                                            $('#paspfio-id_bls').val(ui.item.id);
                                        }")],
                                		'options' =>['style'=>'width:500px']
                                 	]);?>
        <?= Html::activeHiddenInput($model, 'id_bls')?>                                
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div>
