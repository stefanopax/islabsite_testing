<?php

use yii\db\Migration;

/**
 * Class m190113_094510_create_file
 */
class m190113_094510_create_file extends Migration
{

    public function up()
    {
        $this->createTable('file', [
            'id' => $this->primaryKey(),
            'title' => $this->string(200),
            'extension' => $this->string(20),
            'is_public' => $this->boolean()->defaultValue('false'),
            'course_site' => $this->integer()->notNull()
        ]);

        $this->createIndex('idx-file','file','id');
        $this->addForeignKey('fk-file-course-site', 'file', 'course_site', 'course_site', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('fk-file-course-site', 'file');
        $this->dropIndex('idx-file','file');
        $this->delete('file');
        $this->dropTable('file');
    }
}
