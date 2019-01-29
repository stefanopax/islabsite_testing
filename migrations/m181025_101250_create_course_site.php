<?php

use yii\db\Migration;

/**
 * Class m181025_101250_create_course_site
 */
class m181025_101250_create_course_site extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('course_site', [
            'id' => $this->primaryKey(),
            'title' => $this->string(100)->notNull(),
            'edition' => $this->string(100)->notNull(),
            'opening_date' => $this->datetime(),
            'closing_date' => $this->datetime(),
            'css' => $this->text(),
            'feed' => $this->text(),
            'is_current' => $this->boolean()->defaultValue('false'),
            'course' => $this->integer()->notNull()
		]);

        $this->createIndex('idx-course_site-id','course_site','id');
        $this->addForeignKey('fk-course_site-course','course_site','course','course','id','CASCADE','CASCADE');

        /* query to get course ids */
        $id1 = (new \yii\db\Query())->select(['id'])->from('course')->where(['title' => 'Basi di dati']);
        $id2 = (new \yii\db\Query())->select(['id'])->from('course')->where(['title' => 'Sistemi informativi']);

        /* insert for testing*/
        $this->batchInsert('course_site', ['title', 'edition', 'opening_date', 'closing_date', 'css', 'is_current', 'course'], [
            ['Basi di dati', '2018/2019', '10/10/2018', '10/10/2019', 'my css code', true, $id1],
            ['Basi di dati', '2017/2018', '10/10/2017', '10/10/2018', 'my css code', false, $id1],
            ['Sistemi informativi', '2018/2019', '10/10/2018', '10/10/2019', 'my css code', true, $id2],
            ['Sistemi informativi', '2017/2018', '10/10/2017', '10/10/2018', 'my css code', false, $id2]
        ]);
    }

    public function down()
    {
        $this->dropForeignKey('fk-course_site-course','course_site');
        $this->dropIndex('idx-course_site-id','course_site');

        $this->delete('course_site');
        $this->dropTable('course_site');
    }
}
