<?php

use yii\db\Migration;

/**
 * Class m181025_150721_create_registers
 */
class m181025_150721_create_registers extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('registers', [
            'student' => $this->integer()->notNull(),
            'course_site' => $this->integer()->notNull(),
            'date' => $this->datetime()->notNull()
        ]);

        $this->addPrimaryKey('pk-registers', 'registers', ['student','course_site']);

        $this->addForeignKey('fk-registers-student', 'registers', 'student', 'student', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-registers-course_site', 'registers', 'course_site', 'course_site', 'id', 'CASCADE', 'CASCADE');

        /* insert for testing*/
    }

    public function down()
    {
        $this->dropPrimaryKey('pk-registers', 'registers');

        $this->dropForeignKey('fk-registers-student', 'registers');
        $this->dropForeignKey('fk-registers-course_site', 'registers');

        $this->delete('registers');
        $this->dropTable('registers');
    }
}
