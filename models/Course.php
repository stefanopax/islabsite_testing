<?php

namespace app\models;

/**
 * This is the model class for table "{{%course}}".
 *
 * @property int $id
 * @property string $title
 * @property bool $is_active
 *
 * @property CourseSite[] $courseSites
 * @property Exam[] $exams
 * @property Handles[] $handles
 * @property Staff[] $staff
 */
class Course extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%course}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['is_active'], 'boolean'],
            [['title'], 'string', 'max' => 100],
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
            'is_active' => 'Is Active',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCourseSites()
    {
        return $this->hasMany(CourseSite::className(), ['course' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExams()
    {
        return $this->hasMany(Exam::className(), ['course' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHandles()
    {
        return $this->hasMany(Handles::className(), ['course' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaff()
    {
        return $this->hasMany(Staff::className(), ['id' => 'staff'])->viaTable('{{%handles}}', ['course' => 'id']);
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return void
     */
    public function softDelete()
    {
        $this->is_active = false;
        $this->save();
    }
}
