<?php

namespace app\models;

/**
 * This is the model class for table "{{%course_site}}".
 *
 * @property int $id
 * @property string $title
 * @property string $edition
 * @property string $opening_date
 * @property string $closing_date
 * @property string $css
 * @property string $feed
 * @property bool $is_current
 * @property int $course
 *
 * @property Course $course0
 * @property Page[] $pages
 * @property Registers[] $registers
 */
class CourseSite extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%course_site}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'edition', 'course'], 'required'],
            [['opening_date', 'closing_date'], 'safe'],
            [['css'], 'string'],
            [['is_current'], 'boolean'],
            [['course'], 'default', 'value' => null],
            [['course'], 'integer'],
            [['title', 'edition'], 'string', 'max' => 30],
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
            'edition' => 'Edition',
            'opening_date' => 'Opening Date',
            'closing_date' => 'Closing Date',
            'css' => 'Css',
            'is_current' => 'Is Current',
            'course' => 'Course',
        ];
    }

    /**
     * @param $course
     * @return CourseSite|null
     */
    public static function findCurrentCourseSite($course)
    {
        return static::findOne(['course' => $course, 'is_current' => true]);
    }

    /**
     * @return bool
     */
    public function getCurrentAttribute()
    {
        return $this->is_current;
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCourse0()
    {
        return $this->hasOne(Course::className(), ['id' => 'course']);
    }

    /**
     * @return int
     */
    public function getCourse()
    {
        return $this->course;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPages()
    {
        return $this->hasMany(Page::className(), ['course_site' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegisters()
    {
        return $this->hasMany(Registers::className(), ['course_site' => 'id']);
    }

    /**
     * @param integer $id
     * @return CourseSite
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * @param integer $course
     * @return boolean
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     * @throws \yii\web\HttpException
     */
    public function createCourseSite($course)
    {
        $current = CourseSite::findCurrentCourseSite($course);
        $this->title = $current->title;
        $this->edition = $current->edition;
        $this->css = $current->css;
        $this->course = $current->course;
        if($this->save()) {
            // create pages
            $pages = new Page();
            if($pages->createCourseSitePages($this->id, $current->id)) {
                return true;
            }
            else {
                $this->delete();
                throw new \yii\web\HttpException(404, 'Not possible to create a course');
            }
        }
        else {
            throw new \yii\web\HttpException(404, 'Not possible to create a course');
        }
    }

    /**
     * @param integer $course
     * @return boolean
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     * @throws \yii\web\HttpException
     */
    public function createNewCourseSite($course)
    {
        $this->title = 'TO FILL';
        $this->edition = 'TO FILL';
        $this->course = $course;
        if($this->save()) {
            $pages = new Page();
            if($pages->createNewPages($this->id)) {
                return true;
            }
            else {
                $this->delete();
                throw new \yii\web\HttpException(404, 'Not possible to create pages');
            }
        }
        else {
            throw new \yii\web\HttpException(404, 'Not possible to create a course');
        }
    }

    /**
     * @return void
     */
    public function softDelete()
    {
        $this->is_current = false;
        $this->save();
    }
}
