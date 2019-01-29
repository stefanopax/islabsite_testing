<?php

use yii\db\Migration;

/**
 * Class m181108_194654_create_usertemp
 */
class m181108_194654_create_usertemp extends Migration
{
     /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('usertemp', [
            'username' => $this->string(60),
            'timestamp' => $this->integer(),
        ]);
    }

    public function down()
    {
        $this->delete('usertemp');
		$this->dropTable('usertemp');
    }
}
