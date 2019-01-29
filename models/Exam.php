<?php

namespace app\models;

/**
 * This is the model class for table "exam".
 *
 * @property int $id
 * @property string $title
 * @property string $date
 * @property string $opening_date
 * @property string $closing_date
 * @property string $type
 * @property string $info
 * @property int $course
 *
 * @property Course $course0
 * @property Subscribes[] $subscribes
 */
class Exam extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'exam';
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'type', 'course'], 'required'],
            [['date', 'opening_date', 'closing_date'], 'safe'],
            [['info'], 'string'],
            [['course'], 'default', 'value' => null],
            [['course'], 'integer'],
            [['title'], 'string', 'max' => 50],
            [['type'], 'string', 'max' => 30],
            [['course'], 'exist', 'skipOnError' => true, 'targetClass' => Course::className(), 'targetAttribute' => ['course' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'date' => 'Date',
            'opening_date' => 'Opening Date',
            'closing_date' => 'Closing Date',
            'type' => 'Type',
            'info' => 'Info',
            'course' => 'Course',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCourse0()
    {
        return $this->hasOne(Course::className(), ['id' => 'course']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubscribes()
    {
        return $this->hasMany(Subscribes::className(), ['exam' => 'id']);
    }

    /**
     * @return integer
     */
    public function getCourse()
    {
        return $this->course;
    }

}