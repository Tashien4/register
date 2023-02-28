<?php

namespace app\models;


use Yii;
use yii\data\ActiveDataProvider;
use app\models\LogEdit;

class Fio extends \yii\db\ActiveRecord
{
public $fio='';
public $rod='';
public $tabs='';
public $tel='';
public $fio_married='';
public $adr_check=0;
public $adr_main,$adr_dop;
public $lgtype_1,$lgtype_2,$lgtype_3=0;

    public static function tableName()
    {
        return 'fio';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        //    [['id_fio', 'id_bls', 'id_bls_reg', 'id_bls_fact', 'tel', 'family_status', 'org', 'dolg', 'obr', 'spec', 'lgtype', 'house_status', 'gas', 'water', 'blag', 'form', 'tab'], 'required'],
            [['id','lgtype_1','lgtype_2','lgtype_3', 'id_bls', 'id_bls_reg', 'family_status', 'lgtype', 'adr_check', 'tab'], 'integer'],
           
            [['rod'], 'safe'],      //,'date_ot','date_vozv'
             [['prim','tel'], 'string', 'max' => 500],
 	        [['fio','fio_married','adr_main'], 'string', 'max' => 100],
            [['org', 'dolg', 'obr', 'spec','tabs','adr_dop'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
	    'fio' => 'Фамилия Имя Отчество',
            'rod' => 'Дата рождения',
            'adr_main'=>'Адрес проживания',
            'adr_check'=>'Совпадает?',
            'id_bls' => 'Домашний адрес',
            'id_bls_reg' => 'Регистрация',
            'id_bls_fact' => 'Фактическое проживание',
            'family_status' => 'Наличие брака',
	    'fio_married'=>'ФИО супруга/и',
            'org' => 'Место работы',
            'dolg' => 'Должность',
            'obr' => 'Образование',
            'spec' => 'Специальность',
            'lgtype' => 'Наличие основной льготной категории',
            'lgtype_1' => 'Наличие иной льготной категории',
            'lgtype_2' => 'Наличие иной льготной категории',
            'lgtype_3' => 'Наличие иной льготной категории',
            'house_status' => 'Жилищно-бытовые условия проживания',
           
            'tab' => 'Ответственный',
            'tabs' => 'Ответственный',
            'prim' => 'Примечание',

        ];
    }
//--------------------------------------------------------
//------------------------
  public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);
   	foreach($changedAttributes as $ch=>$key){
		$lmodel=new LogEdit;
		$fmodel=Fio::findOne($this->id);
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

//------------------------------------------
public function getPaspfio()
{
    return $this->hasOne(Paspfio::className(),['id'=>'id']);
}
//------------------------------------------
public function getBls()
{
    return $this->hasOne(Bls::className(),['id'=>'id_bls']);
}

//------------------------------------------  
//------------------------------------------
public function getRfio()
{
    return $this->hasOne(Rfio::className(),['tab'=>'tab']);
}

//------------------------------------------  
public function new_lg($id,$lg){
	$sql='update fio set lgtype='.$lg.' where id='.$id;
        $row=Yii::$app->db->createCommand($sql)->execute();

 return $row;


}
//----------------------
//------------------------------------
public function update_tel($tab,$tel){
     $row=[];  
	if($tel!='') {
        if($tab<1000)
        $sql='update kadry_vse.fio set tel="'.$tel.'" where tab='.$tab;
	else $sql='update docs.org_fio set tel="'.$tel.'" where id='.$tab;
	
        $row=Yii::$app->db->createCommand($sql)->execute();
        };
 return $row;


}
//----------------------

//------------------------------------
public function order_tab($id,$tab,$tel){
	$sql='update fio set tab='.$tab.' where id='.$id;
        $row=Yii::$app->db->createCommand($sql)->execute();
       
	if($tel!='') {

        $sql='update rfio set tel="'.$tel.'" where tab='.$tab;
	
        $row=Yii::$app->db->createCommand($sql)->execute();
        };

 return $row;


}
//----------------------

public function findbyautoresult($famplusrod) {
    $ret=null;
if ($famplusrod) {
    $rows = Yii::$app->db->createCommand("
        select ff.id as id
        from fio ff 
        where concat(ff.fam,' ',ff.im,' ',ff.ot,' ',date_format(ff.rod,'%d.%m.%Y')) like '".$famplusrod."'
        
         ;"
    )->queryOne();
    $ret=$rows['id'];

    }
return ($ret);
}
//------------------------------------------------------
public function find_for_excel($id) {
               	$sql=sprintf("
			select concat(fio.fam,'_',fio.im,'_',fio.ot) as name
			from paspfio as fio
			where id=".$id);
		$command=Yii::$app->db->createCommand($sql); 
		$rows = $command->queryOne();
           return $rows['name'];
}
//---------------------------------
public function find_lgot() {
   $rows = (new \yii\db\Query())
    ->select(['id', 'name'])
    ->from('_lgtypes')
    ->orderby('id asc')
    ->all();
     foreach($rows as $r)
          $list[$r['id']]=$r['name'];
 return $list;
}
//---------------------------------
public function list_org() {
    $rows = (new \yii\db\Query())
     ->select(['id', 'name'])
     ->from('otdels')
     ->orderby('id asc')
     ->all();
      foreach($rows as $r)
           $list[$r['id']]=$r['name'];
  return $list;
 }
//---------------------------------------------------
public function find_otvet($fio) {
      $rows = Yii::$app->db->createCommand("
      select tab
	from rfio
	where fio like '".$fio."'
    ")->queryOne();

    if(isset($rows['tab']) and $rows['tab']>0)
	return $rows['tab'];
else return 0;
}
//--------------------------------------------------
//---------------------------------------------------
public function create_rfio($fio,$id_org,$tel,$dolg,$id_fio){
      	
    Yii::$app->db->createCommand()
        ->insert('rfio', [
        'fio' => $fio,
        'tel' => $tel,
        'dolg' => $dolg,
    ])->execute();
        $id = Yii::$app->db->getLastInsertID();
        $sql='update fio set tab='.$id.' where id='.$id_fio;
        $row=Yii::$app->db->createCommand($sql)->execute();
      

 return $id;
}
//---------------------------------------------------

     public function fio_auto() {
//создаем запрос к таблице с информацией о получателях с выбором ФИО и даты рождения.
//выбираем только тех, кто старше 18 лет
    $rows = Yii::$app->db->createCommand("
    select concat(ff.fam,' ',ff.im,' ',ff.ot,' ',DATE_FORMAT(ff.rod,'%d.%m.%Y')) as value,
            concat(ff.fam,' ',ff.im,' ',ff.ot,' ',DATE_FORMAT(ff.rod,'%d.%m.%Y')) as label, ff.id as id
	from paspfio ff
	where 1
    order by concat(ff.fam,' ',ff.im,' ',ff.ot);
    ")->queryAll();
    //полученный результат передаем в виджет
    return $rows;
    }
//-----------------------------------------------
public function tab_auto() {
            	$sql=sprintf("
			select fio as value,fio as label,tab as id
			from rfio
			where 1");
		$command=Yii::$app->db->createCommand($sql); 
		$rows = $command->queryAll();
           return $rows;

}
//------------------------------------------------
//-----------------------------------------------
public function find_tab($id) {
            	$sql=sprintf("
			select fio as name
			from rfio
			where tab=".$id);
		$command=Yii::$app->db->createCommand($sql); 
		$rows = $command->queryOne();
           return $rows['name'];

}
//---------------------------------------
public static function give_me_adr($id,$type=0){
    $rows = (new \yii\db\Query())
    ->select(["if(bls.id=0,'Не определен',concat(npunkt.name,', ',type_street.name,streets.name,', ',bls.dom,
    if(bls.kv>0,concat(', кв. ',bls.kv),''))) as adr"])
    ->from('bls')
    ->join('left join','streets','streets.id=bls.id_ul')
    ->join('left join','npunkt','npunkt.id=streets.id_npunkt')
    ->join('left join','type_street','type_street.id=streets.id_type')
    ->join('inner join','fio',($type==0?'fio.id_bls':'fio.id_bls_reg').'=bls.id')
    ->where('fio.id='.$id)
    ->one();
     
 return $rows['adr'];
}
//------------------------------------------------
//------------------------------------------------
public function bls_auto(){
        	$sql=sprintf("select if(bls.id=0,'Не определен',concat(npunkt.name,', ',type_street.name,streets.name,', ',bls.dom,
            if(bls.kv>0,
                concat(', кв. ',bls.kv),''
            ))
        ) as label,
        if(bls.id=0,'Не определен',concat(npunkt.name,', ',type_street.name,streets.name,', ',bls.dom,
            if(bls.kv>0,
                concat(', кв. ',bls.kv),''
            ))
        )  as value,
        bls.id as id
        from bls
        left join streets on streets.id=bls.id_ul
        left join npunkt on npunkt.id=streets.id_npunkt
        left join type_street on type_street.id=streets.id_type 
        where 1
		");
		$command=Yii::$app->db->createCommand($sql); 
		$rows = $command->queryAll();
           return $rows;
	}
//-----------------------------
public static function find_father($id_fio) {
    $rows = (new \yii\db\Query())
    ->select(['concat(fio.fam," ",fio.im," ",fio.ot) as fio'])
    ->from('paspfio as fio')
    ->where('fio.id='.$id_fio)
    ->One();
  return $rows['fio'];
}


//------------------------
public function search($params)
    {
        $query = Fio::find()
		->joinWith(['paspfio'])->joinWith(['bls'])->joinWith(['rfio'])
	;

        $dataProvider = new ActiveDataProvider([
            'query' => $query, 
	    'pagination' => [
		'pagesize' => 10,
    		], 
     
        ]);
        $dataProvider->sort->attributes['fio'] = [
            'asc' => ['paspfio.fam' => SORT_ASC],
            'desc' => ['paspfio.fam' => SORT_DESC],
        ];
 
    $this->load($params);

        $query->andFilterWhere(['id' => $this->id])
        ->andFilterWhere(['like', 'paspfio.fam', trim($this->fio)])
        ->andFilterWhere(['like', 'paspfio.fam', $this->tel])
        ->andFilterWhere(['like', 'paspfio.rod', $this->rod])
        ->andFilterWhere(['like', 'bls.adr', $this->id_bls])
        ->andFilterWhere(['like', 'rfio.fio', $this->tab])

;
                               
        return $dataProvider;
    }
//------------------------------------
}




