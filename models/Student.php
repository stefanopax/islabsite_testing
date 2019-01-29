<?php

namespace app\models;

/**
 * This is the model class for table "{{%student}}".
 *
 * @property int $id
 * @property string $register_id
 *
 * @property Exam-student[] $exam-students
 * @property User $id0
 * @property Student-course-site[] $student-course-sites
 */
class Student extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%student}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['register_id'], 'required'],
            [['register_id'], 'integer'],
            [['register_id'], 'unique'],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id' => 'id']],
			[['mail'], 'string', 'max'=> 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'register_id' => 'Register ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubcribes()
    {
        return $this->hasMany(Subscribes::className(), ['student' => 'id']);
    }

	public static function findStudent($id)
    {
        return static::findOne(['id' => $id]);		
	}

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getId0()
    {
        return $this->hasOne(User::className(), ['id' => 'id']);
    }

    /**
     * @return int
     */
	public function getId()
    {
        return $this->id;
    }

    /**
     * @param integer $id
     * @return void
     */
	public function setId($id)
	{
		$this->id = $id;
	}

    /**
     * @param int $register_id
     * @return void
     */
	public function setRegister($register_id)
	{
		$this->register_id = $register_id;
	}

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudent_course_sites()
    {
        return $this->hasMany(Student-course-site::className(), ['student' => 'id']);
    }

    /**
     * @param integer $insert
     * @param integer $changedAttributes
     * @return void
     * @throws \Exception
     */
	public function afterSave($insert, $changedAttributes)
    {
        $auth = \Yii::$app->authManager;
        $authRole = $auth->getRole('student');
        $auth->revokeAll($this->getId());
        if($authRole) {
            $auth->assign($authRole, $this->getId());    
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCourseSites()
    {
        return $this->hasMany(CourseSite::className(), ['id' => 'course_site'])
            ->viaTable('{{%registers}}', ['student' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExams()
    {
        return $this->hasMany(Exam::className(), ['id' => 'exam'])
            ->viaTable('{{%subscribes}}', ['student' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequestedThesis()
    {
        return $this->hasMany(Thesis::className(), ['id' => 'thesis'])
            ->viaTable('{{%request}}', ['student' => 'id']);
    }
}
