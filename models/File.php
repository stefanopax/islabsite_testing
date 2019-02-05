<?php

namespace app\models;

use Yii;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * This is the model class for table "file".
 *
 * @property int $id
 * @property string $title
 * @property string $extension

 * @property bool $is_public
 * @property int $course_site
 *
 * @property CourseSite $courseSite
 */
class File extends \yii\db\ActiveRecord
{
    /**
     * @var UploadedFile
     */
    public $imageFile;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'file';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => false],
            [['is_public'], 'boolean'],
            [['course_site'], 'required'],
            [['course_site'], 'default', 'value' => null],
            [['course_site'], 'integer'],
            [['title'], 'string', 'max' => 200],
            [['extension'], 'string', 'max' => 20],
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
            'extension' => 'Extension',
            'is_public' => 'Is Public',
            'course_site' => 'Course Site',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCourseSite()
    {
        return $this->hasOne(CourseSite::className(), ['id' => 'course_site']);
    }

    /**
     * @param string $extension
     * @return void
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;
    }

    /**
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * @return bool
     */
    public function getPublic()
    {
        return $this->is_public;
    }

    /**
     * @return integer
     */
    public function getCourseSiteId()
    {
        return $this->course_site;
    }

    /**
     * @return void
     */
    public function softDelete()
    {
        $this->is_public = false;
        $this->save();
    }

    /**
     * @param integer $id
     * @return bool
     */
    public function upload($id)
    {
        if($this->validate()) {
            $this->imageFile->name = $id . '.' . $this->imageFile->extension;
            try {
                $this->imageFile->saveAs('uploads/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);
            }
            catch(\Exception $exception) {
                return false;
            }
            return true;
        }
        else {
            return false;
        }
    }

    /**
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function findFile($id)
    {
        if(($model = File::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * @param integer $id
     * @return void
     * @throws NotFoundHttpException
     */
    public function download($id)
    {
        $ext = $this->findFile($id);
        $path = Yii::getAlias('@webroot') . '/uploads';

        $file = $path . '/' . $id . '.' .  $ext->extension;

        if (file_exists($file)) {
            Yii::$app->response->sendFile($file);
        }
    }
}
