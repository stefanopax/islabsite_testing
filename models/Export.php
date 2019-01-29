<?php

namespace app\models;

/**
 * This is the model class for table "export".
 *
 * @property int $id
 * @property string $username
 * @property string $name
 * @property string $surname
 * @property int $register_id
 * @property string $result
 * @property string $historcal
 */
class Export extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'export';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['register_id'], 'default', 'value' => null],
            [['register_id'], 'integer'],
            [['historcal'], 'string'],
            [['username'], 'string', 'max' => 60],
            [['name', 'surname'], 'string', 'max' => 50],
            [['result'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'name' => 'Name',
            'surname' => 'Surname',
            'register_id' => 'Register ID',
            'result' => 'Result',
            'historcal' => 'Historcal',
        ];
    }
}
