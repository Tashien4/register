<?php

namespace app\models;
use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\data\ActiveDataProvider;


class User extends ActiveRecord implements IdentityInterface
{
    public $user = false;
    private $_model;
    public $iscensored=0;
    public $school;
    public $change_mod;
    public $role;
    public $login;
    public static function tableName()
    {
        return 'users';
    }
    public function rules()
    {
        return [
            [['password'], 'required'],
            [['usernamerus', 'password','username'], 'string', 'max' => 50],
            [['ingroup'],'integer'],
	    ['role','find_role'],
            ['password', 'validatePassword'],
        ];
    }
    public function attributeLabels()
    {
        return [
            
            'usernamerus' => 'ФИО пользователя',
            'login' => 'ФИО пользователя',

            'password' => 'Пароль',
            'username'=>'Логин',
            'ingroup'=>'Организация',
            'school'=>'Организация',

            'role'=>'Роль',
      
        ];
    }
     //---------------------------------------------------

public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if(!$this->getUser())
            {
           $this->addError($attribute, 'Неверный логин или пароль');

            } 
        }
    }
 //--------------------------------------------------   
//---------------------------------------------------
 public function find_only_user_list() {
    $resStr='';

 $row[-1]='';
$rows = Yii::$app->db->createCommand('
	select users.id,users.usernamerus as name
	from users
	where 1
')->queryAll();

foreach($rows as $r)
   $row[$r['id']]=$r['name'];
return $row;
}
 
 //-------------------------------------------------
   public function find_role() {
        $upd=Yii::$app->user->identity->getParams(Yii::$app->user->id);
        return $upd['role'];
     

}
//-----------------
 public static function findIdentity($id)
 {
     return static::findOne($id);
 }
//--------------------
 public function getId()
 {
     return $this->id;
 }
 
 public static function 
 findIdentityByAccessToken($token, $type = null)
 {
   
 }
 
 public function getAuthKey()
 {
    
 }

 public function validateAuthKey($authKey)
 {
   
 }

 public function login()
    {
        if ($this->validate()) {
        	return Yii::$app->user->login($this->getUser());
        }
    }
//--------------------------------------------------
    public function getUser()
    {
      if ($this->user === false) { //если пользователь существует
        //определяем пользователя по логину и шифрованному хешу

            $this->user = User::findOne(['username'=>$this->login,
                'password'=>sha1(md5($this->login).md5($this->password))]);
      }       
     return $this->user;
   }
//----------------------------------------------------------
protected function loadUser($id=null)
{
    if(($this->_model===null) or ($id!==null and $this->id!=$id))
    {
        if($id!==null)
            $this->_model=User::findOne($id);;
    }
    return $this->_model;
}
//-------------------------------------------------------------
    //---------------------------------------------
    public function isAdmin(){
        $id_us=Yii::$app->user->id;
        $user = $this->loadUser($id_us);
        $aparam=$this->getParams();	
    
        $role=((isset($aparam['role']))?$aparam['role']:0);   
         if ($user) {	
            return $role;
        } else {
            return 0;
        }
      }
      //--------------------------------------------
//------------------------------------------
public function search($params,$upd)
{
    $query = User::find();

    $dataProvider = new ActiveDataProvider([
        'query' => $query,
    ]);
    $per=$_SESSION['cur_period'];  
  print_r( $this->validate());

    if (!($this->load($params) && $this->validate())) {
        return $dataProvider;
    }

    // adjust the query by adding the filters
    $query->andFilterWhere(['usernamerus' => $this->usernamerus])
    ->andFilterWhere(['like', 'username', $this->username])
          ->andFilterWhere(['like', 'ingroup', $this->ingroup]);
          
     //     ->andFilterWhere(['like', 'type_name.name', $this->type_name]);

    return $dataProvider;
}
//------------------------------------
}