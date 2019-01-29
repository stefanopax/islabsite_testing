<?php

namespace app\models;

use Yii;

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
            [['title', 'description', 'link', 'image', 'is_deleted'], 'required'],
            [['created_at'], 'safe'],
            [['is_deleted'], 'boolean'],
            [['title', 'description', 'link', 'image'], 'string', 'max' => 255],
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
	public function setCreated_at(){
			
		$this->created_at = Yii::$app->formatter->asTimestamp(date('Y-d-m h:i:s'));
	}

    /**
     * @param integer $id
     * @return void
     */
	public function softDelete($id){
			
		$this->is_deleted=true;
		$this->save();
	}	
}
