<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\AutoComplete;

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
                                'minLength'=>'4'],
                                'options' =>['style'=>'width:600px']
                                 ]);
                                          
			    ?>
</div><div>&emsp;</div>
<div style="width:350px;">
 
<?php 
     echo $form->field($model,'form')->dropdownlist($model->list_form());

?>
</div> 
</div>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success','name'=>'save']) ?>
    </div>

    <?php ActiveForm::end(); ?>


