<?php

namespace app\models;

use yii\db\Expression;

/**
 * This is the model class for table "{{%thesis}}".
 *
 * @property int $id
 * @property string $title
 * @property string $company
 * @property string $description
 * @property string $duration
 * @property string $requirements
 * @property string $course
 * @property int $n_person
 * @property string $ref_person
 * @property bool $is_visible
 * @property int $created_at
 * @property bool $trien
 * @property int $staff
 *
 * @property Request[] $requests
 * @property Student[] $students
 * @property Staff $staff0
 */
class Thesis extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%thesis}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'description', 'duration', 'course', 'n_person', 'created_at','trien', 'staff'], 'required'],
            [['description'], 'string'],
            [['duration', 'n_person', 'ref_person', 'created_at', 'staff'], 'default', 'value' => null],
            [['n_person', 'staff'], 'integer'],
            [['created_at'], 'safe'],
            [['is_visible','trien'], 'boolean'],
			[['duration'], 'string', 'max' => 100],
            [['title', 'company'], 'string', 'max' => 20],
            [['requirements'], 'string', 'max' => 40],
            [['course','ref_person'], 'string', 'max' => 30],
            [['staff'], 'exist', 'skipOnError' => true, 'targetClass' => Staff::className(), 'targetAttribute' => ['staff' => 'id']],
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
            'company' => 'Company',
            'description' => 'Description',
            'duration' => 'Duration',
            'requirements' => 'Requirements',
            'course' => 'Course',
            'n_person' => 'N Person',
            'ref_person' => 'Ref Person',
            'is_visible' => 'Is Visible',
            'created_at' => 'Created At',
            'trien' => 'Trien',
            'staff' => 'Staff',
        ];
    }

    /**
     * @param integer $id
     * @return Thesis
     */
    public static function findThesis($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequests()
    {
        return $this->hasMany(Request::className(), ['thesis' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudents()
    {
        return $this->hasMany(Student::className(), ['id' => 'student'])->viaTable('{{%request}}', ['thesis' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaff0()
    {
        return $this->hasOne(Staff::className(), ['id' => 'staff']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'staff']);
    }

    /**
     * @return void
     */
	public function setData()
	{
        $this->created_at= new Expression('NOW()');
	}

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
	public function getTitle()
    {

        return $this->title;
    }

    /**
     * @param integer $id
     * @return void
     */
	public function softDelete($id)
    {
		$this->is_visible=false;
		$this->save(false);
	}

    /**
     * @param string $title
     * @return Thesis
     */
    public static function findByTitle($title)
    {
        return static::findOne(['title' => $title]);
    }
}
