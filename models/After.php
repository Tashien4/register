<?php

namespace app\models;

use Yii;
use app\models\LogEdit;
 
class After extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'after';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        //    [['id_fio', 'reability', 'medicine', 'psiho', 'indiv', 'sanatory', 'social', 'uridict', 'vosstan', 'trud', 'stady', 'perepod', 'finans_help', 'veterans', 'initiative', 'others'], 'required'],
            [['id_fio'], 'integer'],
            [['reability', 'medicine', 'psiho','new_trud', 
		'indiv', 'sanatory', 'social', 'uridict', 
		'vosstan', 'trud', 'stady', 'perepod',
		 'finans_help', 'veterans', 'initiative', 'others'], 'string', 'max' => 250],
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
            'reability' => 'Реабилитационные мероприятия',
            'medicine' => 'Медицинская помощь',
            'psiho' => 'Психологическая поддержка',
            'indiv' => 'Средства индивидуальной реабилитации',
            'sanatory' => 'Санаторно-курортное лечение',
            'social' => 'Социальная помощь',
            'uridict' => 'Юридическая помощь',
            'trud' => 'Трудоустройство',

            'vosstan' => 'Восстановление по месту работы',
            'new_trud' => 'Помощь в трудоустройстве по новому месту работы',
            'stady' => 'Получение образования, в том числе дополнительного',
            'perepod' => 'Профессиональная подготовка / переподготовка',
            'finans_help' => 'Меры финансовой поддержки',
            'veterans' => 'Участие в деятельности общественной организации участников (ветеранов) боевых действий',
            'initiative' => 'Инициативные меры поддержки органов местного самуправления',
            'others' => 'Иная информация',
        ];
    }
//------------------------
  public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);
   	foreach($changedAttributes as $ch=>$key){
		$lmodel=new LogEdit;
		$fmodel=After::findOne($this->id);
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
}
