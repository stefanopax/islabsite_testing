<?php

namespace app\models;

/**
 * This is the model class for table "subscribes".
 *
 * @property int $exam
 * @property int $student
 * @property string $date
 * @property string $result
 *
 * @property Exam $exam0
 * @property Student $student0
 */
class Subscribes extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'subscribes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['exam', 'student', 'date'], 'required'],
            [['exam', 'student'], 'default', 'value' => null],
            [['exam', 'student'], 'integer'],
            [['date'], 'safe'],
            [['result'], 'string', 'max' => 20],
            [['exam', 'student'], 'unique', 'targetAttribute' => ['exam', 'student']],
            [['exam'], 'exist', 'skipOnError' => true, 'targetClass' => Exam::className(), 'targetAttribute' => ['exam' => 'id']],
            [['student'], 'exist', 'skipOnError' => true, 'targetClass' => Student::className(), 'targetAttribute' => ['student' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'exam' => 'Exam',
            'student' => 'Student',
            'date' => 'Date',
            'result' => 'Result',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExam0()
    {
        return $this->hasOne(Exam::className(), ['id' => 'exam']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'student']);
    }

    /**
     * @param $student
     * @param $exam
     * @return Subscribes
     */
    public static function findByStudentExam($student, $exam)
    {
        return static::findOne(['student' => $student , 'exam' => $exam]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudent0()
    {
        return $this->hasOne(Student::className(), ['id' => 'student']);
    }

    /**
     * @param $student
     * @return void
     */
    public function setStudent($student)
    {
        $this->student = $student;
    }

    /**
     * @return void
     */
    public function setData()
    {
        $this->date = date('Y-m-d');
    }

    /**
     * @param $exam
     * @return void
     */
    public function setExam($exam)
    {
        $this->exam = $exam;
    }

    /**
     * @return int
     */
    public function getExam()
    {
        return $this->exam;
    }

    /**
     * @param string $result
     * @return void
     */
    public function setResult($result)
    {
        $this->result = $result;
    }

    /**
     * @param integer $student
     * @param integer $course
     * @return string
     */
    public static function getHistory($student, $course)
    {
        $historical = '';
        $exams = Subscribes::find()->leftJoin('exam','exam = id')->where(['course' => $course])->andWhere(['student' => $student])->all();
        foreach($exams as $exm) {
            $title = Exam::findOne(['id' => $exm->exam]);
            $historical =  $historical . ' ' . $title->title . ' : ' .  $exm->result . ' ' ;
        }

        return $historical;
    }
}
