<?php

use yii\db\Migration;

/**
 * Class m181025_134518_create_thesis
 */
class m181025_134518_create_thesis extends Migration
{
    /**
     * {@inheritdoc}
     * @throws \yii\base\InvalidConfigException
     */
    public function up()
    {
        $this->createTable('thesis', [
            'id' => $this->primaryKey(),
            'title' => $this->string(100)->notNull(),
            'company' => $this->string(100),
            'description' => $this->text()->notNull(),
            'duration' => $this->string(100)->notNull(),
            'requirements' => $this->string(100),
            'course' => $this->string(100)->notNull(),
            'n_person' => $this->integer()->notNull(),
            'ref_person' => $this->string(100),
            'is_visible' => $this->boolean()->defaultValue('true'),
            'created_at' => $this->dateTime(),
			'trien' => $this->boolean()->notNull(),
			'staff' => $this->integer()->notNull(),
        ]);

		$this->createIndex('idx-thesis-id','thesis','id');
        $this->addForeignKey('fk-thesis-staff','thesis','staff','staff','id','CASCADE','CASCADE');

        /* query to get user ids */
        $id1 = (new \yii\db\Query())->select(['id'])->from('user')->where(['username' => 'silvana.castano@unimi.it']);
        $id2 = (new \yii\db\Query())->select(['id'])->from('user')->where(['username' => 'stefano.montanelli@unimi.it']);

        /* insert for testing */
        $this->batchInsert('thesis', ['title', 'company', 'description', 'duration', 'requirements', 'course' , 'n_person' , 'ref_person', 'is_visible' , 'created_at', 'trien', 'staff'], [
            ['prova1','siemens','vjdfknvkjdfnkvkdf','mesi','sjbvifjkv', 'sistems','2','professore',true, Yii::$app->formatter->asDatetime(date('Y-d-m h:i:s')),true,$id1],
            ['prova2','apple','vjdfknvkjdfnkvkdf','giorni','sjbvifjkv', 'sistems','3','teacher',true, Yii::$app->formatter->asDatetime(date('Y-d-m h:i:s')),true,$id2],
        ]);
    }

    public function down()
    {
		$this->dropForeignKey('fk-thesis-staff','thesis');
        $this->dropIndex('idx-thesis-id','thesis');
		
        $this->delete('thesis');
        $this->dropTable('thesis');
    }
}
