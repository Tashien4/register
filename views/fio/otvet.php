<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\AutoComplete;

/* @var $this yii\web\View */
/* @var $model app\models\Fio */
/* @var $form yii\widgets\ActiveForm */
?>



    
<?php echo $model->getAttributeLabel('tab');?>
		<?php 
	$model->tabs=$model->find_tab($model->tab); 
			echo '<br>'.$form->field($model, 'tabs')->widget(
                        AutoComplete::className(), [            
                            'clientOptions' => [
                                'source' =>$model->tab_auto(),
                                'autoFill'=>true,

                                'minLength'=>'3'],
                                'options' =>['style'=>'width:500px']
                                 ])->label('');    
                                          
			    ?>
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success','name'=>'save_otvet']) ?>	

 

     <?php  echo $this->render('/reestr/list', ['id_fio' => $model->id]);?>
