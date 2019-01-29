<?php

use yii\db\Migration;

/**
 * Class m181117_125920_create_menuentry
 */
class m181117_125920_create_menuentry extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('menuentry', [
            'id' => $this->primaryKey(),
			'title' => $this->string(200)->notNull(),
            'link' => $this->string(100),
            'content' => $this->text(),
            'position' => $this->integer(10)->notNull(),
            'is_deleted' => $this->boolean()->defaultValue('false')->notNull(),
            'staff_id' => $this->integer()->notNull()
        ]);

        $this->addForeignKey('fk-menuentry-staff', 'menuentry', 'staff_id', 'staff', 'id', 'CASCADE', 'CASCADE');

        /* query to get staff id */
        $id1 = (new \yii\db\Query())->select(['id'])->from('user')->where(['username' => 'silvana.castano@unimi.it']);

        /* insert for testing */
        $this->batchInsert('menuentry', ['title', 'link', 'content', 'position','is_deleted', 'staff_id'], [
            ['Publications on DBLP','https://dblp.uni-trier.de/pers/hd/c/Castano:Silvana', NULL,0, false, $id1],
            ['Publications on Google Scholar','https://scholar.google.it/citations?user=A1Wik1IAAAAJ&hl=it', NULL, 1, false, $id1],
            ['Teaching', NULL, 'teaching', 2, false, $id1],
            ['Events', NULL, 'event', 3, false, $id1],
            ['News','http://islab.di.unimi.it/iNewsMail/feed.php?channel=castano', NULL, 4, false, $id1],
        ]);
    }

    public function down()
    {
        $this->dropForeignKey('fk-menuentry-staff', 'menuentry');

        $this->delete('menuentry');
        $this->dropTable('menuentry');
    }
}
