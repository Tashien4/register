<?php

namespace app\models;

use Yii;
 use app\models\LogEdit;

class Lgot extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dop_lgot';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_fio', 'id_lgot', 'pp'], 'required'],
            [['id_fio', 'id_lgot', 'pp'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_fio' => 'Id Fio',
            'id_lgot' => 'Id Lgot',
            'pp' => 'Pp',
        ];
    }
//------------------------
  public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);
   	foreach($changedAttributes as $ch=>$key){
		$lmodel=new LogEdit;
		$fmodel=Lgot::findOne($this->id);
      $lmodel->obj=$this->tableName();
      $lmodel->key_id=$fmodel->id; 
      $lmodel->field=$ch; 
      $lmodel->newvalue=$fmodel[$ch]; 
      $lmodel->oldvalue=$key;
      $lmodel->coper=Yii::$app->user->id;
      if($lmodel->newvalue!=$lmodel->oldvalue)
      $lmodel->save();
   }
}  
//---------------------------------------

//---------------------------------
public static function find_lgot($id) {
    $rows = (new \yii\db\Query())
     ->select(['_lgtypes.name'])
     ->from('_lgtypes')
    ->where('id='.$id)
     ->One();
      
  return $rows['name'];
 }
//---------------------------------
public static function find_lgot_dop($id,$pp) {
    $rows = (new \yii\db\Query())
     ->select(['_lgtypes.name','_lgtypes.id'])
     ->from('_lgtypes')
     ->join('inner join','dop_lgot','dop_lgot.id_lgot=_lgtypes.id')
    ->where('dop_lgot.id_fio='.$id.' and pp='.$pp)
     ->One();
      if($rows['id']==0) return ''; 
        else  return $rows['name'];
 }
}
