<?php


use yii\helpers\Html;
use app\models\Excel;
use app\models\Fio;

$model=Fio::findOne($id_fio);
$title=$model->find_for_excel($id_fio);       
Excel::fio_excel($id_fio);
Excel::reestr_excel($id_fio);
?>


<div style='display:flex;    justify-content: space-around;'>
<?php echo  Html::a('Скачать Форма 1',['output/ФОРМА_'.$title.'_1.xlsx'],['class'=>'btn btn-success']);?>
<?php echo  Html::a('Скачать Форма 2',['output/ФОРМА_'.$title.'_2.xlsx'],['class'=>'btn btn-success']);?>
</div>
