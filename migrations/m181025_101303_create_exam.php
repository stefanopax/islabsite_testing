<?php

use yii\db\Migration;

/**
 * Class m181025_101303_create_exam
 */
class m181025_101303_create_exam extends Migration
{
    /**
     * {@inheritdoc}
     */
     public function up()
    {
        $this->createTable('exam', [
            'id' => $this->primaryKey(),
            'title' => $this->string(50)->notNull(),
            'date' => $this->datetime(),
            'opening_date' => $this->datetime(),
            'closing_date' => $this->datetime(),
            'type' => $this->string(30)->notNull(),
            'info' => $this->text(),
            'course' => $this->integer()->notNull()
        ]);

        $this->createIndex('idx-exam-id','exam','id');
        $this->addForeignKey('fk-exam-course','exam','course','course','id','CASCADE','CASCADE');

        /* insert for testing*/
        $this->insert('exam', [
            'id' => '1',
            'title' => 'Database',
            'date' => '27/06/2018',
            'opening_date' => '12/06/2018',
            'closing_date' => '20/06/2018',
            'type' => 'Orale',
            'info' => 'Prova di esame orale',
            'course' => '1'
        ]);
		
		$this->insert('exam', [
            'id' => '2',
            'title' => 'Sistemi informativi',
            'date' => '27/06/2018',
            'opening_date' => '12/06/2018',
            'closing_date' => '20/06/2018',
            'type' => 'Orale',
            'info' => 'Prova di esame scritto',
            'course' => '2'
        ]);
    }

    public function down()
    {
        $this->dropForeignKey('fk-exam-course','exam');
        $this->dropIndex('idx-exam-id','exam');

        $this->delete('exam');
        $this->dropTable('exam');
    }
}
