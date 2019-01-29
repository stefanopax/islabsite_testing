<?php

use yii\db\Migration;

/**
 * Class m181025_100835_create_user
 */
class m181025_100835_create_user extends Migration
{
    /**
     * {@inheritdoc}
     * @throws \yii\base\Exception
     */
    public function up()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'username' => $this->string(100)->unique(),
            'password' => $this->string(350),
            'authkey' => $this->string(350)->notNull(),
            'name' => $this->string(100)->notNull(),
            'surname' => $this->string(100)->notNull(),
            'is_disabled' => $this->boolean()->defaultValue('false')
        ]);

    /* insert for testing */
		$this->batchInsert('user', ['username', 'authkey', 'name', 'surname', 'is_disabled'], [
            ['silvana.castano@unimi.it',Yii::$app->security->generateRandomString(),'Silvana','Castano',false],	//staff
            ['alfio.ferrara@unimi.it',Yii::$app->security->generateRandomString(),'Alfio','Ferrara',false],
            ['stefano.montanelli@unimi.it',Yii::$app->security->generateRandomString(),'Stefano','Montanelli',false], //admin
            ['marco.frasca@unimi.it',Yii::$app->security->generateRandomString(),'Marco','Frasca',false],	// teacher
           ]);

    }

    public function down()
    {
        $this->delete('user');
        $this->dropTable('user');
    }
}
