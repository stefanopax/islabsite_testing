<?php

use yii\db\Migration;

/**
 * Class m181025_084455_init_rbac
 */
class m181025_084455_init_rbac extends Migration
{
    /**
     * {@inheritdoc}
     * @throws Exception
     */
   public function safeUp()
   {
        $auth = Yii::$app->authManager;

        $student = $auth->createRole('student');
        $auth->add($student);
           
		$teacher = $auth->createRole('teacher');
        $auth->add($teacher);
           
		$staff = $auth->createRole('staff');
        $auth->add($staff);
           
        $admin = $auth->createRole('admin');
        $auth->add($admin);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $auth = Yii::$app->authManager;

        $auth->removeAll();
    }
}
