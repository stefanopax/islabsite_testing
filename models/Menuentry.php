<?php

namespace app\models;

/**
 * This is the model class for table "menuentry".
 *
 * @property int $id
 * @property string $title
 * @property string $link
 * @property string $content
 * @property int $position
 * @property bool $is_deleted
 * @property int $staff_id
 *
 * @property Staff $staff
 */
class Menuentry extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'menuentry';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
			[['title'], 'required'],
			[['title'], 'string', 'max'=> 200],
            [['position', 'staff_id'], 'required'],
            [['is_deleted'], 'boolean'],
            [['staff_id'], 'default', 'value' => null],
            [['staff_id','position'], 'integer'],
            [['link'], 'string', 'max' => 100],
			[['content'], 'string'],            
			[['staff_id'], 'exist', 'skipOnError' => true, 'targetClass' => Staff::className(), 'targetAttribute' => ['staff_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'link' => 'Link',
            'content' => 'Content',
            'position' => 'Position',
            'is_deleted' => 'Is Deleted',
            'staff_id' => 'Staff ID',
        ];
    }

    /**
     * @return Menuentry
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);		// 'is_disabled' => 0
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaff()
    {
        return $this->hasOne(Staff::className(), ['id' => 'staff_id']);
    }

    /**
     * @return MenuEntry[]
     */
    public static function findMenuentry($id)
    {
        return Menuentry::find()->where(['staff_id'=>$id])->orderBy('position')->all();
    }

    /**
     * @param integer $id
     * @return MenuEntry[]
     */
	public static function findMenuentryPage($id)
    {
        return Menuentry::find()->where(['staff_id'=>$id])->andWhere(['is_deleted' => false])->orderBy(['position'=>SORT_ASC])->all();
    }

    /**
     * @param integer $id
     * @return void
     */
    public function softDelete()
    {
		$this-> is_deleted = true;
		$this->save();
	}

    /**
     * @param integer $position
     * @return void
     */
    public function setPosition($position)
    {
        $this-> position = $position;
    }

    public function getStaffId()
    {
        return $this->staff_id;
    }
}
