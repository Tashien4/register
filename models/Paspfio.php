<?php

namespace app\models;

use Yii;

class Paspfio extends \yii\db\ActiveRecord
{
public $adr;

    public static function tableName()
    {
        return 'paspfio';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'id','id_bls','adr'], 'integer'],
            [['rod', 'lastedit',], 'safe'],
            [['prim'], 'string', 'max' => 250],
            [['fam', 'ot', 'tel'], 'string', 'max' => 25],
            [['im'], 'string', 'max' => 20],
            [['snils'], 'string', 'max' => 11],
            [['pol'], 'integer', 'max' => 1],
            [['email'], 'email'],
            [['snils'], 'unique'],
            [['tel'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_bls' => 'Адрес регистрации',
            'fam' => 'Фамилия',
            'im' => 'Имя',
            'ot' => 'Отчество',
            'snils' => 'СНИЛС',
            'tel' => 'Телефон',
            'rod' => 'Дата рождения',
            'pol' => 'Пол',
            'email' => 'Email',
            'prim' => 'Примечание',
            'adr' => 'Адрес регистрации совпадает с фактическим?',
         ];
    }
}
