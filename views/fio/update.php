<?php

use yii\helpers\Html;
use yii\helpers\Url;
 use yii\jui\DatePicker;
 use yii\web\JsExpression;
use yii\widgets\ActiveForm;
use yii\jui\AutoComplete;
use app\models\Bls;
use app\models\Family;
use app\models\Lgot;

?>
 <style>
.form-group {
    margin-bottom: 0px;
}
.tab th,.tab td{border:1px solid black;font-size:15px;padding: 0px 5px;}
.tab {width:100%}
.tabs {
    width: 100%;
    height: 700px; 
}
.tabs ul,
.tabs li { 
    margin: 0;
    padding: 0;
    list-style: none;
}
.tabs,
.tabs input[type="radio"]:checked + label {
    position: relative;
}
.tabs li,
.tabs input[type="radio"] + label {
    display: inline-block;
}
.tabs li > div,
.tabs input[type="radio"] {
    position: absolute;
}
.tabs li > div,
.tabs input[type="radio"] + label {
    border: solid 1px #ccc;
}
.tabs {
font: normal 11px Arial, Sans-serif;
    color: #404040;

}
.tabs li {
    vertical-align: top;
}
.tabs li:first-child {
    margin-left: 8px;
}
.tabs li > div {
    top: 33px;
    bottom: 0;
    left: 0;
    width: 100%;
    padding: 8px;
    overflow: auto;
    background: #fff;
    -moz-box-sizing: border-box;
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
}
.tabs input[type="radio"] + label {
    margin: 0 2px 0 0;
    padding: 0 18px;
    line-height: 32px;
    background: #f1f1f1;
    text-align: center;
    border-radius: 5px 5px 0 0;
    cursor: pointer;
    -moz-user-select: none;
    -webkit-user-select: none;
    user-select: none;
font-size:15px;

}
.tabs input[type="radio"]:checked + label {
    z-index: 1;
   background: #c1daff;
color:black;
    border-bottom-color: #fff;
    cursor: default;
font-size:20px;
}
.tabs input[type="radio"] {
    opacity: 0;
}
.tabs input[type="radio"] ~ div {
    display: none;
    
}
.tabs input[type="radio"]:checked:not(:disabled) ~ div {
    display: block;
}
.tabs input[type="radio"]:disabled + label {
    opacity: .5;
    cursor: no-drop;
}
</style>
      <h4><b><?php echo $pmodel->fam.' '.$pmodel->im.' '.$pmodel->ot.' ('.$pmodel->rod.')'?></b></h4>
<?php echo  Html::a('Формы ecxel', ['excel?id_fio='.$model->id], ['class' => 'btn btn-success']) ?><br><br>
    <?php $form = ActiveForm::begin(); ?>
<div class="tabs">
  <ul>
    <li>
     <input type="radio" name="tabs-0" checked="checked" id="tabs-0-0" />
        <label for="tabs-0-0">Информация</label>
	   <div style="background: linear-gradient(to bottom, #e0e9f7  , #fff1dc);">

		<table class="tab">
			
			<th><?php echo $pmodel->getAttributeLabel('tel');?></th>
			<td ><?php echo $form->field($pmodel,'tel')->textinput()->label('');?></td>
			<th><?php echo $pmodel->getAttributeLabel('email');?></th>
			<td ><?php echo $form->field($pmodel,'email')->textinput()->label('');?></td></tr>
 
			<tr>
			<th colspan=2 style='width:40%;'><?php echo $model->getAttributeLabel('id_bls');?></th>
				<td colspan=2><br><div onclick='	var idd=document.getElementById("adr"); 
					if(idd.style.display=="none"){  idd.style.display = "block"; } 
					else{ idd.style.display = "none";}'>
<?php  $adr=$model->give_me_adr($model->id);
		echo '<b style="text-decoration:underline;cursor:pointer;">'.$adr.'</b></div>
			
					<div id="adr" style="display:none;">';

					echo $form->field($model, 'adr_main')->widget(
                        		AutoComplete::className(), [            
									'clientOptions' => [
                                		'source' =>$model->bls_auto(),
                                		'autoFill'=>true,
                                		'minLength'=>'3',
                                        'select' => new JsExpression("function( event, ui ) {
                                            $('#fio-id_bls').val(ui.item.id);
                                        }")],
                                		'options' =>['style'=>'width:500px']
                                 	])->label('');         
			    ?>
				<?= Html::activeHiddenInput($model, 'id_bls')?>  <br>
		   		</div>
				</td>
		</tr> 
		<tr>
			<th colspan=2 style='width:40%;'><?php echo $model->getAttributeLabel('id_bls_reg');?></th>
				<td colspan=2>
				<?php  $model->adr_check=($model->id_bls==$model->id_bls_reg?'1':'0');
				 echo  $form->field($model,'adr_check')->
						checkbox([
							'onclick'=>'var idd=document.getElementById("dop_adr"); 
					if(idd.style.display=="none"){  idd.style.display = "block"; } 
					else{ idd.style.display = "none";}'])->label('');

				if($model->adr_check==0) echo  $model->give_me_adr($model->id,1);

				echo '<div id="dop_adr" style="display:none;">';  
				echo $form->field($model, 'adr_dop')->widget(
                        		AutoComplete::className(), [            
                            			'clientOptions' => [
                                		'source' =>$model->bls_auto(),
                                		'autoFill'=>true,
                                		'minLength'=>'3',
										'select' => new JsExpression("function( event, ui ) {
                                            $('#fio-id_bls_reg').val(ui.item.id);
                                        }")],
                                		'options' =>['style'=>'width:500px']
                                 	])->label('');         
			    
			    ?><?= Html::activeHiddenInput($model, 'id_bls_reg')?> 
		   		</div>
				</td>
		</tr>
		
	<tr><th colspan=2>Семейное положение</th>
	<td colspan=2>
	<?php   $model->fio_married=Family::find_wife($model->id);
		echo $form->field($model, 'fio_married')->widget(
                        AutoComplete::className(), [            
                            'clientOptions' => [
                                'source' =>$model->fio_auto(),
                                'autoFill'=>true,
                                'minLength'=>'3',
								'select' => new JsExpression("function( event, ui ) {
									$('#fio-family_status').val(ui.item.id);
								}")],
                                'options' =>['style'=>'width:500px']
                                 ]);	
?>     <?= Html::activeHiddenInput($model, 'family_status')?>
</td></tr>
       	<tr><th><?php echo $model->getAttributeLabel('org');?></th>
		<td ><?php echo $form->field($model,'org')->textinput()->label('');?></td>

	<th ><?php echo $model->getAttributeLabel('dolg');?></th>
		<td ><?php echo $form->field($model,'dolg')->textinput()->label('');?></td></tr>

	<tr><th colspan=2><?php echo $model->getAttributeLabel('obr');?></th>
		<td colspan=2><?php echo $form->field($model,'obr')->textinput()->label('');?></td></tr>

       	<tr><th colspan=2><?php echo $model->getAttributeLabel('spec');?></th>
		<td colspan=2><?php echo $form->field($model,'spec')->textinput()->label('');?></td></tr>
 	
        <tr><th colspan=4>
		<?php echo $form->field($model,'prim')->textArea();?></td></tr>

	</table>
<br><?= Html::submitButton('Сохранить', ['class' => 'btn btn-success','name'=>'save']) ?>
		</div>
	</li>
    	<li>
     <input type="radio" name="tabs-0"  id="tabs-0-1" />
        <label for="tabs-0-1">Льготы</label>
		<div style="background: linear-gradient(to bottom, #e0e9f7 , #fff1dc);">
     		<table class="tab">
      	<tr><th style='width:40%;' ><?php echo $model->getAttributeLabel('lgtype');?></th>
		<td><?php echo $form->field($model,'lgtype')->dropdownlist($model->find_lgot())->label('');?></td></tr>

         	<tr><th><?php echo $model->getAttributeLabel('lgtype_1');?></th>
		<td><?php    $l1=Lgot::findOne(['id_fio'=>$model->id,'pp'=>1]);
		             if(!isset($l1))   $model->lgtype_1=0;
				else $model->lgtype_1=$l1->id_lgot;
		             
			echo $form->field($model,'lgtype_1')->dropdownlist($model->find_lgot())->label('');?></td></tr>
 	<tr><th><?php 
			 $l2=Lgot::findOne(['id_fio'=>$model->id,'pp'=>2]);
		        if(!isset($l2)) 
			  $model->lgtype_2=0; 
			else $model->lgtype_2=$l2->id_lgot; 
		echo $model->getAttributeLabel('lgtype_2');?></th>
		<td><?php echo $form->field($model,'lgtype_2')->dropdownlist($model->find_lgot())->label('');?></td></tr>
 	<tr><th><?php  $l3=Lgot::findOne(['id_fio'=>$model->id,'pp'=>3]);  
			if(!isset($l3))   $model->lgtype_3=0; else
		             $model->lgtype_3=$l3->id_lgot;
		echo $model->getAttributeLabel('lgtype_3');?></th>
		<td><?php echo $form->field($model,'lgtype_3')->dropdownlist($model->find_lgot())->label('');?></td></tr>
 

		</table><br>
              <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success','name'=>'save_lgot']) ?>
	</div>
	</li><li>
     <input type="radio" name="tabs-0"  id="tabs-0-3" />
        <label for="tabs-0-3">Члены семьи</label>
		<div style="background: linear-gradient(to bottom, #e0e9f7 , #fff1dc);font-size:15px;">

		  <?php  echo $this->render('/family/index', ['main_m' => $model]);?>
		</div></li>
    <li>
     <input type="radio" name="tabs-0"  id="tabs-0-4" />
        <label for="tabs-0-4">Обращения</label>
		<div style="background: linear-gradient(to bottom, #e0e9f7 , #fff1dc);font-size:15px;">
  		
                 <div style="display:flex;align-items: flex-end;"><div>
		<?php echo $model->getAttributeLabel('tab');?>
		<?php 
			$model->tabs=$model->find_tab($model->tab); 
		
              if($role==1)          
					echo '<br>'.$form->field($model, 'tabs')->widget(
                        AutoComplete::className(), [            
                            'clientOptions' => [
                                'source' =>$model->tab_auto(),
                                'autoFill'=>true,

                                'minLength'=>'3',
								'select' => new JsExpression("function( event, ui ) {
									$('#fio-tab').val(ui.item.id);
								}")],
                                'options' =>['style'=>'width:500px']
                                 ])->label('');
				else echo $model->tabs;				 
								 ?>  <?= Html::activeHiddenInput($model, 'tab')?>   
                     <?php echo '</div><div style="padding-left: 20px;">'.$form->field($rfiomodel,'tel')->textInput(['style'=>'width:300px;']);                    
			    ?></div></div>
    		<?= Html::submitButton('Сохранить', ['class' => 'btn btn-success','name'=>'save_otvet']) ?>	
     		<?php  echo $this->render('/reestr/list', ['id_fio' => $model->id]);?>

		</div>
	</li>
   <li>
     <input type="radio" name="tabs-0"  id="tabs-0-5" />
        <label for="tabs-0-5">Фин. обязательства</label>
		<div style="background: linear-gradient(to bottom, #e0e9f7 , #fff1dc);font-size:15px;">
		  
		  <?php echo $this->render('/finans/update', ['finmodel' => $finmodel,'form'=>$form]);?>
                           
		</div>
	</li>
          <li>
     <input type="radio" name="tabs-0"  id="tabs-0-6" />
        <label for="tabs-0-6">Соц. помощь</label>
		<div style="background: linear-gradient(to bottom, #e0e9f7 , #fff1dc);font-size:15px;">
		  
		  <?php  echo $this->render('/after/update', ['model' => $afmodel,'form'=>$form]);?>
                           
		</div>
	</li>


</ul>
</div>
 <script>
let params = (new URL(document.location)).searchParams; 

var variable=params.get("rel");
if(typeof(variable) != "undefined" && variable !== null)
  document.getElementById("tabs-0-"+(variable-1)).checked = true;  
    
</script>

    <?php ActiveForm::end(); ?>
    
