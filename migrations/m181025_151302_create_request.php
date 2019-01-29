<?php

use yii\db\Migration;

/**
 * Class m181025_151302_create_request
 */
class m181025_151302_create_request extends Migration
{
    /**
     * {@inheritdoc}
     */
   public function up()
    {
        $this->createTable('request', [
            'thesis' => $this->integer()->notNull(),
            'student' => $this->integer()->notNull(),
            'title' => $this->string(100),
			'created_at' => $this->dateTime(),
			'confirmed_at' => $this->boolean()->defaultValue('false'),
        ]);

        $this->addPrimaryKey('pk-request', 'request', ['thesis','student']);

        $this->addForeignKey('fk-request-student', 'request', 'student', 'student', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-request-thesis', 'request', 'thesis', 'thesis', 'id', 'CASCADE', 'CASCADE');

        /* insert for testing*/
    }

    public function down()
    {
        $this->dropPrimaryKey('pk-request', 'request');

        $this->dropForeignKey('fk-request-student', 'request');
        $this->dropForeignKey('fk-request-thesis', 'request');

        $this->delete('request');
        $this->dropTable('request');
    }
}
