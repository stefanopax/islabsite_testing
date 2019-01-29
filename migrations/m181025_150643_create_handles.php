<?php

use yii\db\Migration;

/**
 * Class m181025_150643_create_handles
 */
class m181025_150643_create_handles extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('handles', [
            'staff' => $this->integer()->notNull(),
            'course' => $this->integer()->notNull()
        ]);

        $this->addPrimaryKey('pk-handles','handles',['staff','course']);

        $this->addForeignKey('fk-handles-staff','handles','staff','staff','id','CASCADE','CASCADE');
        $this->addForeignKey('fk-handles-course','handles','course','course','id','CASCADE','CASCADE');

        /* insert for testing*/
        $id_staff = (new \yii\db\Query())->select(['id'])->from('user')->where(['username' => 'marco.frasca@unimi.it']);
        $id_course = (new \yii\db\Query())->select(['id'])->from('course')->where(['title' => 'Basi di dati']);
        $this->batchInsert('handles', ['staff', 'course'], [
            [$id_staff, $id_course]
        ]);

        $id_staff = (new \yii\db\Query())->select(['id'])->from('user')->where(['username' => 'alfio.ferrara@unimi.it']);
        $id_course = (new \yii\db\Query())->select(['id'])->from('course')->where(['title' => 'Basi di dati']);
        $this->batchInsert('handles', ['staff', 'course'], [
            [$id_staff, $id_course]
        ]);
        
        $id_staff = (new \yii\db\Query())->select(['id'])->from('user')->where(['username' => 'silvana.castano@unimi.it']);
        $id_course = (new \yii\db\Query())->select(['id'])->from('course')->where(['title' => 'Sistemi informativi']);
        $this->batchInsert('handles', ['staff', 'course'], [
            [$id_staff, $id_course]
        ]);
    }

    public function down()
    {
        $this->dropPrimaryKey('pk-handles','handles');

        $this->dropForeignKey('fk-handles-course','handles');
        $this->dropForeignKey('fk-handles-staff','handles');

        $this->delete('handles');
        $this->dropTable('handles');
    }
}
