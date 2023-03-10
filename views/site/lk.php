<?php 

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Site;

?>
<?php $form = ActiveForm::begin(); ?>
<h2 align=center>Личный кабинет пользователя</h2>
<br><br>
<style>
td{padding: 5px;color:black; font-size:20px}
.butn {padding:10px; color:black;font-weight: bold;}
.butn:hover{color:white;cursor:pointer;background:#55b8ff;}
input {padding:5px;}
.rtd {width:35%; text-align:right;}
</style>
<table style="width:100%">
<tr>


<?php if($role==1) 
    echo '<td class="rtd">Имя:</td><td> '.$form->Field($model,'usernamerus')->textInput(array('style'=>'width:50%'))->label(false).'</td></tr>';
    else echo  '<td class="rtd">Имя:</td><td> '.$model->usernamerus.'</td></tr>';


if($role==1) {
    $model->role=$model->role;
    echo '<tr><td  class="rtd">Роль в системе:</td>
            <td>'.$form->field($model,'role')->dropDownList(['0'=>'Пользователь','1'=>'Администратор'],array('style'=>'width:50%'))->label(false).'</td></tr>';
};
echo '<tr><td class="rtd">Пароль:</td><td>'.$form->field($model,'password')->passwordInput(array('style'=>'width:50%'))->label(false).'</td></tr>';
?>
</table>
<br><br>
<div style="display: flex;align-content: flex-end;justify-content: center;">
	<?php echo Html::submitButton('Сохранить',array('class'=>'butn','onclick'=>'prov()')); ?></div>
   
   <?php ActiveForm::end(); ?>
<script>
    function prov() {
        alert('Данные сохранены')
    }
    </script>