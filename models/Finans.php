<?php

namespace app\models;

use Yii;
use app\models\LogEdit;

class Finans extends \yii\db\ActiveRecord
{


    public static function tableName()
    {
        return 'finans';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
      //      [['id_fio', 'aliment', 'credit', 'uch_ip', 'dir_ip', 'third_face', 'poruch'], 'required'],
            [['id_fio'], 'integer'],
            [['aliment','credit','ipot','carcredit','arenda', 'uch_ip', 'dir_ip', 'third_face', 'poruch'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_fio' => 'ID',
            
            'aliment' => 'Наличие алиментных обязательств (основание и ФИО получателей)',
            'credit'=>'Потребительский кредит',
            'ipot'=>'Ипотека',
            'carcredit'=>'Автокредит',
            'arenda'=>'Арендные платежи',
            'uch_ip' => 'Учредитель организации ИП, ООО',
            'dir_ip' => 'Руководитель (директор) ИП, ООО',
            'third_face' => 'Передача доверительного управления ИП, ООО третьим лицам',
            'poruch' => 'Выступление поручителем по кредитам ИП, ООО',
        ];
    }

 //------------------------
  public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);
   	foreach($changedAttributes as $ch=>$key){
		$lmodel=new LogEdit;
		$fmodel=Finans::findOne($this->id_fio);
      $lmodel->obj=$this->tableName();
      $lmodel->key_id=$fmodel->id_fio; 
      $lmodel->field=$ch; 
      $lmodel->newvalue=$fmodel[$ch]; 
      $lmodel->oldvalue=$key;
      $lmodel->coper=Yii::$app->user->id;
      if($lmodel->newvalue!=$lmodel->oldvalue)
      $lmodel->save();
   }
}  
//---------------------------------------
public function find_credit($id){
    $sql=sprintf("
        select concat(
            if(credit!='',concat(credit,'; '),''),
            if(ipot!='',concat(ipot,'; '),''),
            if(carcredit!='',concat(carcredit,'; '),''),
            if(arenda!='',concat(arenda,';'),'')
        ) as name
        from finans
        where id_fio=".$id);
$command=Yii::$app->db->createCommand($sql); 
$rows = $command->queryOne();
return $rows['name'];


}

}
