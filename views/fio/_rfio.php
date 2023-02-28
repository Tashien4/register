<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Rfio;
use app\models\Fio;
/* @var $this yii\web\View */
/* @var $model app\models\Fio */
/* @var $form ActiveForm */
?>
<div class="rfio">
<?php echo  Html::a('Назад', ['update?id='.$id_fio.'&rel=5'], ['class' => 'btn btn-success']) ?><br>
<h3>Отвественный сотрудник не был найден. Пожалуйста, введите его данные</h3>
    <?php $form = ActiveForm::begin(); ?>
   <?php  
	echo $form->field($model,'fio')->textInput();
        echo $form->field($model,'otdel')->dropdownList($fmodel->list_org()).'*Если в списке нет необходимой организации,то обратитесь к администраторам<br>';
	echo $form->field($model,'dolg')->textInput();

	echo $form->field($model,'tel')->textInput();
?> 
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary', 'name'=>'save']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- _rfio -->
