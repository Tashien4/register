<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
use app\models\LogEdit;
class Family extends \yii\db\ActiveRecord
{
public $rod;
public $fio;
public $adr;
 
   public static function tableName()
    {
        return 'family';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
   //        
            [['ch_id_fio', 'id_fio',  'rel', 'status', 'id_bls', 'id_lgot'], 'integer'],
            [['tel'], 'string', 'max' => 20],
            [['rod'], 'safe'],

            [['accaunt', 'work','fio', 'stady','adr'], 'string', 'max' => 250],
           
            [['prim'], 'string', 'max' => 250],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
 
            'ch_id_fio' => 'ФИО',
            'fio' => 'ФИО',
           'rod' => 'Дата рождения',
            'id_fio' => 'Обратившийся',
            
            'rel' => 'Отношение',
            'status' => 'Status',
            'tel' => 'Телефон',
            'prim' => 'Примечание',

            'id_bls' => 'Адрес места жительства',
            'accaunt' => 'Аккаунт в социальных сетях',
            'id_lgot' => 'Наличие льготной категории',
            'blag' => 'Уровень благосостояния',
            'work' => 'Место работы/учебы, должность',
            'sopr' => 'Необходимость регулярного сопровождения',
            'stady' => 'Занятие в учреждениях дополнительного образования, спортивных и иных секциях и кружках (организация, периодичность посещения)',
        ];
    }
//------------------------
//-----------------------------
public static function find_family($id_fio) {
    $rows = Yii::$app->db->createCommand("
           select concat(fio.fam,' ',fio.im,' ',fio.ot) as fio,fio.rod,family.*
           from family
           inner join paspfio as fio on fio.id=family.ch_id_fio
           where family.id_fio=".$id_fio
       )->queryAll();
   
      if(!isset($rows['id']))        
               $rows = Yii::$app->db->createCommand("
           select 'Не указан' as fio,'0000-00-00' as rod,family.*
           from family
           where family.id=0"
       )->queryOne();
     return $rows;
   }
   //-----------------------------------------
   //-----------------------
public function find_family_excel($id_fio,$pp) {
    $sql="
            select concat(fio.fam,' ',fio.im,' ',fio.ot) as fio,fio.rod,family.*
            from family
            inner join paspfio on fio.id=family.ch_id_fio
            inner join fio ff on ff.id=family.id_fio
            where family.id_fio=".$id_fio." and family.contact=0 and family.id_bls".
            ($pp==0?'=ff.id_bls':($pp==1?'!=ff.id_bls and family.id_bls>0':'=0'))
        ;
        $rows = Yii::$app->db->createCommand($sql)->queryAll();
    return $rows;
    
    }
    //------------------------------------------
    
//-----------------------------
public static function find_all_about_concat($id_fio) {
    $rows = Yii::$app->db->createCommand("
           select concat(fio.fam,' ',fio.im,' ',fio.ot) as fio,fio.rod,family.*
           from family
            inner join paspfio as fio on fio.id=family.ch_id_fio
           where family.id_fio=".$id_fio
       )->queryOne();
   
      if(!isset($rows['id']))        
               $rows = Yii::$app->db->createCommand("
           select 'Не указан' as fio,'0000-00-00' as rod,family.*
           from family
           where family.id=0"
       )->queryOne();
     return $rows;
   }
   //-----------------------------------------
   
  public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);
   	foreach($changedAttributes as $ch=>$key){
		$lmodel=new LogEdit;
		$fmodel=Family::findOne($this->id);
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
public static function find_relation($id) {
   $rows = (new \yii\db\Query())
    ->select('name')
    ->from('_rel')
    ->where('id='.$id)
    ->One();
    return $rows['name'];

}
//-------------------------------
public function find_father($id) {
   $sql = 'select concat(ff.fam," ",ff.im," ",ff.ot) as name 
    from paspfio as ff
    where id='.$id;
  $command=Yii::$app->db->createCommand($sql); 
		$rows = $command->queryOne();
              
    return $rows['name'];
	

}
//-----------------------
//------------------------------------------
public static function find_wife($id) {
   $sql = 'select concat(ff.fam," ",ff.im," ",ff.ot) as name 
    from family
    inner join paspfio as ff on ff.id=family.ch_id_fio
    where family.id_fio='.$id.' and family.rel=2';
  $command=Yii::$app->db->createCommand($sql); 
		$rows = $command->queryOne();

if(isset($rows['name']))
	$name=$rows['name'];
else $name='';
    return $name;
	

}
//------------------------
public function list_relation() {
   $rows = (new \yii\db\Query())
    ->select('*')
    ->from('_rel')
    ->where('(id!=1 and id!=3)and id<90')
    ->All();
	foreach($rows as $r)
		$list[$r['id']]=$r['name'];
    return $list;

}
//------------------------------------------
//-----------------------------
public function find_fio($id_fio) {
    $rows = (new \yii\db\Query())
    ->select(['concat(fio.fam," ",fio.im," ",fio.ot) as fio'])
    ->from('paspfio')
    ->where('fio.id='.$id_fio)
    ->One();
 
          $list=$rows['fio'];
 return $list;
}
//-----------------------------------------
public function getPaspfio()
{
    return $this->hasOne(Paspfio::className(),['id'=>'ch_id_fio']);
}
//------------------------------------------
//-----------------------------------------
public function getPaspfiomain()
{
    return $this->hasOne(Paspfio::className(),['id'=>'id_fio']);
}
//------------------------------------------

//------------------------
public function search($params,$id_fio)
    {
        $query = Family::find()
		->joinWith(['paspfio'])->where(['family.id_fio'=>$id_fio])
	;

        $dataProvider = new ActiveDataProvider([
            'query' => $query, 
	    'pagination' => [
		'pagesize' => 10,
    		], 
        //   'sort'=> ['defaultOrder' => [''=> SORT_ASC]]
        ]);
        $dataProvider->sort->attributes['fio'] = [
            'asc' => ['fio.fam' => SORT_ASC],
            'desc' => ['fio.fam' => SORT_DESC],
        ];
 
 $this->load($params);
  
        // adjust the query by adding the filters
        $query->andFilterWhere(['id' => $this->id])
        ->andFilterWhere(['like', 'fio.fam', $this->ch_id_fio])
        ->andFilterWhere(['like', 'fio.rod', $this->rod])
        ->andFilterWhere(['like', 'rel', $this->rel]);

                                                    
        return $dataProvider;
    }
//------------------------------------
//------------------------
public function search2($params)
    {
        $query = Family::find()
		->joinWith(['paspfio'])->joinWith(['paspfiomain as pm'])
	;

        $dataProvider = new ActiveDataProvider([
            'query' => $query, 
	    'pagination' => [
		'pagesize' => 10,
    		], 
        //   'sort'=> ['defaultOrder' => [''=> SORT_ASC]]
        ]);
        $dataProvider->sort->attributes['fio'] = [
            'asc' => ['fio.fam' => SORT_ASC],
            'desc' => ['fio.fam' => SORT_DESC],
        ];
 
       // print_r($params);
    //    $this->attributes=$params;
    //     print_r($this->tel);
  /*      if (!($this->load($params) && $this->validate())) {
            return $dataProvider;   echo '1111';

        };  */ $this->load($params);
  
        // adjust the query by adding the filters
        $query->andFilterWhere(['id' => $this->id])
        ->andFilterWhere(['like', 'pm.fam', $this->id_fio])

        ->andFilterWhere(['like', 'fio.fam', $this->ch_id_fio])
        ->andFilterWhere(['like', 'fio.rod', $this->rod])
        ->andFilterWhere(['like', 'rel', $this->rel]);
    
        return $dataProvider;
    }

}
