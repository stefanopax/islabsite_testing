<?php

use yii\db\Migration;

/**
 * Class m181025_085426_rbac_rules
 */
class m181025_085426_rbac_rules extends Migration
{
    /**
     * {@inheritdoc}
     * @throws Exception
     */
   public function safeUp()
   {
        $auth = Yii::$app->authManager;
        $admin=$auth->getRole('admin');
        $student=$auth->getRole('student');
        $staff=$auth->getRole('staff');
        $teacher=$auth->getRole('teacher');

        $edit = $auth->createPermission('edit');
        $auth->add($edit);
        $auth->addChild($admin,$edit);

        $view = $auth->createPermission('view');
        $auth->add($view);
        $auth->addChild($admin,$view);
        $auth->addChild($student,$view);
        $auth->addChild($teacher,$view);
        $auth->addChild($staff,$view);

        $create = $auth->createPermission('create');
        $auth->add($create);
        $auth->addChild($admin,$create);

        $delete = $auth->createPermission('delete');
        $auth->add($delete);
        $auth->addChild($admin,$delete);
	}

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $auth = Yii::$app->authManager;
        $permission=$auth->getPermission('edit');
        $auth->remove($permission);
        $permission=$auth->getPermission('create');
        $auth->remove($permission);
        $permission=$auth->getPermission('view');
        $auth->remove($permission);
		$permission=$auth->getPermission('delete');
        $auth->remove($permission);
    }
}
