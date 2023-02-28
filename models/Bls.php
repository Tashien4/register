<?php

namespace app\models;

use Yii;

class Bls extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bls';
    }
public $adr;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_ul', ], 'integer'],
           
            [['kv','dom'], 'string', 'max' => 100],
           
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',

            'id_ul' => 'Id Ul',
            'dom' => 'Дом',
    
            'kv' => 'Kv',

          
        ];
    }
//------------------------------------------

public function find_city() {
  $rows = (new \yii\db\Query())
    ->select(['id','name'])
    ->from('npunkt')
    ->All();
	foreach($rows as $r)
		$list[$r['id']]=$r['name'];
   return $list;

}
//-------------------------------------
public function find_ul() {
  $rows = (new \yii\db\Query())
    ->select(['id','name'])
    ->from('streets')
    ->where('id>0')
    ->All();
	foreach($rows as $r)
		$list[$r['id']]=$r['name'];
   return $list;

}
//--------------------------------------
//-------------------------------------
public function find_dom() {
  $rows = (new \yii\db\Query())
    ->select(['id','name'])
    ->from('home')

    ->where('id>0')
    ->All();
	foreach($rows as $r)
		$list[$r['id']]=$r['name'];
   return $list;

}
//-------------------------------------
public function find_kv() {
  $rows = (new \yii\db\Query())
    ->select(['id','kv'])
    ->from('bls')
    ->where('id>0')
    ->All();
	foreach($rows as $r)
		$list[$r['id']]=$r['kv'];
   return $list;

}

//-------------------------------
public static function find_adr($id_bls) {
            	$sql=sprintf("
               
            if(bls.id=0,'Не определен',concat(npunkt.name,', ',type_street.name,streets.name,', ',bls.dom,
                if(bls.kv>0,
                    concat(', кв. ',bls.kv),''
                ))
            )  as adr
            from bls
            left join streets on streets.id=bls.id_ul
            left join npunkt on npunkt.id=streets.id_npunkt
            left join type_street on type_street.id=streets.id_type 
            where bls.id=".$id_bls);
		$command=Yii::$app->db->createCommand($sql); 
		$rows = $command->queryOne();
   return $rows['adr'];
}
//------------------------------------
}
