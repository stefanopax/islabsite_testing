<?php

namespace app\models;

use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * This is the model class for table "{{%staff}}".
 *
 * @property int $id
 * @property string $cellphone
 * @property string $phone
 * @property string $mail
 * @property string $room
 * @property string $address
 * @property string $image
 * @property string $fax
 * @property string $role
 * @property string $description
 * @property string $link
 *
 * @property Handles[] $handles
 * @property Course[] $courses
 * @property User $id0
 * @property Thesis[] $theses
 */
class Staff extends \yii\db\ActiveRecord
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
        return '{{%staff}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => false],
            [['image'], 'required'],
            [['description'], 'string'],
            [['cellphone', 'phone', 'fax'], 'string', 'max' => 20],
            [['address', 'room', 'mail', 'role', 'link', 'image'], 'string', 'max' => 100],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id' => 'id']],
            [['image'], 'file', 'extensions' => 'png, jpg, bmp, gif']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cellphone' => 'Cellphone',
            'phone' => 'Phone',
            'mail' => 'Mail',
            'room' => 'Room',
            'address' => 'Address',
            'image' => 'Image',
            'fax' => 'Fax',
            'role' => 'Role',
            'description' => 'Description',
			'link' => 'Link',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHandles()
    {
        return $this->hasMany(Handles::className(), ['staff' => 'id']);
    }

	public function setId($id)
	{
		$this->id = $id;
	}
	
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCourses()
    {
        return $this->hasMany(Course::className(), ['id' => 'course'])->viaTable('{{%handles}}', ['staff' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getId0()
    {
        return $this->hasOne(User::className(), ['id' => 'id']);
    }
	
	/**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
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
     * @return Staff
     */
	public static function findStaff($id)
    {
        return static::findOne(['id' => $id]);		
	}

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTheses()
    {
        return $this->hasMany(Thesis::className(), ['staff' => 'id']);
    }

    /**
     * @param $role
     * @return void
     * @throws NotFoundHttpException
     */
	public function assignRole($role)
	{
		$auth = \Yii::$app->authManager;
		if(isset($role)) {
			$authRole = $auth->getRole($role);		
			$auth->revokeAll($this->getId());
			if($authRole) {
				$auth->assign($authRole, $this->getId());    
			}
		}
		else {
			 throw new NotFoundHttpException('The requested page does not exist.');
		}
	}

    /**
     * @param integer $id
     * @return bool
     */
    public function upload($id)
    {
        if($this->validate()) {
            $this->imageFile->name = 'staff'. $id . $this->imageFile->baseName. '.' . $this->imageFile->extension;
            try {
                $this->imageFile->saveAs('img/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);
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
