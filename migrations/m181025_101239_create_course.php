<?php

use yii\db\Migration;

/**
 * Class m181025_101239_create_course
 */
class m181025_101239_create_course extends Migration
{
    /**
     * {@inheritdoc}
     */
     public function up()
    {
        $this->createTable('course', [
            'id' => $this->primaryKey(),
            'title' => $this->string(100)->notNull(),
            'is_active' => $this->boolean()->defaultValue('true')
        ]);

        /* insert for testing*/
        $this->insert('course',[
            'title' => 'Basi di dati',
            'is_active' => true
        ]);
        $this->insert('course',[
            'title' => 'Sistemi informativi',
            'is_active' => true
        ]);
    }

    public function down()
    {
        $this->delete('course');
        $this->dropTable('course');
    }
}
