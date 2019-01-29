<?php

namespace app\models;

/**
 * This is the model class for table "{{%page}}".
 *
 * @property int $id
 * @property string $title
 * @property string $content
 * @property bool $is_home
 * @property bool $is_public
 * @property bool $is_news
 * @property int $course_site
 *
 * @property CourseSite $courseSite
 */
class Page extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%page}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'course_site'], 'required'],
            [['content'], 'string'],
            [['is_home', 'is_public', 'is_news'], 'boolean'],
            //[['course_site'], 'default', 'value' => null],
            [['course_site'], 'integer'],
            [['title'], 'string', 'max' => 30],
            [['course_site'], 'exist', 'skipOnError' => true, 'targetClass' => CourseSite::className(), 'targetAttribute' => ['course_site' => 'id']],
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
            'content' => 'Content',
            'is_home' => 'Is Home',
            'is_public' => 'Is Public',
            'is_news' => 'Is News',
            'course_site' => 'Course Site',
        ];
    }

    /**
     * @param integer $id
     * @return Page[]
     */
    public static function findCoursePage($id)
    {
        return static::findAll(['course_site' => $id]);		// 'is_disabled' => 0
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCourseSite()
    {
        return $this->hasOne(CourseSite::className(), ['id' => 'course_site']);
    }

    /**
     * @param integer $newCourseSite
     * @param integer $pagesOldCourseSite
     * @return bool
     */
    public function createCourseSitePages($newCourseSite,$pagesOldCourseSite)
    {
        $pages = Page::findCoursePage($pagesOldCourseSite);
        foreach($pages as $page) {
            $p = new Page();
            $p->title = $page->title;
            $p->content = $page->content;
            $p->is_home = $page->is_home;
            $p->is_public = $page->is_public;
            $p->is_news = $page->is_news;
            $p->course_site = $newCourseSite;
            $p->save();
        }
        return true;
    }

    /**
     * @param integer $courseSite
     * @return bool
     */
    public function createNewPages($courseSite)
    {
        $this->title = 'TO FILL';
        $this->is_home = false;
        $this->is_news = false;
        $this->is_public = false;
        $this->course_site = $courseSite;
        return $this->save();
    }

    /**
     * @return int
     */
    public function getCourseS()
    {
        return $this->course_site;
    }

    public function getHome()
    {
        return $this->is_home;
    }
    public function getNews()
    {
        return $this->is_news;
    }

    public function softDelete()
    {
        $this->is_public = false;
        $this->save();
    }
}
