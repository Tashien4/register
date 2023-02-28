<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Finans */
/* @var $form yii\widgets\ActiveForm */
?>


  <style>
.tab_2 th,.tab_2 td{border:1px solid black;font-size:15px;padding:0px 5px;}
.tab_2 {width:100%;}
</style>
<table class="tab_2">
   <tr><td colspan=2>
    <?php //$form = ActiveForm::begin();  ?>
    <?php echo $form->field($finmodel, 'aliment')->textInput() ;?>
 </td></tr>
<tr>
<td><?= $form->field($finmodel, 'credit')->textInput(); ?></td>
<td><?= $form->field($finmodel, 'ipot')->textInput(); ?></td></tr>
<tr>    <td><?= $form->field($finmodel, 'carcredit')->textInput(); ?></td>
    <td><?= $form->field($finmodel, 'arenda')->textInput(); ?></td></tr>

<tr><td colspan=2>    <?= $form->field($finmodel, 'uch_ip')->textInput() ?></td></tr>

<tr><td colspan=2>    <?= $form->field($finmodel, 'dir_ip')->textInput() ?></td></tr>

<tr><td colspan=2>    <?= $form->field($finmodel, 'third_face')->textInput() ?></td></tr>

<tr><td colspan=2>    <?= $form->field($finmodel, 'poruch')->textInput() ?></td></tr>
</table>
 <br>
  <div class="form-group">
        <?php echo Html::submitButton('Сохранить', ['class' => 'btn btn-success','name'=>'finans']) ?>
   </div>



<?php //ActiveForm::end(); ?>