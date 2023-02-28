<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
use app\models\LogEdit;
use app\models\ObrTheme;
class Reestr extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'reestr';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_fio', 'vypl', 'tab', 'status','poluch','nom'], 'integer'],
            [['date', 'srok'], 'safe'],
            [['theme', 'zag', 'prim','otvet'], 'string', 'max' => 1000],
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
            'date' => 'Дата',
            'theme' => 'Направления (тематика обращений) адресной работы с семьями',
            'zag' => 'Суть обращения (запроса)',
            'vypl' => 'Характер выполнения решения',
            'tab' => 'Ответственный',
            'prim' => 'Краткое описание решения о порядке исполнения обращения (запроса)',
            'srok' => 'Срок',
            'otvet' => 'Ответственный за исполнение (организация, ФИО представителя организации, контактный телефон)',
            'poluch'=>'Способ получения',
            'nom'=>'Регистрационный номер',

            'status' => 'Оценка статуса обращения',
        ];
    }
//------------------------------------------
public function getPaspfio()
{
    return $this->hasOne(Paspfio::className(),['id'=>'id_fio']);
}
//------------------------------------------
public function getTheme()
{
    return $this->hasOne(ObrTheme::className(),['id'=>'theme']);
}

//------------------------------------------
public static function list_status() {
    $list=[];
   $rows = (new \yii\db\Query())
    ->select(['id', 'name'])
    ->from('_reestr_status')
    ->all();
     foreach($rows as $r)
          $list[$r['id']]=$r['name'];
 return $list;
	
}
 //------------------------
//------------------------------------------
public function list_poluch() {
   $rows = (new \yii\db\Query())
    ->select(['id', 'name'])
    ->from('_poluch')
    ->all();
     foreach($rows as $r)
          $list[$r['id']]=$r['name'];
 return $list;
	
}
 //------------------------

//------------------------------------------
public static function find_status($id) {
   $rows = (new \yii\db\Query())
    ->select(['name'])
    ->from('_reestr_status')
    ->where(['id'=>$id])
    ->One();
 return $rows['name'];
	
}
 //------------------------
//------------------------------------------
public static function find_theme($id) {
   $rows = (new \yii\db\Query())
    ->select(['name'])
    ->from('_obr_theme')
    ->where(['id'=>$id])
    ->One();
 return $rows['name'];
	
}
 //------------------------

//------------------------------------------
public function list_theme() {
   $rows = (new \yii\db\Query())
    ->select(['id', 'name'])
    ->from('_obr_theme')
    ->all();
     foreach($rows as $r)
          $list[$r['id']]=$r['name'];
 return $list;
	
}
 //------------------------
public function search($params,$id_fio=0)
    {
       $id_fio=($id_fio>0?$id_fio:'>0');

        $query = Reestr::find()
		->joinWith(['paspfio'])->joinWith(['theme'])
	//	->where(['id_fio'=>$id_fio])
	;
	if($id_fio>0) $query->where(['id_fio'=>$id_fio]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query, 
	    'pagination' => [
		'pagesize' => 10,
    		], 
        //   'sort'=> ['defaultOrder' => [''=> SORT_ASC]]
        ]);
        $dataProvider->sort->attributes['nom'] = [
            'asc' => ['reestr.nom' => SORT_ASC],
            'desc' => ['reestr.nom' => SORT_DESC],
        ];
 
       // print_r($params);
    //    $this->attributes=$params;
    //     print_r($this->tel);
  /*      if (!($this->load($params) && $this->validate())) {
            return $dataProvider;   echo '1111';

        };  */ $this->load($params);
    //     $rod= new \yii\db\Expression('(pasp.fio.rod::text)');
        // adjust the query by adding the filters
        $query->andFilterWhere(['id' => $this->id])
        ->andFilterWhere(['like', 'pasp.fio.fam', $this->id_fio])
        ->andFilterWhere(['like', 'reestr.nom', $this->nom])
        ->andFilterWhere(['like', 'reestr.prim', $this->prim])
        ->andFilterWhere(['like', 'reestr.zag', $this->zag])
        ->andFilterWhere(['like', 'reestr.date', $this->date])
        ->andFilterWhere(['like', '_obr_theme.name', $this->theme])

        ->andFilterWhere(['like', 'reestr.srok', $this->srok]);
      /*  ->andFilterWhere(['like', 'piar.adr', $this->id_bls_reg]);  */
                               
        return $dataProvider;
    }
//------------------------------------
//------------------------
  public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);
   	foreach($changedAttributes as $ch=>$key){
		$lmodel=new LogEdit;
		$fmodel=Reestr::findOne($this->id);
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
