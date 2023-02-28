<?php

namespace app\models;

use Yii;
class Rfio extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
//public $fio;
    public static function tableName()
    {
        return 'rfio';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tab', 'otdel'], 'integer'],
            [['tel'], 'string', 'max' => 92],
            [['dolg','fio'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tab' => 'Табельный',
            'dolg' => 'Должность',
            'fio' => 'ФИО',
	    'tel' => 'Телефон',
            'otdel' => 'Отдел',
            'fullname' => 'Организация',
        ];
    }
}
