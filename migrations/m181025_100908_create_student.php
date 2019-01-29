<?php

use yii\db\Migration;

/**
 * Class m181025_100908_create_student
 */
class m181025_100908_create_student extends Migration
{
    /**
     * {@inheritdoc}
     */
   public function up()
    {
        $this->createTable('student', [
            'id' => $this->primaryKey(),
            'register_id' => $this->integer()->unique()->notNull(),
			'mail' => $this->string(100)
        ]);

        $this->createIndex('idx-student-id','student','id');
        $this->addForeignKey('fk-student-user','student','id','user','id','CASCADE','CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('fk-student-user','student');
        $this->dropIndex('idx-student-id','student');

        $this->delete('student');
        $this->dropTable('student');
    }
}
