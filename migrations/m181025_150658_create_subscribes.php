<?php

use yii\db\Migration;

/**
 * Class m181025_150658_create_subscribes
 */
class m181025_150658_create_subscribes extends Migration
{
    /**
     * {@inheritdoc}
     */
   public function up()
    {
        $this->createTable('subscribes', [
            'exam' => $this->integer()->notNull(),
            'student' => $this->integer()->notNull(),
            'date' => $this->datetime(),
            'result' => $this->string(20)
        ]);

        $this->addPrimaryKey('pk-subscribes','subscribes',['exam','student']);

        $this->addForeignKey('fk-subscribes-exam','subscribes','exam','exam','id','CASCADE','CASCADE');
        $this->addForeignKey('fk-subscribes-student','subscribes','student','student','id','CASCADE','CASCADE');

        /* insert for testing*/
    }

    public function down()
    {
        $this->dropPrimaryKey('pk-subscribes','subscribes');

        $this->dropForeignKey('fk-subscribes-exam','subscribes');
        $this->dropForeignKey('fk-subscribes-student','subscribes');

        $this->delete('subscribes');
        $this->dropTable('subscribes');
    }
}
