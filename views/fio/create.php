<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\AutoComplete;
use yii\web\JsExpression;
/* @var $this yii\web\View */
/* @var $model app\models\Fio */
/* @var $form yii\widgets\ActiveForm */
?>

<div style="display:flex;align-items: flex-end;">
    <div>
    <?php $form = ActiveForm::begin([  'method' => 'post','fieldConfig' => [ 'template' => '{label}<br>{input}']]); ?>
                       <?php echo $form->field($model, 'fio')->widget(
                        AutoComplete::className(), [            
                            'clientOptions' => [
                                'source' =>$model->fio_auto(),
                                'autoFill'=>true,
                                'minLength'=>'2',
                                'select' => new JsExpression("function( event, ui ) {
                                    $('#fio-id').val(ui.item.id);
                                }")],
                                'options' =>['style'=>'width:600px'],
                               
                                 ]);
                                          
			    ?>
                <?= Html::activeHiddenInput($model, 'id')?>
</div><div>&emsp;</div>

</div>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success','name'=>'save']) ?>
    </div>

    <?php ActiveForm::end(); ?>


