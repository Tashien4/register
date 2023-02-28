<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_edit".
 *
 * @property int $id
 * @property string $obj
 * @property int $key_id
 * @property string $field
 * @property string $newvalue
 * @property string $oldvalue
 * @property int $coper
 * @property string $lastedit
 */
class LogEdit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_edit';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['obj', 'key_id', 'field', 'newvalue', 'oldvalue', 'coper'], 'required'],
            [['key_id', 'coper'], 'integer'],
            [['lastedit'], 'safe'],
            [['obj', 'field'], 'string', 'max' => 50],
            [['newvalue', 'oldvalue'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'obj' => 'Obj',
            'key_id' => 'Key ID',
            'field' => 'Field',
            'newvalue' => 'Newvalue',
            'oldvalue' => 'Oldvalue',
            'coper' => 'Coper',
            'lastedit' => 'Lastedit',
        ];
    }
}
