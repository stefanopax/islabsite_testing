<?php

namespace app\models;

use yii\db\Expression;

/**
 * This is the model class for table "{{%request}}".
 *
 * @property int $thesis
 * @property int $student
 * @property string $title
 * @property int $created_at
 * @property bool $confirmed_at
 *
 * @property Student $student0
 * @property Thesis $thesis0
 */
class Request extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%request}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['thesis', 'student', 'created_at'], 'required'],
            [['thesis', 'student', 'created_at'], 'default', 'value' => null],
            [['thesis', 'student'], 'integer'],
            [['confirmed_at'], 'boolean'],
            [['created_at'], 'safe'],
            [['title'], 'string', 'max' => 100],
            [['thesis', 'student'], 'unique', 'targetAttribute' => ['thesis', 'student']],
            [['student'], 'exist', 'skipOnError' => true, 'targetClass' => Student::className(), 'targetAttribute' => ['student' => 'id']],
            [['thesis'], 'exist', 'skipOnError' => true, 'targetClass' => Thesis::className(), 'targetAttribute' => ['thesis' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'thesis' => 'Thesis',
            'student' => 'Student',
            'title' => 'Title',
            'created_at' => 'Created At',
            'confirmed_at' => 'Confirmed At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudent0()
    {
        return $this->hasOne(Student::className(), ['id' => 'student']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'student']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getThesis0()
    {
        return $this->hasOne(Thesis::className(), ['id' => 'thesis']);
    }

    /**
     * @param integer $id
     * @return void
     */
    public function setStudent($id)
    {
        $this->student = $id;
    }

    /**
     * @return void
     */
    public function setData()
    {
        $this->created_at = new Expression('NOW()');
    }

    /**
     * @return void
     */
    public function softDelete()
    {
        $this->confirmed_at = false;
        $this->save(false);
    }
}
