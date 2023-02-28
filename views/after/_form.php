<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\After */
/* @var $form yii\widgets\ActiveForm */
?>
 <style>.tab_3 {table-layout:fixed;width:100%}
.tab_3 td {font-size:15px;padding:5px;border:1px solid black;}</style>
<div class="after-form">

<table class="tab_3">
<tr>
    <td>
                                                 
    <?= $form->field($model, 'reability')->textarea() ?>
    </td><td>
    <?= $form->field($model, 'medicine')->textarea() ?>
    </td><td>
    <?= $form->field($model, 'psiho')->textarea() ?>
    </td></tr>

	<tr><td>
    <?= $form->field($model, 'indiv')->textarea() ?>
     </td><td>
    <?= $form->field($model, 'sanatory')->textarea() ?>
        </td><td>
    <?= $form->field($model, 'social')->textarea() ?>
    	</td></tr>

	<tr><td>   <br><br>
    <?= $form->field($model, 'uridict')->textarea() ?>
         </td><td>
    <?= $form->field($model, 'vosstan')->textarea() ?>
    	 </td><td><br><br>
    <?= $form->field($model, 'trud')->textarea() ?>
            </td></tr>

	<tr><td>
       <?= $form->field($model, 'new_trud')->textarea() ?>  </td><td>
 <?= $form->field($model, 'stady')->textarea() ?>
     </td><td>
    <?= $form->field($model, 'perepod')->textarea() ?>
         </td></tr>
<tr><td>
    <?= $form->field($model, 'finans_help')->textarea() ?>
        </td><td>
    <?= $form->field($model, 'veterans')->textarea() ?>
           </td></td>
	<td>     <br>
	<?= $form->field($model, 'initiative')->textarea() ?>
      </td></tr><tr><td colspan=3>
    <?= $form->field($model, 'others')->textarea() ?>      </td></tr>

</table>
    <br>
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success','name'=>'save_after']) ?>



</div>
