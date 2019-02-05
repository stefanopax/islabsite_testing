<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "{{%project}}".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $link
 * @property integer $created_at
 * @property string $image
 * @property bool $is_deleted
 */
class Project extends \yii\db\ActiveRecord
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
        return '{{%project}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => false],
            [['title', 'description', 'link', 'image', 'is_deleted'], 'required'],
            [['created_at'], 'safe'],
            [['is_deleted'], 'boolean'],
            [['title', 'description', 'link', 'image'], 'string', 'max' => 255],
            [['image'], 'file', 'extensions' => 'png, jpg, bmp, gif'],
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
            'description' => 'Description',
            'link' => 'Link',
            'created_at' => 'Created At',
            'image' => 'Image',
            'is_deleted' => 'Is Deleted',
        ];
    }

    /**
     * @return void
     */
	public function setCreated_at()
    {
		$this->created_at = Yii::$app->formatter->asTimestamp(date('Y-d-m h:i:s'));
	}

    /**
     * @return void
     */
    public function setId()
    {
        $this->id = Project::find()->select('id')->max('id')+1;
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
	public function softDelete($id)
    {
		$this->is_deleted = true;
		$this->save(false);
	}

    /**
     * @param integer $id
     * @return bool
     */
    public function upload($id)
    {
        if($this->validate()) {
            $this->imageFile->name = 'project'. $id . $this->imageFile->baseName. '.' . $this->imageFile->extension;
            try {
                $this->imageFile->saveAs('img/' . $this->imageFile->baseName. '.' . $this->imageFile->extension);
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
}
