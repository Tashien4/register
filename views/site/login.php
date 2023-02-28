<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\jui\AutoComplete;
use app\models\Users;
use yii\web\JsExpression;

?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<style>

    .ui-menu-item-wrapper{font-size: 0.8em;}
    .col-lg-3 {
        width:200px;
        max-width: 100%;
        text-align: right;
    }
    #users-username {width:300px;}

    #login-form {width: 700px;
    border: 5px outset #e3e1e1;
    padding: 0 0px 20px 0px;
    text-align: center;
margin:20px;}
.site-login{display: flex;
    justify-content: center;}
.field-user-password {display: flex;

    align-content: space-between;
    justify-content: space-evenly;
}
</style>
<div class="site-login">

    <?php 
 $form = ActiveForm::begin([
        'id' => 'login-form',
    ]); ?>
<?= $form->errorSummary($model)?>
<h1>Авторизация</h1>

 <br>
<h5>Введите имя и пароль для определения Ваших полномочий:</h5>
<br><table style="width:100%;text-align:center;">
    <tr><td>
        	<?php echo $form->field($model, 'login')->dropdownlist($model->find_only_user_list());?>

</td></tr>
    <tr><td colspan=2>
		<?php echo $form->field($model, 'password')->passwordInput(['style'=>'width:70%;']); ?>
</td></tr>
<tr><td colspan=2 align=center>
		<?php echo Html::submitButton('Войти', ['style'=>'padding:5px;width: 300px;']); ?>
                                </td></tr>

  </table>
<br>
                              
При возникновении вопросов звоните 75-715 или 75-627

    <?php ActiveForm::end(); ?>

<script type="text/javascript">
$('#user-school').on('change', function () { 

    $.ajax('user_login?school=' + this.value, {
        type: "POST",
        dataType: 'json',
        success: function (data) {
            if (data.success) {
                $('#user-login').empty();

                $.each(data.prows, function (key, val) {
                    $('#user-login').append('<option value="'+val.id+'">'+val.name+'</option>');
                  
                });
            }
        }
    });
});
</script> 